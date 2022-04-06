<?php

namespace App\Http\Controllers;

use App\Branch;
use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Developer|Admin|Manager']);
    }
    /**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        $roles = Role::whereNotIn('name', ['Developer', 'Admin'])->get();
        $users = User::role($roles)->paginate(25);

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $roles = Role::whereNotIn('name', ['Developer', 'Admin'])->get();
        $branches = Branch::all();
        return view('users.create', compact('roles', 'branches'));
    }

    /**
     * Store a newly created user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request)
    {
        $request->merge(['password' => Hash::make($request->get('password'))]);

        $user = User::create($request->all());

        $user->assignRole($request->role);

        return redirect()->route('users.index')->withStatus('User successfully created.');
    }

    /**
     * Show the form for editing the specified user
     *
     * @param  \App\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        $roles = Role::whereNotIn('name', ['Developer', 'Admin'])->get();
        $role = $user->roles->first()->name;
        // dd($role);
        return view('users.edit', compact('user', 'roles', 'role'));
    }

    /**
     * Update the specified user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, User $user)
    {
        dd($request->toArray());
        $hasPassword = $request->get('password');

        $request->merge(['password' => Hash::make($request->get('password'))]);

        $request->except([$hasPassword ? '' : 'password']);

        $user->update($request->all());

        return redirect()->route('users.index')->withStatus('User successfully updated.');
    }

    /**
     * Remove the specified user from storage
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User  $user)
    {
        $user->removeRole($user->getRoleNames()->first());

        $user->delete();

        return redirect()->route('users.index')->withStatus('User successfully deleted.');
    }
}
