<?php

namespace Tmas\AdvancedSquadFilters\Filters\Legacy;

use Tmas\AdvancedSquadFilters\Filters\LegacyFilter;

class FactionFilter extends LegacyFilter {
    public static array $legacyFilterDefinition = [
        'name' => 'factions',
        'src' => 'seatcore::fastlookup.factions',
        'path' => 'affiliation',
        'field' => 'faction_id',
        'label' => 'Faction'
    ];
}