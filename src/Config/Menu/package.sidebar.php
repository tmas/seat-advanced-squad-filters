<?php

return [
    'advanced-squad-filters' => [
        'name' => 'Advanced Squad Filters',
        'icon' => 'fas fa-cogs',
        'route_segment' => 'advanced-squad-filters',
        'entries' => [
            [
                'name' => 'Home',
                'icon' => 'fas fa-home',
                'route' => 'advanced-squad-filters.index',
                'permission' => 'advanced-squad-filters.view'
            ]
        ]
    ]
]; 