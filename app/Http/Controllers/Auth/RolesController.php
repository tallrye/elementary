<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request as Request;

use App\Models\Roles\Role;
use App\Models\Roles\Permission;
use App\Models\Roles\PermissionRole;
use Illuminate\Support\Facades\Auth;
use App\Models\Roles\RoleUser;
use App\User;
use App\Http\Controllers\Controller;
use Datatables;
use LaravelPusher;
use DB;

class RolesController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Roles Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the roles including all CRUD 
    | operations as well as loading Ajax data into the View
    |
    */

    /**
     * Constructor method defines accessibility permissions
     *
     * @param   \Illuminate\Support\Facades\Auth
     * @return  \Illuminate\Foundation\Application abort
     */
    public function __construct() {
        parent::__construct();
        parent::checkPermission('manage_roles');
    }

    /**
     * Show the listing page of all roles.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auth.roles.home');
    }

    /**
     * Live Ajax load of the roles into Datatable.
     *
     * @param   \Yajra\Datatables\DatatablesServiceProvider
     * @param   \App\Models\Roles\Role 
     * @return  \Illuminate\Http\Response
     */
    public function load()
    {
        return Datatables::of(Role::select('*'))->make(true);
    }

    /**
     * Live Ajax fetch for a single role.
     *
     * @param   integer $id
     * @param   \App\Models\Roles\Role $role
     * @return  \Illuminate\Http\Response
     */
    public function fetch($id)
    {
        return Role::findOrFail($id);
    }

    /**
     * Show the page for creating new role.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.roles.create');
    }

    /**
     * Store a new role.
     *
     * @param   \Illuminate\Http\Request  $request
     * @param   \App\Models\Roles\Role 
     * @param   \LaravelPusher
     * @return  string
     */
    public function store(Request $request)
    {
        $this->validate($request, Role::$rules);
        Role::create($request->all());
        LaravelPusher::trigger('roles-channel', 'refresh-role', ['message' => 'Yeni Rol Eklendi']);
        return 'Role Added';
        
    }

    /**
     * how the edit page of a role.
     *
     * @param   integer $id
     * @param   \App\Models\Roles\Role $role
     * @param   \App\Models\Roles\Permission $permissions
     * @param   \Auth
     * @return  \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if($id == 1 && \Auth::user()->id != 1){
            abort('403');
        }
        $role = Role::findOrFail($id);
        return view('auth.roles.edit', compact('role'));
    }

    /**
     * Update existing role.
     *
     * @param   \Illuminate\Http\Request  $request
     * @param   \App\Models\Roles\Role $role
     * @param   \Illuminate\Session\Store flash()
     * @return  \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, ['name' => 'required', 'description' => 'required']);
    	$role = Role::findOrFail($request->get('id'));
    	$role->update($request->all());
        session()->flash('success', 'Role Updated');
        return redirect()->back();
    }

    /**
     * Delete existing permission.
     *
     * @param   \Illuminate\Http\Request  $request
     * @param   \App\Models\Roles\Role 
     * @param   \LaravelPusher
     * @return  string
     */
    public function delete(Request $request)
    {
        if($request->get('id') == 1){
            LaravelPusher::trigger('roles-channel', 'refresh-role', ['message' => 'Bu Rol Silinemez']);
            return 'Bu Rol Silinemez';
        }
        Role::destroy($request->get('id'));
        LaravelPusher::trigger('roles-channel', 'refresh-role', ['message' => 'Rol Güncellendi']);
        return 'Rol Güncellendi';
    }

    /**
     * Give new permission to a role
     *
     * @param   \Illuminate\Http\Request  $request
     * @param   \App\Models\Roles\PermissionRole 
     * @param   \Illuminate\Session\Store flash()
     * @return  \Illuminate\Http\Response
     */
    public function addpermission(Request $request)
    {
        $this->validate($request, ['permission_id' => 'required']);
    	PermissionRole::create($request->all());
        session()->flash('success', 'Yeni Yetki Verildi');
        return redirect()->back();
    }

    /**
     * Remove given permission from a role
     *
     * @param   \Illuminate\Http\Request  $request
     * @param   \DB 
     * @param   \Illuminate\Session\Store flash()
     * @return  \Illuminate\Http\Response
     */
    public function removepermission(Request $request)
    {
    	DB::table('permission_role')
            ->where('permission_id', '=', $request->get('permission_id'))
            ->where('role_id', '=', $request->get('role_id'))
            ->delete();
        session()->flash('danger', 'Yetki Kaldırıldı');
    	return redirect()->back();
    }

    /**
     * Live search for roles on Select2 dropdowns
     *
     * @param   integer  $id
     * @param   \Illuminate\Http\Request  $request
     * @param   \App\Models\Roles\Role
     * @param   \App\User
     * @return  array
     */
    public function search($id, Request $request){
        $user = User::findOrFail($id);
        $allroles = Role::where('name', 'like', '%'.$request->get('q').'%')->get();

        $roles = array();
        foreach($allroles->diff($user->roles) as $role){
            array_push($roles, ['id' => $role->id, 'text' => $role->name]);
        }
        return $roles;
    }
}