<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validateWithBag('updatePassword', [
                'current_password' => ['required', 'current_password'],
                'password' => ['required', Password::defaults(), 'confirmed'],
            ]);

            $user = $request->user();
            $user->password = Hash::make($validated['password']);
            $user->save();

            Log::info('Password updated successfully for user: ' . $user->id);

            return redirect()->route('profile.show')->with('status', 'password-updated');
        } catch (\Exception $e) {
            Log::error('Password update failed: ' . $e->getMessage());
            return back()->withErrors(['updatePassword' => 'Terjadi kesalahan saat mengupdate password. Silakan coba lagi.']);
        }
    }
}
