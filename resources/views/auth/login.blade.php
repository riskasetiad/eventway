@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center w-full h-screen bg-gray-100 absolute top-0 left-0">
    <div class="w-full max-w-md bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-center text-gray-800">{{ __('Login') }}</h2>
        <p class="text-sm text-center text-gray-500 mb-6">Welcome back! Please login to your account.</p>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email Address') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror">
                @error('email')
                <span class="text-sm text-red-600 mt-1">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror">
                @error('password')
                <span class="text-sm text-red-600 mt-1">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="flex items-center justify-between mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="remember" class="form-checkbox text-blue-600 border-gray-300 rounded">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember Me') }}</span>
                </label>
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">
                    {{ __('Forgot Your Password?') }}
                </a>
                @endif
            </div>
            <div>
                <button type="submit" class="w-full px-4 py-2 text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1">
                    {{ __('Login') }}
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
