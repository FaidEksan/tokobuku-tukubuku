<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the dashboard for customer.
     */
    public function index()
    {
        // Pastikan user adalah admin
        if (Auth::user()->hasRole('customer')) {
            return view('customer.dashboard.index', ['user' => Auth::user()]);
        }
    }
}