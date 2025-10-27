<x-app-layout>
    <style>
        body, input, textarea, button, label {
            font-family: 'Inria Serif', serif;
        }
        
        .profile-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 40px auto;
            max-width: 1000px;
            width: 90%;
        }
        .profile-title {
            font-family: 'Inria Serif', serif;
            font-size: 48px;
            font-weight: semi-bold;
            margin-bottom: 30px;
            text-align: center;
        }
        .profile-content {
            display: flex;
            gap: 50px;
            width: 100%;
        }
        .img-box {
            width: 260px;
            height: 340px;
            background: #e6e6e6;
            border: 1px solid #ccc;
            border-radius: 20px;
            overflow: hidden;
            cursor: pointer;
        }
        .img-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .info-fields {
            flex: 1;
        }
        label {
            font-size: 18px;
            margin-bottom: 5px;
            display: block;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 10px !important; 
            font-family: 'Inria Serif', serif;
            font-size: 18px;
            box-sizing: border-box;
        }
        .row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }
        .half { 
            flex: 1; 
        }
        .mb-4 { 
            margin-bottom: 20px; 
        }
        .confirm-btn {
            padding: 12px 30px;
            border-radius: 50px;
            background-color: #f698c4ff;
            color: black;
            border: none;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .confirm-btn:hover { 
            background-color: #f472b6; 
        }
        .button-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
        }
    </style>

    <div class="profile-container">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <h1 class="profile-title">Profile</h1>

            <div class="profile-content">
                <!-- Image Upload -->
                <label class="img-box" for="photo">
                    @if (!empty($user->photo))
                        <img id="preview" src="{{ asset('storage/' . $user->photo) }}" alt="Profile Picture">
                    @else
                     <img id="preview" src="{{ asset('images/default-profile.jpg') }}" alt="Default Picture">
                    @endif
                    <input type="file" id="photo" name="photo" accept="image/*" onchange="previewImage(event)">
                </label>

                <!-- Info Fields -->
                <div class="info-fields">
                    @if(session('success'))
                        <p class="text-green-600 mb-4">{{ session('success') }}</p>
                    @endif

                    <div class="row">
                        <div class="half">
                            <label>First Name</label>
                            <input type="text" name="fname" value="{{ old('fname', $user->fname) }}" required>
                        </div>
                        <div class="half">
                            <label>Last Name</label>
                            <input type="text" name="lname" value="{{ old('lname', $user->lname) }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="half">
                            <label>Birth Date</label>
                            <input type="date" name="bdate" value="{{ old('bdate', $user->bdate) }}">
                        </div>
                        <div class="half">
                            <label>Phone Number</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}">
                    </div>

                    <div class="mb-4">
                        <label>Address</label>
                        <textarea name="address" rows="3">{{ old('address', $user->address) }}</textarea>
                    </div>

                    <div class="button-container">
                        <button type="submit" class="confirm-btn">
                            Confirm
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function(){
                document.getElementById('preview').src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</x-app-layout>
