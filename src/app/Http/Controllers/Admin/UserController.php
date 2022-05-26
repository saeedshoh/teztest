<?php namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Modules\Users\Models\User;
use App\Permission;
use App\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $user = User::query();
        $id = request('id');
        $name = request('name');
        $email = request('email');
        $status = request('status');
        $createdAt = request('created_at');

        if($id){
            $user->where('id', $id);
        }

        if($name){
            $user->where('name', 'like', "%{$name}%");
        }

        if($email){
            $user->where('email', 'like', "%{$email}%");
        }

        if ($status){
            $user->where('status', $status);
        }

        if ($createdAt) {
            $createdAt = Carbon::parse($createdAt);
            $user->whereDate('created_at', $createdAt);
        }

        return view('user.index', ['result' => $user->orderByDesc('id')->paginate(20)->withQueryString(), 'statuses' => User::STATUSES_ARRAY]);
    }

    public function create()
    {
        $roles = Role::pluck('name_ru', 'id');
        return view('user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'bail|required|min:2',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'roles' => 'required|min:1'
        ]);

        $request->merge(['password' => bcrypt($request->get('password'))]);

        if ( $user = User::create($request->except('roles', 'permissions')) ) {
            $this->syncPermissions($request, $user);
            flash('User has been created.');
        } else {
            flash()->error('Unable to create user.');
        }

        return redirect()->route('users.index');
    }

    public function show(User $user)
    {
        return view('user.show', ['user' => $user]);
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name_ru', 'id');
        $permissions = Permission::all('name', 'id');

        return view('user.edit', compact('user', 'roles', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'bail|required|min:2',
            'email' => 'required|email|unique:users,email,' . $id,
            'roles' => 'required|min:1'
        ]);

        // Get the user
        $user = User::findOrFail($id);

        // Update user
        $user->fill($request->except('roles', 'permissions', 'password'));

        // check for password change
        if($request->get('password')) {
            $user->password = bcrypt($request->get('password'));
        }

        // Handle the user roles
        $this->syncPermissions($request, $user);

        $user->save();
        flash()->success('User has been updated.');
        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        if ( Auth::user()->id == $id ) {
            flash()->warning('Deletion of currently logged in user is not allowed :(')->important();
            return redirect()->back();
        }

        if( User::findOrFail($id)->delete() ) {
            flash()->success('User has been deleted');
        } else {
            flash()->success('User not deleted');
        }

        return redirect()->back();
    }

    private function syncPermissions(Request $request, $user)
    {
        // Get the submitted roles
        $roles = $request->get('roles', []);
        $permissions = $request->get('permissions', []);

        // Get the roles
        $roles = Role::find($roles);

        // check for current role changes
        if( ! $user->hasAllRoles( $roles ) ) {
            // reset all direct permissions for user
            $user->permissions()->sync([]);
        } else {
            // handle permissions
            $user->syncPermissions($permissions);
        }

        $user->syncRoles($roles);
        return $user;
    }

    public function audit(User $user)
    {
        $audits = $user->audits()->with(['user'])->paginate();
        return view('user.audit', ['audits' => $audits]);
    }

}
