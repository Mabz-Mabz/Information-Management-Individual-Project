<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserManagementController extends Controller
{
    // Permissions matrix per role
    private function permissions()
    {
        return [
            'admin' => [
                'Manage Users'          => true,
                'View Audit Logs'       => true,
                'Manage Cars'           => true,
                'Manage Customers'      => true,
                'Manage Invoices'       => true,
                'Manage Service Tickets' => true,
                'Manage Service Records' => true,
                'Manage Mechanics'      => true,
                'Manage Parts'          => true,
            ],
            'salesperson' => [
                'Manage Users'          => false,
                'View Audit Logs'       => false,
                'Manage Cars'           => true,
                'Manage Customers'      => true,
                'Manage Invoices'       => true,
                'Manage Service Tickets' => false,
                'Manage Service Records' => false,
                'Manage Mechanics'      => false,
                'Manage Parts'          => false,
            ],
            'mechanic' => [
                'Manage Users'          => false,
                'View Audit Logs'       => false,
                'Manage Cars'           => false,
                'Manage Customers'      => false,
                'Manage Invoices'       => false,
                'Manage Service Tickets' => true,
                'Manage Service Records' => true,
                'Manage Mechanics'      => false,
                'Manage Parts'          => true,
            ],
            'service_staff' => [
                'Manage Users'          => false,
                'View Audit Logs'       => false,
                'Manage Cars'           => false,
                'Manage Customers'      => true,
                'Manage Invoices'       => false,
                'Manage Service Tickets' => true,
                'Manage Service Records' => true,
                'Manage Mechanics'      => false,
                'Manage Parts'          => true,
            ],
        ];
    }

    public function index()
    {
        Log::info("UserManagementController: index");
        $users       = DB::table('users')->get();
        $permissions = $this->permissions();
        $roles       = ['admin', 'salesperson', 'mechanic', 'service_staff'];

        return view('tables.users', compact('users', 'permissions', 'roles'));
    }

    public function store(Request $request)
    {
        Log::info("UserManagementController: store");
        $request->validate([
            'name'     => ['required', 'max:100'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required'],
            'role'     => ['required', 'in:admin,salesperson,mechanic,service_staff'],
        ]);

        DB::table('users')->insert([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => $request->role,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Log::info("User created: " . $request->email);
        return redirect()->route('users.index')->with('success', 'User added successfully.');
    }

    public function update(Request $request, $id)
    {
        Log::info("UserManagementController: update - " . $id);
        $request->validate([
            'name'  => ['required', 'max:100'],
            'email' => ['required', 'email', 'unique:users,email,' . $id],
            'role'  => ['required', 'in:admin,salesperson,mechanic,service_staff'],
        ]);

        $data = [
            'name'       => $request->name,
            'email'      => $request->email,
            'role'       => $request->role,
            'updated_at' => now(),
        ];

        // Only update password if a new one is provided
        if ($request->filled('password')) {
            $request->validate([
                'password' => ['required'],
            ]);
            $data['password'] = Hash::make($request->password);
        }

        DB::table('users')->where('id', $id)->update($data);

        Log::info("User updated: " . $id);
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        Log::info("UserManagementController: destroy - " . $id);

        // Prevent admin from deleting their own account
        if (auth()->id() == $id) {
            return redirect()->route('users.index')->with('error', 'You cannot delete your own account.');
        }

        DB::table('users')->where('id', $id)->delete();
        Log::info("User deleted: " . $id);
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
