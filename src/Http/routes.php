<?php

Route::group([
    'namespace' => 'Tmas\AdvancedSquadFilters\Http\Controllers',
    'prefix' => 'advanced-squad-filters',
    'middleware' => ['web', 'auth', 'locale'],
], function () {
    Route::get('/', [
        'as' => 'advanced-squad-filters.index',
        'uses' => 'AdvancedSquadFilterController@index',
        'middleware' => 'can:advanced-squad-filters.view'
    ]);
}); 