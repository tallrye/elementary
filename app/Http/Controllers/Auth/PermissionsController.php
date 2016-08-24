<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request as Request;
use App\Models\Roles\Permission;
use App\Models\Roles\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Datatables;
use LaravelPusher;

class PermissionsController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Permissions Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the permissions including all CRUD 
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
        parent::checkPermission('manage_permissions');
    }

    /**
     * Show the listing page of all permissions.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auth.permissions.home');
    }

    /**
     * Live Ajax load of the permissions into Datatable.
     *
     * @param   \Yajra\Datatables\DatatablesServiceProvider
     * @param   \App\Models\Roles\Permission 
     * @return  \Illuminate\Http\Response
     */
    public function load()
    {
        return Datatables::of(Permission::select('*'))->make(true);
    }

    /**
     * Live Ajax fetch for a single permission.
     *
     * @param   integer $id
     * @param   \App\Models\Roles\Permission
     * @return  \Illuminate\Http\Response
     */
    public function fetch($id)
    {
        return Permission::findOrFail($id);
    }


    /**
     * Store a new permission.
     *
     * @param   \Illuminate\Http\Request  $request
     * @param   \App\Models\Roles\Permission 
     * @param   \LaravelPusher
     * @return  string
     */
    public function store(Request $request)
    {
        $this->validate($request, Permission::$rules);
        Permission::create($request->all());
        LaravelPusher::trigger('roles-channel', 'refresh-permissions', ['message' => 'Yeni Yetki Eklendi']);
        return 'Yeni Yetki Eklendi';
    }

    /**
     * how the edit page of a permission.
     *
     * @param   integer $id
     * @param   \App\Models\Roles\Permission $permission
     * @return  \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('auth.permissions.edit', compact('permission'));
    }

    /**
     * Update existing permission.
     *
     * @param   \Illuminate\Http\Request  $request
     * @param   \App\Models\Roles\Permission $permission
     * @param   \LaravelPusher
     * @return  string
     */
    public function update(Request $request)
    {
        $permission = Permission::findOrFail($request->get('id'));
        $permission->update($request->all());
        LaravelPusher::trigger('roles-channel', 'refresh-permissions', ['message' => 'Yetki Güncellendi']);
        return 'Yetki Güncellendi';
    }

    /**
     * Delete existing permission.
     *
     * @param   \Illuminate\Http\Request  $request
     * @param   \App\Models\Roles\Permission 
     * @param   \LaravelPusher
     * @return  string
     */
    public function delete(Request $request)
    {
        Permission::destroy($request->get('id'));
        LaravelPusher::trigger('roles-channel', 'refresh-permissions', ['message' => 'Yetki Kaldırıldı']);
        return 'Yetki Kaldırıldı';
    }

    /**
     * Live search for permissions on Select2 dropdowns
     *
     * @param   integer  $id
     * @param   \Illuminate\Http\Request  $request
     * @param   \App\Models\Roles\Permission $permissions
     * @param   \App\Models\Roles\Role $role
     * @return  array
     */
    public function search($id, Request $request){
        $permissions = Permission::where('name', 'like', '%'.$request->get('q').'%')->get();
        $role = Role::findOrFail($id);

        $nonexistingPermissions = array();
        foreach($permissions->diff($role->permissions) as $permisson){
            array_push($nonexistingPermissions, ['id' => $permisson->id, 'text' => $permisson->name]);
        }
        return $nonexistingPermissions;
    }
}
