<?php

namespace Tmas\AdvancedSquadFilters\Services;
use Seat\Web\Models\GroupQueryBuilder;
use Seat\Web\Models\Squads\Squad;
use Seat\Eveapi\Models\RefreshToken;
use Illuminate\Database\Eloquent\Builder;
use Tmas\AdvancedSquadFilters\Contracts\AdvancedFilterContract;

class SquadFilterService
{

    /**
     * Applies a filter group to $query.
     *
     * @param  Builder  $query  the query to add the filter group to
     * @param  stdClass  $group  the filter group configuration
     *
     * @throws InvalidFilterException
     */
    private function applyGroup(Builder $query, stdClass $group): void
    {
        $query_group = new QueryGroupBuilder($query, property_exists($group, 'and'));
        $filters = $query_group->isAndGroup() ? $group->and : $group->or;

        foreach ($filters as $filter) {
            // check if this is a nested group or not
            if (property_exists($filter, 'class')) {
                $this->applyFilter($query_group, $filter);
            } else {
                // this is a nested group
                $query_group->where(function ($group_query) use ($filters) {
                    $this->applyGroup($group_query, $filters);
                });
            }
        }
    }

    /**
     * Applies a filter to a query group.
     *
     * @param  QueryGroupBuilder  $query  the query to add the rule to
     * @param  stdClass  $filter  the filter configuration
     *
     * @throws InvalidFilterException
     */
    private function applyFilter(QueryGroupBuilder $query, stdClass $filter): void
    {
        if (!class_exists($filter->class)) {
            throw new InvalidFilterException(sprintf('Unknown filter: \'%s\'', $filter->class));
        }

        if (!is_a($filter->class, AdvancedFilterContract::class, true)) {
            throw new InvalidFilterException(sprintf('Filter must implement AdvancedFilterContract: \'%s\'', $filter->class));
        }

        $filterInstance = new $filter->class($filter);

        $filterInstance->apply($query);
    }


    public function getBaseQuery(Squad $squad): GroupQueryBuilder
    {
        // in case no filters exists, everyone should be allowed
        // this is the case with manual squads
        if (! property_exists($squad->getFilters(), 'and') && ! property_exists($squad->getFilters(), 'or'))
            return true;

        $query = new QueryGroupBuilder(RefreshToken::query(), true);

        // wrap this in an inner query to ensure it is '(correct_entity_check) AND (rule1 AND/OR rule2)'
        $query->whereHas('characters', function ($inner_query) use ($squad) {
            $this->applyGroup($inner_query, $squad->getFilters());
        });

        return $query->getUnderlyingQuery();
    }

    public function getSingleQuery(Squad $squad, RefreshToken $user): GroupQueryBuilder
    {
        $query = $this->getBaseQuery($squad);

        // make sure we only allow results of the entity we are checking
        $query->where($user->getKeyName(), $user->getKey());

        return $query;
    }

    public function isEligible(Squad $squad, RefreshToken $user): bool
    {
        $query = $this->getSingleQuery($squad, $user);

        return $query->getUnderlyingQuery()->exists();
    }

    public function getEligibleUsers(Squad $squad): array
    {
        $query = $this->getBaseQuery($squad);

        return $query
            ->getUnderlyingQuery()
            ->lazy(config('advanced-squad-filers.config.chunkSize', 1000))
            ->pluck((new RefreshToken)->getKeyName())
            ->toArray();
    }
    
}