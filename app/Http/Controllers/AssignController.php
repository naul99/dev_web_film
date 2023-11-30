<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AssignController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:assign permission');

    }
    public function assignPermissions()
    {

        $listRole = Role::all();
        $listPermission = Permission::all();

        return view('admincp.role.assignpermission', compact('listRole', 'listPermission'));
    }
    public function select_role()
    {
        $id = $_GET['id'];
        $role = Role::find($id);
        $hasPermission = $role->permissions->pluck('name');
        $output = '';
        for ($i = 0; $i < count($hasPermission); $i++) {
            $output .= '<option>' . $hasPermission[$i] . '</option>';
        }
        echo $output;
    }
    public function assignPermissionsToRole(Request $request)
    {

        $data = $request->all();
        //dd($data);
        $role = Role::find($data['role']);
        if (!isset($data['permissions'])) {
            toastr()->warning('Quyen khong duoc rong!');
            return redirect()->back();
        } else {
            $role->syncPermissions($data['permissions']);
            toastr()->success('Them quyen thanh cong');
            return redirect()->back();
        }
    }
}
