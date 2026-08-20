@extends('layout.auth')
@section('title', 'Login')
@section('content')
    <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-4">
        @csrf
        @if ($errors->any())
            <div class="text-red-500">
                {{ $errors->first() }}
            </div>
        @endif
        <input type="email" name="email" placeholder="Email" required class="border border-gray-300 rounded px-4 py-2">

        <input type="password" name="password" placeholder="Password" required
            class="border border-gray-300 rounded px-4 py-2">

        <label class="flex items-center gap-2">
            <input type="checkbox" name="remember" class="form-checkbox">
            Remember me
        </label>
        <button type="submit" class="bg-blue-500 text-white rounded px-4 py-2 hover:bg-blue-600">
            Login
        </button>
        <a href="{{ route('register') }}" class="text-blue-500 hover:underline">
            Don't have an account? Register
        </a>
    </form>
@endsection
