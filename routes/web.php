<?php

use Illuminate\Support\Facades\Route;

// หน้าแรก
Route::get('/', function () {
    return view('welcome');
});

// หน้า Login
Route::get('/login', function () {
    return view('login'); 
})->name('login');

// หน้า Sign Up / Register
Route::get('/signup', function () {
    return view('signup'); 
})->name('signup');

// หน้า Home (หลังจาก login)
Route::get('/home', function () {
    return view('home'); 
})->name('home');

// หน้า Profile
Route::get('/profile', function () {
    return view('profile'); 
})->name('profile');