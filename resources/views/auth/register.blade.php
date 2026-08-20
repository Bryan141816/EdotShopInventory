@extends('layout.auth')
@section('title', 'Register')
@section('content')
    <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-4">
        @csrf
        @if ($errors->any())
            <div class="text-red-500">
                {{ $errors->first() }}
            </div>
        @endif

        <input type="text" name="name" required placeholder="Name" class="border border-gray-300 rounded px-4 py-2">

        <input type="email" name="email" required placeholder="Email" class="border border-gray-300 rounded px-4 py-2">

        <input type="password" name="password" required placeholder="Password"
            class="border border-gray-300 rounded px-4 py-2">

        <input type="password" name="password_confirmation" required placeholder="Confirm Password"
            class="border border-gray-300 rounded px-4 py-2">

        <button type="submit" class="bg-blue-500 text-white rounded px-4 py-2 hover:bg-blue-600">
            Register
        </button>
        <a href="{{ route('login') }}" class="text-blue-500 hover:underline">
            Already have an account? Login
        </a>
    </form>
@endsection
