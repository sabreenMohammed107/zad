<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Acl\AclFormRequest;
use App\Http\Requests\Acl\AssignRoleFormRequest;
use App\Http\Requests\Acl\SyncRoleFormRequest;
use App\Http\Resources\AclResoursces;
use App\Http\Resources\PermissionsAllResource;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AclController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id = null)
    {

        return response()->json([
            'data' => $id ? \App\Models\User::find($id)->roles : Permission::all(),
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return AclResoursces
     */
    public function show($id)
    {

        $roles = Role::findOrFail($id);
        return new AclResoursces($roles);

    }


    /** return all the permissions in  config array grouped by controller
     * @return \Illuminate\Http\JsonResponse
     */
    public function Permissions()
    {
        // return response()->json([
        //     'data' => config('acl.permission'),
        // ]);
        return $this->dataResponse(['data'=>config('acl.permission')]);
    }

    /**
     * @param null $id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function roles(Request $request)
    {
        if($request->role_type){
        if($request->role_type == 'admin_sales'){
            
         return AclResoursces::collection(Role::where('role_type','admin')->orwhere('role_type','sales')->get());

        }
        //list all roles
        return AclResoursces::collection(Role::where('role_type',$request->role_type)->get());
        }else{
            return AclResoursces::collection(Role::get());
        }

    }


    /**
     *this methods will give
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AclFormRequest $request)
    {
        $permission = $request->all();

        //create a role
        $role = Role::create(['name' => $permission['name'], 'guard_name' => $request->guard_name,'role_type'=>$request->role_type]);

        //attach all the permission to role
        $role->syncPermissions($permission['permissions']);
        return $this->successResponse();

    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Acl $acl
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AclFormRequest $request, $id)
    {

        //create a role
        $role= Role::findOrFail($id);

        // if(in_array($role->name, config('acl.roles')) ){
        //     return $this->errorResponse('you cant update this role', 5500);
        // }

        $role->update([
            'name' => $request->name
        ]);

        if($request->permissions){
            $role->syncPermissions($request->permissions);
        }
       return $this->successResponse();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Acl $acl
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }

    /**
     * @param AssignRoleFormRequest $request
     *
     */
    public function assignToUser(AssignRoleFormRequest $request)
    {
        //this will asign Roles  to user
        User::find($request->user_id)->assignRole($request->roles);
        return $this->successResponse();

    }
    /**
     * @param AssignRoleFormRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function syncToUser(SyncRoleFormRequest $request,$id)
    {

        // $salesRoles=['Head of sales','Sales director','Area sales manager','Sales manager','Team leader','sales'];

      
        User::find($id)->syncRoles($request->roles);
        return $this->successResponse();

    }


    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function allPermission()
    {
        $per= Permission::select('name','id')->get(); // all permission without group
        return PermissionsAllResource::collection($per);
    }

    
   

    public function delete($id)
    {
        $deletRoles = Role::findOrFail($id);
        if(in_array($deletRoles->name, config('acl.roles')) ){
            return $this->errorResponse('you cant Delete this role', 5500);
        }

        $deletRoles->delete();
        return $this->successResponse(); //Response Data with Success
    }

}
