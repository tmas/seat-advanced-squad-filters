<?php

namespace Tmas\AdvancedSquadFilters\Filters\Legacy;

use Tmas\AdvancedSquadFilters\Filters\LegacyFilter;

class ScopeFilter extends LegacyFilter {
    public static array $legacyFilterDefinition = [
        'name' => 'scopes',
        'src' => 'seatcore::fastlookup.scopes',
        'path' => 'refresh_token',
        'field' => 'scopes',
        'label' => 'Scopes'
    ];
}