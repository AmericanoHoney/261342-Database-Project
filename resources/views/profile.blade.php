@extends('layouts.app')

@section('content')
<style>
    * { box-sizing: border-box; font-family: 'Inria Serif', serif; }
    body { background: #fff; display: flex; flex-direction: column; align-items: center; }

    .profile-container {
        display: flex;
        gap: 50px;
        margin: 60px auto;
        width: 80%;
        max-width: 1000px;
    }

    .img-box {
        width: 260px;
        height: 340px;
        background: #e6e6e6;
        border: 1px solid #333;
        border-radius: 10px;
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }
    .img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .img-box input { display: none; }

    h1 { font-size: 40px; margin-bottom: 20px; }

    label { display: block; margin-top: 10px; font-size: 16px; }
    input, textarea {
        width: 100%; padding: 10px; margin-top: 5px;
        border: 1px solid #333; border-radius: 5px;
    }
    .row { display: flex; gap: 10px; }
    .half { flex: 1; }

    button {
        background-color: #E5A4B3;
        border: none;
        border-radius: 20px;
        padding: 10px 40px;
        font-size: 16px;
        cursor: pointer;
        margin-top: 20px;
        transition: 0.3s;
    }
    button:hover { background-color: #d98fa0; }

    footer {
        width: 100%;
        background: #A63A61;
        color: white;
        text-align: center;
        padding: 10px;
        margin-top: 60px;
    }
</style>

<div class="profile-container">
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="display: flex; gap: 50px;">
            <!-- Image Upload -->
            <label class="img-box" for="profile_pic">
                @if (!empty($user->profile_pic))
                    <img id="preview" src="{{ asset('storage/' . $user->profile_pic) }}" alt="Profile Picture">
                @else
                    <img id="preview" src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="Default Picture">
                @endif
                <input type="file" id="profile_pic" name="profile_pic" accept="image/*" onchange="previewImage(event)">
            </label>

            <!-- Info Fields -->
            <div style="flex: 1;">
                <h1>Profile</h1>

                <div class="row">
                    <div class="half">
                        <label>First Name</label>
                        <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>
                    </div>
                    <div class="half">
                        <label>Last Name</label>
                        <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="half">
                        <label>Birth Date</label>
                        <input type="date" name="birth_date" value="{{ old('birth_date', $user->birth_date) }}">
                    </div>
                    <div class="half">
                        <label>Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}">
                    </div>
                </div>

                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}">

                <label>Address</label>
                <textarea name="address" rows="3">{{ old('address', $user->address) }}</textarea>

                <button type="submit">Confirm</button>
            </div>
        </div>
    </form>
</div>

<footer>
    © 2025 | All Rights Reserved
</footer>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const img = document.getElementById('preview');
            img.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
