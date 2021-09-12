<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permission\Models\Role;
use App\Permission\Models\Permission;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
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
        Gate::authorize('haveaccess', 'role.index');
        $title='Roles';
        $roles = Role::orderBy('id','Desc')->paginate(2);
        return view('role.index', compact('title','roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess', 'role.create');
        $title='Nuevo Rol';
        $permissions = Permission::get();

        return view('role.create', compact('title','permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('haveaccess', 'role.create');
        $request->validate([
            'name'        => 'required|max:50|unique:roles,name',
            'slug'        => 'required|max:50|unique:roles,slug',
            'full-access' => 'required|in:yes,no'
        ]);

        //llenamos la variable $role para luego guardarla
        $role = Role::create($request->all());

        //validamos que vengan los permisos del formulario
        // if ($request->get('permission')) {
            //return $request->all();
            $role->permissions()->sync($request->get('permission'));
        // }
        return redirect()
        ->route('role.index')
        ->with('status_success', 'Role saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        // Gate::authorize('haveaccess', 'role.show');
        $this->authorize('haveaccess', 'role.show');
        $title='store Rol';
        //creamos un array para optener los ides y poder validar en la vista edit
        $permission_role=[];

        foreach ($role->permissions as $permission) {
            $permission_role[] = $permission->id;
        }
        //return $permission_role;

        //el uso (Model building) de Role $role es como si usaramos $role = Role::findOrFile($id);
        $permissions = Permission::get();

        return view('role.view', compact('title','permissions','role', 'permission_role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        Gate::authorize('haveaccess', 'role.edit');
        $title='Editar Rol';
        //creamos un array para optener los ides y poder validar en la vista edit
        $permission_role=[];

        foreach ($role->permissions as $permission) {
            $permission_role[] = $permission->id;
        }
        //return $permission_role;

        //el uso (Model building) de Role $role es  si usaramos $role = Role::findOrFile($id);
        $permissions = Permission::get();

        return view('role.edit', compact('title','permissions','role', 'permission_role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Role $role)
    {
        Gate::authorize('haveaccess', 'role.edit');
        $request->validate([
            'name'        => 'required|max:50|unique:roles,name,'.$role->id,
            'slug'        => 'required|max:50|unique:roles,slug,'.$role->id,
            'full-access' => 'required|in:yes,no'
        ]);

        //llenamos la variable $role para luego guardarla
        $role->update($request->all());

        //validamos que vengan los permisos del formulario
        // if ($request->get('permission')) {
            //return $request->all();
            $role->permissions()->sync($request->get('permission'));
        // }
        return redirect()
        ->route('role.index')
        ->with('status_success', 'Role Update successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        Gate::authorize('haveaccess', 'role.destroy');
        $role->delete();

        return redirect()
        ->route('role.index')
        ->with('status_success', 'Role successfully removed');
    }
}
