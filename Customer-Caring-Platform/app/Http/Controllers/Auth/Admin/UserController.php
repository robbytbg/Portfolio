<?php

namespace App\Http\Controllers\Auth\Admin;
use App\Models\User;
use Spatie\Permission\Models\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $searchEmail = $request->input('email');
        $searchRole = $request->input('role');
    
        $query = User::query();
    
        if ($searchEmail) {
            $query->where('email', 'like', '%' . $searchEmail . '%');
        }
    
        if ($searchRole) {
            $query->whereHas('roles', function($q) use ($searchRole) {
                $q->where('name', $searchRole);
            });
        }
    
        $users = $query->paginate(5);
        $roles = Role::all();
    
        return view('admin.users.index', compact('users', 'roles'));
    }
    
    
    

    public function assignRole(Request $request, User $user)
    {
        $role = $request->input('role');
        $user->assignRole($role);

        return back()->with('success', 'Role assigned successfully');
    }

    public function removeRole(User $user, Role $role)
    {
        $user->removeRole($role);
        return back()->with('success', 'Role removed successfully');
    }
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
