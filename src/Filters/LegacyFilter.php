<?php

namespace Tmas\AdvancedSquadFilters\Filters;

use Tmas\AdvancedSquadFilters\Contracts\AdvancedFilterContract;

abstract class LegacyFilter implements AdvancedFilterContract
{
    public stdClass $filterConfig;
    public static array $legacyFilterDefinition;

    public function __construct(stdclass $filterConfig)
    {
        $this->filterConfig = $filterConfig;
    }

    public function apply(GroupQueryBuilder $query): GroupQueryBuilder
    {
        // 'is' operator
        if ($this->filterConfig->operator === '=' || $this->filterConfig->operator === '<' || $this->filterConfig->operator === '>') {
            // normal comparison operations need to relation to exist
            $query->whereHas($this->filterConfig->path, function (Builder $inner_query) {
                $inner_query->where($this->filterConfig->field, $this->filterConfig->operator, $this->filterConfig->criteria);
            });
        } elseif ($this->filterConfig->operator === '<>' || $this->filterConfig->operator === '!=') {
            // not equal is special cased since a missing relation is the same as not equal
            $query->whereDoesntHave($this->filterConfig->path, function (Builder $inner_query) {
                $inner_query->where($this->filterConfig->field, $this->filterConfig->criteria);
            });
        } elseif ($this->filterConfig->operator === 'contains') {
            // contains is maybe a misleading name, since it actually checks if json contains a value
            $query->whereHas($this->filterConfig->path, function (Builder $inner_query) {
                $inner_query->whereJsonContains($this->filterConfig->field, $this->filterConfig->criteria);
            });
        } else {
            throw new InvalidFilterException(sprintf('Unknown rule operator: \'%s\'', $this->filterConfig->operator));
        }

        return $query;
    }

    public static function getLabel(): string
    {
        return static::$legacyFilterDefinition['label'];
    }

    public static function getFields(): array
    {
        return [
            [
                'name' => 'operator',
                'label' => 'Operator',
                'fieldType' => 'Dropdown',
                'options' => [
                    '=' => 'Is',
                    '<>' => 'Is Not',
                    '>' => 'Is Greater Than',
                    '<' => 'Is Less Than',
                    'contains' => 'Contains',
                ],
            ],
            array_merge(
                [
                    'name' => 'criteria',
                    'label' => 'Criteria',
                    'fieldType' => is_string(static::$legacyFilterDefinition['src']) ? 'lookup' : 'dropdown',
                ],
                is_string(static::$legacyFilterDefinition['src'])
                    ? ['src' => static::$legacyFilterDefinition['src']]
                    : ['options' => static::$legacyFilterDefinition['src']]
            ),
        ];
    }
}