<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RoleController extends Controller
{
    public function store(Request $request)
    {
        $role = new Role([
            'name' => $request->name,
            'description' => $request->description
        ]);
        $role->save();

        $savePermissions = new RolePermissionController();
        $savePermissions->store($request, $role);

        Session::flash('message', 'Rol creado correctamente');
        Session::flash('type', 'success');

        return redirect()->route('configuration.index');
    }

    public function update(Request $request, Role $role)
    {
        $role->name = $request->name;
        $role->description = $request->description;
        $role->save();

        $savePermissions = new RolePermissionController();
        $savePermissions->update($request, $role);

        Session::flash('message', 'Rol actualizado correctamente');
        Session::flash('type', 'success');

        return redirect()->route('configuration.index');
    }
}
