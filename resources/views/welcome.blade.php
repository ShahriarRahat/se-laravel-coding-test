@extends('layouts.app')
@section('content')
    <div class="mt-4">
        @auth
            <table class="table-fixed text-center text-white">
                <caption class="text-red">Transaction Details</caption>
                <thead>
                  <tr>
                    <th>Serial</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Fee</th>
                    <th>Transaction Type</th>
                  </tr>
                </thead>
                <tbody>
                    @forelse ( $data['transactions'] as $key => $transaction )
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $transaction->date }}</td>
                            <td>{{ $transaction->amount }}</td>
                            <td>{{ $transaction->fee }}</td>
                            <td>{{ strtoupper($transaction->transaction_type) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No Transaction Found</td>
                        </tr>
                    @endforelse
                </tbody>
              </table>
              <h2 class="mt-16 text-xl font-semibold text-gray-900 dark:text-white">Balance : {{ $data['balance'] }}</h2>
        @else
            <div class="flex justify-center items-center">
                <h2 class="mt-16 text-xl font-semibold text-gray-900 dark:text-white">Please <a href="{{ route('login') }}" class="text-red">Login</a> or <a href="{{ route('register') }}" class="text-red">Register</a> to continue</h2>
            </div>
            @endauth

                {{-- <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                    Laravel has wonderful documentation covering every aspect of the framework. Whether you are a newcomer or have prior experience with Laravel, we recommend reading our documentation from beginning to end.
                </p> --}}
    </div>
@endsection

