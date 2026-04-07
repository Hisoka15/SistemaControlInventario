<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    function register(Request $request)
    {
        $user = new User([
            'name' => $request->name . ' ' . $request->lastname,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => 2
        ]);

        $user->save();

        return redirect()->route('login');
    }

    function login(Request $request)
    {
        if(!Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
            return redirect()->back()->with('error', 'Invalid credentials');
        }

        $user = Auth::user();
        $user->last_login = now();
        $user->save();

        \auth()->user()->tokens()->delete();
        \auth()->user()->createToken('token')->plainTextToken;

        $redirectWhenPermission = [
            'view_dashboard_admin' => 'dashboard',
            'view_sales' => 'sales.index',
            'view_reports' => 'reports.index',
        ];

        foreach($redirectWhenPermission as $permission => $route)
        {
            if($this->check_permission($permission))
            {
                return redirect()->route($route);
            }
        }

        return redirect()->route('information.index');
    }

    function check_permission($permission)
    {
        $user = auth()->user();
        $role = $user->role;
        $permission_id = Permission::where('name', $permission)->first()->id;
        if($role->hasPermission($permission_id))
        {
            return true;
        }
        return false;
    }

    function logout()
    {
        \auth()->user()->tokens()->delete();
        auth()->logout();
        return redirect()->route('login');
    }
}
