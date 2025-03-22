<?php

namespace Tmas\AdvancedSquadFilters\Filters\Legacy;

use Tmas\AdvancedSquadFilters\Filters\LegacyFilter;

class TitleFilter extends LegacyFilter {
    public static array $legacyFilterDefinition = [
        'name' => 'title',
        'src' => 'seatcore::fastlookup.titles',
        'path' => 'titles',
        'field' => 'id',
        'label' => 'Title'
    ];
}