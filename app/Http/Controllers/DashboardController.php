<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function superAdminLogin()
    {
        //this serves the login page
        return view('dashboard.superadmin.login');
    }

    public function superAdminDashboard()
    {
      
        // this serves the dashboard 
        return view('dashboard.superadmin.index');
    }

    public function adminLogin()
    {
        //this serves the login page
        return view('dashboard.admin.login');
    }

    public function adminDashboard()
    {
        // this serves the dashboard 
        return view('dashboard.admin.index');
    }
}