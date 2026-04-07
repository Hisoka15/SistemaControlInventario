<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    function index() {
        $roles = Role::with('role_permission')->get();
        $permissions = Permission::all();
        return view('configuration.index', compact('roles', 'permissions'));
    }
}
