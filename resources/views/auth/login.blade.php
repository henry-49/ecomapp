@extends("layouts.auth")

@section("style")
   <style>
       html,
       body {
           height: 100%;
       }
       .form-signin {
           max-width: 330px;
           padding: 1rem;
       }

       .form-signin .form-floating:focus-within {
           z-index: 2;
       }
       .form-signin input[type="email"] {
           margin-bottom: -1px;
           border-bottom-left-radius: 0;
           border-bottom-right-radius: 0;
       }
       .form-signin input[type="password"] {
           border-bottom-left-radius: 0;
           border-bottom-right-radius: 0;
       }
   </style>
@endsection

@section("title", "Login")

@section("content")
<main class="form-signin w-100 m-auto">
   
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="mb-4" 
        alt="Logo" width="72" height="57">
         <h1 class="h3 mb-3 fw-normal">Please Sign In</h1>

        <div class="form-floating mb-2">
            <input type="email" class="form-control" id="floatingInput" 
            name="email" placeholder="name@example.com">
            <label for="floatingInput" class="form-label">Email address</label>
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-floating" style="margin-bottom: 10px;">
            <input type="password" class="form-control" id="floatingPassword" 
            name="password" placeholder="Password">
            <label for="floatingPassword" class="form-label">Password</label>
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-check text-start my-3">
            <input class="form-check-input" type="checkbox" 
            value="remember-me" id="flexCheckDefault" name="rememberme">
            <label class="form-check-label" for="flexCheckDefault">
                Remember me
            </label>
        </div>
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div>
        @endif
        <button type="submit" class="btn btn-primary width-100 py-2">Sign in</button>
        <a href="{{ route('register') }}" class="text-center">Create new account</a>
        <p class="mt-5 mb-3 text-body-secondary">&copy; {{ date('Y') }} E-Commerce</p>
    </form>
</main>
@endsection