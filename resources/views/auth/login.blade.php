@extends('layouts.app')
@section('content')
    <div class="mt-4">
        <div>
            <div class="flex justify-center items-center">
                <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Login</h2>
            </div>

            <div class="flex justify-center items-center mt-4">
                <form action="{{ route('login') }}" method="POST">
                    @csrf
    
                    <div class="mb-4">
                        <div>
                            <label for="email" class="text-white">Email
                                <input type="email" name="email" id="email" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white text-gray-900">
                                @error('email')
                                    <small class="text-red">{{ $message }}</small>
                                @enderror
                            </label>
                        </div>
                        <div class="mt-4">
                            <label for="password" class="text-white">Password
                                <input type="password" name="password" id="password" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white text-gray-900">
                                @error('password')
                                    <small class="text-red">{{ $message }}</small>
                                @enderror
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="mt-4 primary-button">Log In</button>
    
                </form>
            </div>
        </div>
    </div>
@endsection