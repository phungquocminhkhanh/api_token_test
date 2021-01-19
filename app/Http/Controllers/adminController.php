<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class adminController extends Controller
{
    public function view_manage_agent()
    {
        return view('admin.agent');
    }

}
