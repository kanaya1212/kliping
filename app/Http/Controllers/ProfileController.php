<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Models\User;

class ProfileController extends Controller
{
    // ================= VIEW PROFILE =================
    public function edit(): View
    {
        return view('profile.edit', [
            'user' => auth()->user()
        ]);
    }

    // ================= FORM EDIT =================
    public function editForm(): View
    {
        return view('profile.edit_form', [
            'user' => auth()->user(),
        ]);
    }

    // ================= FORM PASSWORD =================
    public function editPassword(): View
    {
        return view('profile.password', [
            'user' => auth()->user(),
        ]);
    }

    // ================= UPDATE PROFILE =================
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'golongan' => 'nullable|string|max:100',
            'photo' => 'nullable|mimes:jpg,jpeg,png|max:2048',
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'phone.required' => 'No HP wajib diisi',
            'address.required' => 'Alamat wajib diisi',
        

            // FOTO
        'photo.image' => 'File harus berupa gambar',
        'photo.mimes' => 'Format gambar harus JPG, JPEG, atau PNG',
        'photo.max' => 'Ukuran gambar maksimal 2 MB',
        ]);

        // ================= UPDATE DATA =================
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'nip' => $request->nip, 
            'golongan' => $request->golongan,
        ]);

        // ================= HAPUS FOTO =================
if ($request->hapus_foto) {

    if ($user->photo && Storage::disk('public')->exists($user->photo)) {
        Storage::disk('public')->delete($user->photo);
    }

    $user->update([
        'photo' => null
    ]);
}

        // ================= FOTO =================
        if ($request->hasFile('photo')) {

            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            $path = $request->file('photo')->store('profil', 'public');

            $user->update([
                'photo' => $path
            ]);
        }

        return Redirect::route('profile.edit')
            ->with('success', 'Profil berhasil diperbarui');
    }

    // ================= UPDATE PASSWORD =================
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:6'],
        ], [
            'current_password.required' => 'Kata sandi lama wajib diisi',
            'current_password.current_password' => 'Kata sandi lama tidak sesuai',
            'password.required' => 'Kata sandi baru wajib diisi',
            'password.confirmed' => 'Konfirmasi kata sandi tidak sama',
            'password.min' => 'Kata sandi minimal 6 karakter',
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password)
        ]);

        return Redirect::route('profile.edit')
            ->with('success', 'Kata sandi berhasil diperbarui');
    }

    // ================= DELETE =================
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        Auth::logout();
        $user->delete();

        return Redirect::to('/');
    }
}