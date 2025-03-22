<?php

namespace Tmas\AdvancedSquadFilters\Filters;

use Tmas\AdvancedSquadFilters\Contracts\AdvancedFilterContract;
use Seat\Web\Models\QueryGroupBuilder;
use Carbon\Carbon;

class SkillLevelFilter implements AdvancedFilterContract
{
    public string $skill;
    public string $skillLevel;
    public string $operator;

    public function __construct(stdClass $filterConfig)
    {
        $this->skill = $filterConfig->skill;
        $this->skillLevel = $filterConfig->skillLevel;
        $this->operator = $filterConfig->operator;
    }

    public function resolveOperator(): string
    {
        return match($this->operator) {
            '<>' => '=',
            '!=' => '=',
            default => $this->operator
        };
    }

    public function apply(GroupQueryBuilder $query): GroupQueryBuilder
    {
        // 'is' operator
        if ($this->operator === '=' || $this->operator === '<' || $this->operator === '>') {
            // normal comparison operations need to relation to exist
            $query->whereHas('skills', function (Builder $inner_query) use ($rule, $skrule) {
                $inner_query->where(function ($q) use ($rule, $skrule) {
                    $q->where('skill_id', '=', $this->skill)
                        ->where('trained_skill_level', $this->resolveOperator(), $this->skillLevel);
                });
            });
        } elseif ($rule->operator === '<>' || $rule->operator === '!=') {
            // not equal is special cased since a missing relation is the same as not equal
            $query->whereDoesntHave($rule->path, function (Builder $inner_query) use ($rule, $skrule) {
                $q->where('skill_id', '=', $this->skill)
                    ->where('trained_skill_level', $this->resolveOperator(), $this->skillLevel);
            });
        } else {
            throw new InvalidFilterException(sprintf('Unknown rule operator: \'%s\'', $rule->operator));
        }

        return $query;
    }

    public static function getLabel(): string
    {
        return 'Skill Level';
    }

    public static function getFields(): array
    {
        return [
            [
                'name' => 'skill',
                'label' => 'Skill',
                'fieldType' => 'lookup',
                'src' => 'seatcore::fastlookup.skills',
            ],
            [
                'name' => 'operator',
                'label' => 'Operator',
                'fieldType' => 'Dropdown',
                'options' => [
                    '=' => 'Is',
                    '<>' => 'Is Not',
                    '>' => 'Is Greater Than',
                    '<' => 'Is Less Than',
                ],
            ],
            [
                'name' => 'skillLevel',
                'label' => 'Skill Level',
                'fieldType' => 'dropdown',
                'options' => [
                    '1' => 'Level 1',
                    '2' => 'Level 2',
                    '3' => 'Level 3',
                    '4' => 'Level 4',
                    '5' => 'Level 5',
                ],
            ],
        ];
    }
}