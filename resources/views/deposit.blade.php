@extends('layouts.app')
@section('content')
    <div class="mt-4">
        @auth
            <table class="table-fixed text-center text-white">
                <caption class="text-red">Deposits Details</caption>
                <thead>
                  <tr>
                    <th>Serial</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Fee</th>
                  </tr>
                </thead>
                <tbody>
                    @forelse ( $data['deposits'] as $key => $transaction )
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $transaction->date }}</td>
                            <td>{{ $transaction->amount }}</td>
                            <td>{{ $transaction->fee }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No Deposits Found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="balance-section">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Total : {{ $data['total'] }}</h2>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Balance : {{ $data['balance'] }}</h2>
            </div>

        @else
            <div class="flex justify-center items-center">
                <h2 class="mt-16 text-xl font-semibold text-gray-900 dark:text-white">Please <a href="{{ route('login') }}" class="text-red">Login</a> or <a href="{{ route('register') }}" class="text-red">Register</a> to continue</h2>
            </div>
            @endauth

            <div>
                <div class="flex justify-center items-center">
                    <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Add</h2>
                </div>

                <div class="flex justify-center items-center mt-4">
                    <form action="{{ route('deposit') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <div>
                                <label for="amount" class="text-white">Amount
                                    <input type="number" step="0.0001" name="amount" id="amount" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white text-gray-900">
                                    @error('amount')
                                        <small class="text-red">{{ $message }}</small>
                                    @enderror
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="mt-4 primary-button">Deposit</button>

                    </form>
                </div>
            </div>
    </div>
@endsection

