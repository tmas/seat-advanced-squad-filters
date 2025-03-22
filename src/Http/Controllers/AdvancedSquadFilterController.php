<?php

namespace Tmas\AdvancedSquadFilters\Http\Controllers;

use Seat\Web\Http\Controllers\Controller;

class AdvancedSquadFilterController extends Controller
{
    /**
     * Display the main page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('advanced-squad-filters::index');
    }
} 