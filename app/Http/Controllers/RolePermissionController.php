<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    public function store(Request $request, Role $role)
    {
        foreach ($request->permissions as $permission) {
            $rolePermission = new RolePermission([
                'role_id' => $role->id,
                'permission_id' => $permission
            ]);
            $rolePermission->save();
        }

        return redirect()->route('configuration.index');
    }

    public function update(Request $request, Role $role)
    {
        RolePermission::where('role_id', $role->id)->delete();
        foreach ($request->permissions as $permission) {
            $rolePermission = new RolePermission([
                'role_id' => $role->id,
                'permission_id' => $permission
            ]);
            $rolePermission->save();
        }

        return redirect()->route('configuration.index');
    }
}
