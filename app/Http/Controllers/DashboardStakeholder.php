<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardStakeholder extends Controller
{
    public function index(){
        return view('stakeholder.dashboard.index');
    }
}
