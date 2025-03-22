<?php

/*
 * This file is part of SeAT
 *
 * Copyright (C) 2015 to present Leon Jacobs
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */

namespace Tmas\AdvancedSquadFilters\Http\Composers;

use Illuminate\View\View;
use Tmas\AdvancedSquadFilters\Contracts\AdvancedFilterContract;

class AdvancedCharacterFilter
{
    public function compose(View $view)
    {
        $filters = config('advanced-squad-filters.characterfilter');

        // work with raw arrays since the filter code requires an array of objects, and laravel collections don't like to give us that
        $newfilters = [];
        foreach ($filters as $filter) {
            // convert route names to urls, but keep arrays with hardcoded options
            if(is_string($filter['src'])){
                $filter['src'] = route($filter['src']);
            }
            $newfilters[] = (object) $filter;
        }

        $view->with('characterFilterFilters', $newfilters);
    }

    public function advancedFilterToArray(string $filterClass)
    {
        if (!class_exists($filterClass)) {
            throw new \Exception("Filter class {$filterClass} does not exist");
        }

        if (!is_a($filterClass, AdvancedFilterContract::class, true)) {
            throw new \Exception("Filter class {$filterClass} does not implement AdvancedFilterContract");
        }

        return [
            'class' => $filterClass,
            'name' => $filterClass::getName(),
            'label' => $filterClass::getLabel(),
            'fields' => collect($filterClass::getFields())
                ->map(function ($field) {
                    return $this->resolveFieldWithRouteURL($field);
                })
                ->toArray(),
        ];
    }

    public function resolveFieldWithRouteURL(array $field) {
        if (array_key_exists('src', $field) && is_string($field['src'])) {
            $field['src'] = route($field['src']);
        }

        return $field;
    }
}
