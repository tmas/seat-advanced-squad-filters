<?php

namespace Tmas\AdvancedSquadFilters\Filters\Legacy;

use Tmas\AdvancedSquadFilters\Filters\LegacyFilter;

class ItemFilter extends LegacyFilter {
    public static array $legacyFilterDefinition = [
        'name' => 'type',
        'src' => 'seatcore::fastlookup.items',
        'path' => 'assets',
        'field' => 'type_id',
        'label' => 'Item'
    ];
}