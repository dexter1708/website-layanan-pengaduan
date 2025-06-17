<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserManagementController extends Controller
{
     
    // List all staff accounts
    public function staffIndex()
    {
        $staffs = User::where('role', 'staff')->get();
        return view('user-management.staff.index', compact('staffs'));
    }

    // Create staff form
    public function staffCreate()
    {
        return view('user-management.staff.create');
    }

    // Store new staff
    public function staffStore(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nik' => ['required', 'string', 'unique:users,nik'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nik' => $request->nik,
            'role' => 'staff',
        ]);

        return redirect()->route('staff.index')
            ->with('success', 'Akun staff berhasil dibuat.');
    }

    // Edit staff form
    public function staffEdit($id)
    {
        $staff = User::where('role', 'staff')->findOrFail($id);
        return view('user-management.staff.edit', compact('staff'));
    }

    // Update staff
    public function staffUpdate(Request $request, $id)
    {
        $staff = User::where('role', 'staff')->findOrFail($id);

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'nik' => ['required', 'string', 'unique:users,nik,' . $id],
        ];

        // Only validate password if it's being changed
        if ($request->filled('password')) {
            $rules['password'] = ['required', 'confirmed', Rules\Password::defaults()];
        }

        $request->validate($rules);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'nik' => $request->nik,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $staff->update($updateData);

        return redirect()->route('staff.index')
            ->with('success', 'Data staff berhasil diperbarui.');
    }

    // Delete staff
    public function staffDestroy($id)
    {
        $staff = User::where('role', 'staff')->findOrFail($id);
        $staff->delete();

        return redirect()->route('staff.index')
            ->with('success', 'Akun staff berhasil dihapus.');
    }

    // List all user/pelapor accounts
    public function userIndex()
    {
        $users = User::where('role', 'pelapor')->get();
        return view('user-management.users.index', compact('users'));
    }

    // View user details
    public function userShow($id)
    {
        $user = User::where('role', 'pelapor')
            ->with(['alamat'])
            ->findOrFail($id);
        return view('user-management.users.show', compact('user'));
    }

    // Edit user form
    public function userEdit($id)
    {
        $user = User::where('role', 'pelapor')->findOrFail($id);
        return view('user-management.users.edit', compact('user'));
    }

    // Update user
    public function userUpdate(Request $request, $id)
    {
        $user = User::where('role', 'pelapor')->findOrFail($id);

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'nik' => ['required', 'string', 'unique:users,nik,' . $id],
        ];

        // Only validate password if it's being changed
        if ($request->filled('password')) {
            $rules['password'] = ['required', 'confirmed', Rules\Password::defaults()];
        }

        $request->validate($rules);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'nik' => $request->nik,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return redirect()->route('users.index')
            ->with('success', 'Data pelapor berhasil diperbarui.');
    }

    // Delete user
    public function userDestroy($id)
    {
        $user = User::where('role', 'pelapor')->findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Akun pelapor berhasil dihapus.');
    }
} 