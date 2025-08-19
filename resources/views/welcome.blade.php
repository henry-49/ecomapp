@extends("layouts.default")

@section("title", "Welcome")

@section("content")
<div class="container">
    <h1>Welcome to E-Commerce</h1>
    <p>Your one-stop solution for all your shopping needs.</p>
    <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
    <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
</div>
@endsection