<?php

namespace Tmas\AdvancedSquadFilters\Filters\Legacy;

use Tmas\AdvancedSquadFilters\Filters\LegacyFilter;

class AllianceFilter extends LegacyFilter {
    public static array $legacyFilterDefinition = [
        'name' => 'alliance',
        'src' => 'seatcore::fastlookup.alliances',
        'path' => 'affiliation',
        'field' => 'alliance_id',
        'label' => 'Alliance'
    ];
}