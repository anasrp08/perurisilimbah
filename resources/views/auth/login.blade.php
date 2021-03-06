<!DOCTYPE html>
<html>
<head>
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
	<title>Login SIMBAH</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('/adminlte3/css/style.css')}}">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<style>
	input {
 outline:none;
}
	</style>
</head>
<body>
	<img class="wave" src="{{ asset('/img/wave.png')}}">
	<div class="container">
		<div class="img">
			<img src="{{ asset('img/factory.svg')}}">
		</div>
		<div class="login-content">
			<form class="user" method="POST" action="{{ route('login') }}">
				@csrf
				<img src="{{ asset('/img/logo.png') }}">
				<h2 class="title">SIMBAH</h2>
				<h3 class="kepanjangan">Sistem Informasi Limbah</h3><br>
           		<div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-user"></i>
           		   </div>
           		   <div class="div">
           		   		<h5>Username</h5>
							  <input type="text" class="input" name="email" value="{{ old('email') }}" required autocomplete="off" 
							  id="email" aria-describedby="emailHelp" >
						  @error('email')
						  <span class="invalid-feedback" role="alert">
							  <strong>{{ $message }}</strong>
						  </span>
						  @enderror
           		   </div>
           		</div>
           		<div class="input-div pass">
           		   <div class="i"> 
           		    	<i class="fas fa-lock"></i>
           		   </div>
           		   <div class="div">
           		    	<h5>Password</h5>
           		    	<input type="password" class="input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"
                                                id="password">
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
            	   </div>
            	</div>
            	<!-- <a href="#">Forgot Password?</a> -->
            	{{-- <input type="submit" class="btn" value="Login"> --}}
				<button type="submit" class="btn">
					{{ __('Login') }}
				</button>
            </form>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('/adminlte3/js/main.js')}}"></script>
</body>
</html>