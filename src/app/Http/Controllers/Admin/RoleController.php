<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['perm:view_roles'])->only(['index']);
        $this->middleware(['perm:add_roles'])->only(['store']);
        $this->middleware(['perm:edit_roles'])->only(['update']);
    }


    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();

        return view('role.index', ['roles' => $roles, 'permissions' => $permissions]);
    }


    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required|unique:roles']);

        if(Role::create($request->only('name'))) {
            flash('Роль добавлен');
        }

        return redirect()->back();
    }


    public function update(Request $request, $id)
    {
        if($role = Role::findOrFail($id)) {
            // admin role has everything
  /*          if($role->name === 'Admin') {
                $role->syncPermissions(Permission::all());
                return redirect()->route('roles.index');
            }*/

            $permissions = $request->get('permissions', []);

            $role->syncPermissions($permissions);

            flash( $role->name . ' permissions has been updated.');
        } else {
            flash()->error( 'Role with id '. $id .' note found.');
        }

        return redirect()->route('roles.index');
    }
}
