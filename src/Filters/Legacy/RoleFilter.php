<?php

namespace Tmas\AdvancedSquadFilters\Filters\Legacy;

use Tmas\AdvancedSquadFilters\Filters\LegacyFilter;

class RoleFilter extends LegacyFilter {
    public static array $legacyFilterDefinition = [
        'name' => 'role',
        'src' => 'seatcore::fastlookup.roles',
        'path' => 'corporation_roles',
        'field' => 'role',
        'label' => 'Role'
    ];
}