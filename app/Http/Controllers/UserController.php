<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Permission\Models\Role;
use App\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('haveaccess', 'user.index');
        $title='Usuarios';
        $users = User::with('roles')->orderBy('id','Desc')->paginate(2);
        // return $users;
        return view('user.index', compact('title','users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $this-autorize('create', User::class);
        // return 'Create';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $this->authorize('view', [$user, ['user.show', 'userown.show']]);
        $title='Ver Usuarios';
        $roles = Role::orderBy('name')->get();
        // return $roles;
        return view('user.view', compact('title', 'roles', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('update', [$user, ['user.edit', 'userown.edit']]);
        $title='Editar Usuarios';
        $roles = Role::orderBy('name')->get();
        // return $roles;
        return view('user.edit', compact('title', 'roles', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'        => 'required|max:50|unique:users,name,'.$user->id,
            'email'        => 'required|max:50|unique:users,email,'.$user->id
        ]);
            //dd($request->all());
        $user->update($request->all());

        $user->roles()->sync($request->get('roles'));
        // }
        return redirect()
        ->route('user.index')
        ->with('status_success', 'User Update successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('haveaccess', 'user.destroy');
        $user->delete();

        return redirect()
        ->route('user.index')
        ->with('status_success', 'User successfully removed');
    }
}
