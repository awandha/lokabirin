<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MenuItem;

class MenuController extends Controller
{
    public function index()
    {
        $menuItems = MenuItem::paginate(10);
        return view('admin.menus.index', compact('menuItems'));
    }
}
