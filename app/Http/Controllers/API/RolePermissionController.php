<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RolePermissionController extends Controller
{
    public function createRole(Request $request)
    {
        $role = Role::create(['name' => $request->input('name')]);
        return response()->json(['message' => 'Role created successfully', 'role' => $role]);
    }

    public function createPermission(Request $request)
    {
        $permission = Permission::create(['name' => $request->input('name')]);
        return response()->json(['message' => 'Permission created successfully', 'permission' => $permission]);
    }

    public function assignRole(Request $request)
    {
        $user = User::find($request->input('user_id'));
        $role = Role::find($request->input('role_id'));
        $user->assignRole($role);
        return response()->json(['message' => 'Role assigned successfully']);
    }

    public function givePermission(Request $request)
    {
        $role = Role::find($request->input('role_id'));
        $permission = Permission::find($request->input('permission_id'));
        $role->givePermissionTo($permission);
        return response()->json(['message' => 'Permission granted successfully']);
    }
}
