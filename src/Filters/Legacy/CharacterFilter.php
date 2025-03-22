<?php

namespace Tmas\AdvancedSquadFilters\Filters\Legacy;

use Tmas\AdvancedSquadFilters\Filters\LegacyFilter;

class CharacterFilter extends LegacyFilter {
    public static array $legacyFilterDefinition = [
        'name' => 'character',
        'src' => 'seatcore::fastlookup.characters',
        'path' => '',
        'field' => 'character_id',
        'label' => 'Character'
    ];
}