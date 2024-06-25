<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registration Page</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" 
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="container">

        <span style="color: yellow;">{{ $errors->first('email') }}<br></span>
        <span style="color: red;">{{ $errors->first('password') }}<br></span>
        <span style="color: red;">{{ $errors->first('confirm_password') }}<br></span>
        
        <div class="wrapper">
            <div class="title"><span>Registration Page</span></div>
            <form action="{{ url('registration_post') }}" method="post">
                @csrf
                <div class="row">
                    <i class="fas fa-user"></i>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Username" required>
                </div>
                <div class="row">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required>
                </div>
                <div class="row">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" value="" placeholder="Password" required>
                </div>
                <div class="row">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="confirm_password" value="" placeholder="Confirm Password" required>
                </div>
                <div class="row">
                    <select class="selectbox" name="is_role" required>
                        <option value="">Select Role</option>
                        <option {{ old('is_role') == '2' ? 'selected' : '' }} value="2">Admin</option>
                        <option {{ old('is_role') == '1' ? 'selected' : '' }} value="1">Guru</option>
                        <option {{ old('is_role') == '0' ? 'selected' : '' }} value="0">Siswa</option>
                    </select>
                </div>

                <div class="pass"><a href="{{ url('forgot') }}">Forgot Password</a></div>

                <div class="row button">
                    <input type="submit" value="Registration">
                </div>

                <div class="signup-link">Masuk? <a href="{{ url('login') }}">Login</a></div>

                <div class="signup-link">Halaman Utama? <a href="{{ url('/') }}"> Halaman Utama</a></div>

            </form>
        </div>
    </div>
</body>
</html>