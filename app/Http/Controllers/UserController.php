<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\ChangeRoleRequest;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $users = User::join('roles', 'users.role_id', '=', 'roles.id')
            ->where('users.id', '!=', auth()->id())
            ->where(function ($query) use ($search) {
                if ($search) {
                    $query->where('users.name', 'like', '%' . $search . '%')
                        ->orWhere('users.email', 'like', '%' . $search . '%');
                }
            })
            ->select('users.id', 'users.name', 'users.email', 'users.status', 'roles.name as role_name', 'users.role_id')
            ->orderBy('users.id', 'asc')
            ->paginate(10);
        $roles = Role::all();

        return view('users.index', compact('users', 'roles'));
    }

    public function changeRole(Request $request, User $user)
    {
        try {
            app(ChangeRoleRequest::class)->validateResolved();
            $user->role_id = $request->role_id;
            $user->save();
            Session::flash('message', 'Rol actualizado correctamente');
            Session::flash('type', 'success');
            return redirect()->route('users.index');
        } catch (\Exception $th) {
            $errors = $th->validator->errors()->all();
            Session::flash('message', 'Error al cambiar el rol: ' . implode(', ', $errors));
            Session::flash('type', 'error');
            return redirect()->route('users.index');
        }
    }

    public function changeStatus(User $user)
    {
        $user->status = $user->status == 'active' ? 'inactive' : 'active';
        $user->save();

        Session::flash('message', 'Estado actualizado correctamente');
        Session::flash('type', 'success');

        return redirect()->route('users.index');
    }

    public function store(Request $request)
    {
        try {
            app(StoreRequest::class)->validateResolved();
            User::create($request->all());
            Session::flash('message', 'Usuario registrado correctamente');
            Session::flash('type', 'success');
            return redirect()->route('users.index');
        } catch (\Exception $th) {
            $errors = $th->validator->errors()->all();
            Session::flash('message', 'Error al registrar el usuario: ' . implode(', ', $errors));
            Session::flash('type', 'error');
            return redirect()->route('users.index');
        }
    }

    public function show(User $user)
    {
        return view('users.profile', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        try {
            app(UpdateRequest::class)->validateResolved();
            $user->update($request->all());
            Session::flash('message', 'Usuario actualizado correctamente');
            Session::flash('type', 'success');
            return redirect()->route('users.index');
        } catch (\Exception $th) {
            $errors = $th->validator->errors()->all();
            Session::flash('message', 'Error al actualizar el usuario: ' . implode(', ', $errors));
            Session::flash('type', 'error');
            return redirect()->route('users.index');
        }
    }

    public function destroy(User $user)
    {
        $user->status = 'inactive';
        $user->save();

        return redirect()->route('users.index');
    }

    public function activate(User $user)
    {
        $user->status = 'active';
        $user->save();

        return redirect()->route('users.index');
    }
}
