<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function redirect(): RedirectResponse
    {
        return auth()->user()->role === UserRole::Admin
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    }

    public function admin(): View
    {
        return view('dashboard.admin');
    }

    public function user(): View
    {
        return view('dashboard.user');
    }
}
