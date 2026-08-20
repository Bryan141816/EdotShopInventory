@extends('layout.app')

@section('title', 'Home')

@section('content')
    <div class="container">
        <h1>Welcome to the Home Page</h1>
        <p>This is the home page content.</p>
    </div>
    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button type="submit">
            Logout
        </button>
    </form>
@endsection
