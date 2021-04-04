<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        return view('admin.service');
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

