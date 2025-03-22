<?php

namespace Tmas\AdvancedSquadFilters\Filters;

use Tmas\AdvancedSquadFilters\Contracts\AdvancedFilterContract;
use Seat\Web\Models\QueryGroupBuilder;
use Carbon\Carbon;

class CorporationDurationFilter implements AdvancedFilterContract
{
    public string $corporation;
    public string $durationDays;
    public string $operator;

    public function __construct(stdClass $filterConfig)
    {
        $this->corporation = $filterConfig->corporation;
        $this->durationDays = $filterConfig->durationDays;
        $this->operator = $filterConfig->operator;
    }

    public function inverseOperator(): string
    {
        return match($this->operator) {
            '>=' => '<',
            '<' => '>'
        };
    }

    public function apply(GroupQueryBuilder $query): GroupQueryBuilder
    {
        $cutoffDate = Carbon::now()->subDays($this->durationDays);

        return $query
            ->whereHas('corporation_history', function ($query) use ($cutoffDate) {
                $query->where('corporation_id', $this->corporation)
                ->where('start_date', $this->inverseOperator(), $cutoffDate)
                ->whereNotNull('character_id')
                ->whereRaw('EXISTS (SELECT id FROM character_affiliations WHERE character_affiliations.character_id = character_corporation_histories.character_id AND character_affiliations.corporation_id = character_corporation_histories.corporation_id)');
            });
    }

    public static function getLabel(): string
    {
        return 'Corporation Duration';
    }

    public static function getFields(): array
    {
        return [
            [
                'name' => 'corporation',
                'label' => 'Corporation',
                'fieldType' => 'lookup',
                'src' => 'seatcore::fastlookup.corporations',
            ],
            [
                'name' => 'operator',
                'label' => 'Operator',
                'fieldType' => 'Dropdown',
                'options' => [
                    '>=',
                    '<',
                ],
            ],
            [
                'name' => 'durationDays',
                'label' => 'Days',
                'fieldType' => 'text',
                'validationType' => 'int',
            ],
        ];
    }
}