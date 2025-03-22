<?php

namespace Tmas\AdvancedSquadFilters\Filters\Legacy;

use Tmas\AdvancedSquadFilters\Filters\LegacyFilter;

class CorporationFilter extends LegacyFilter {
    public static array $legacyFilterDefinition = [
        'name' => 'corporation',
        'src' => 'seatcore::fastlookup.corporations',
        'path' => 'affiliation',
        'field' => 'corporation_id',
        'label' => 'Corporation'
    ];
}