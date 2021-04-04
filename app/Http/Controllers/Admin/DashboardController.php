<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function store(Request $request)
    {
        dd('working');
    }

    public function update()
    {
        dd('working');
    }

    public function delete()
    {
        dd('working');
    }
}
