<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.signup');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // ตรวจสอบข้อมูลที่ส่งมา
        $request->validate([
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'bdate' => ['nullable', 'date'],     
            'phone' => ['nullable', 'string', 'max:20'], 
            'address' => ['nullable', 'string'],
            'photo' => ['nullable', 'image', 'max:2048'], // เพิ่มตรวจสอบไฟล์รูป
        ]);

        $data = [
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'bdate' => $request->bdate,
            'phone' => $request->phone,
            'address' => $request->address,
        ];

        // ถ้ามีการอัปโหลดรูป ให้บันทึก path
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('profile_pics', 'public');
        }

        // สร้างผู้ใช้ใหม่
        $user = User::create($data);

        // ส่ง event Registered
        event(new Registered($user));

        // login อัตโนมัติหลังสมัคร
        Auth::login($user);

        // ไปหน้า dashboard
        return redirect()->route('dashboard');
    }
}
