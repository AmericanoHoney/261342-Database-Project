<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // ดึงข้อมูลที่ validated
        $data = $request->validated();

        // ตรวจสอบว่ามีการอัปโหลดรูปภาพหรือไม่
        if ($request->hasFile('photo')) {
            // ลบรูปเก่าถ้ามี
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            // เก็บรูปใหม่
            $data['photo'] = $request->file('photo')->store('profile_pics', 'public');
        }

        // อัปเดต user
        $user->fill($data);

        // ถ้า email เปลี่ยน ให้ reset verification
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // กลับมาที่หน้าเดิม พร้อมส่งข้อความ status
        return redirect()->route('profile.edit')->with('status', 'Profile updated successfully!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
