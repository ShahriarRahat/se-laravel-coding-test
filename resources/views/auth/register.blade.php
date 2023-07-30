@extends('layouts.app')
@section('content')
    <div class="mt-4">
        <div>
            <div class="flex justify-center items-center">
                <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Register</h2>
            </div>

            <div class="flex justify-center items-center mt-4">
                <form action="{{ route('registerUser') }}" method="POST">
                    @csrf
    
                    <div class="mb-4">
                        <div>
                            <label for="name" class="text-white">Name</label>
                                <input type="name" name="name" id="name" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white text-gray-900">
                                @error('name')
                                    <small class="text-red">{{ $message }}</small>
                                @enderror
                            
                        </div>
                        <div class="mt-4">
                            <label for="email" class="text-white">Email</label>
                                <input type="email" name="email" id="email" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white text-gray-900">
                                @error('email')
                                    <small class="text-red">{{ $message }}</small>
                                @enderror
                            
                        </div>
                        <div class="mt-4">
                            <label for="password" class="text-white">Password</label>
                                <input type="password" name="password" id="password" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white text-gray-900">
                                @error('password')
                                    <small class="text-red">{{ $message }}</small>
                                @enderror
                            
                        </div>
                        <div class="mt-4">
                            <label for="password_confirmation" class="text-white">Re-Type Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white text-gray-900">
                                @error('password_confirmation')
                                    <small class="text-red">{{ $message }}</small>
                                @enderror
                            
                        </div>
                        <div class="mt-4">
                            <label for="account_type" class="block mb-2 text-gray-900 dark:text-white">Account Type</label>
                            <select id="account_type" name="account_type">
                            <option value="individual">Individual</option>
                            <option value="business">Business</option>
                            </select>
                            @error('account_type')
                                <small class="text-red">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="mt-4 primary-button">Register</button>
    
                </form>
            </div>
        </div>
    </div>
@endsection