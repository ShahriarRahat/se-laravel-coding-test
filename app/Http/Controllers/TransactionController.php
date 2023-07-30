<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index()
    {
        $data = [];

        if (auth()->check()) {
            $data['transactions'] = auth()->user()->transactions;
            $data['deposits'] = auth()->user()->deposits->sum('amount');
            $data['withdrawals'] = auth()->user()->withdrawals->sum('amount');
            $data['balance'] = $data['deposits'] - $data['withdrawals'];
        }

        return view('welcome', compact('data'));
    }

    public function deposits()
    {
        $data['deposits'] = auth()->user()->deposits;
        $data['total'] = $data['deposits']->sum('amount');
        return view('deposit', compact('data'));
    }

    public function withdrawals()
    {
        $data['withdrawals'] = auth()->user()->withdrawals;
        $data['total'] = $data['withdrawals']->sum('amount');
        return view('withdrawal', compact('data'));
    }

    public function withdrawal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            Toastr::error($validator->errors()->first());
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        DB::beginTransaction();
        try {
            Transaction::create([
                'user_id' => auth()->user()->id,
                'amount' => $request->amount,
                'transaction_type' => 'withdrawal',
            ]);
            $balance = auth()->user()->deposits->sum('amount') - auth()->user()->withdrawals->sum('amount');
            $user = User::where('id', auth()->user()->id)->first();
            $user->update([
                'balance' => $balance
            ]);
            DB::commit();
            Toastr::success('Withdrawal Successful');
            return redirect()->back();
        }catch (\Throwable $th) {
            DB::rollBack();
            Toastr::error('Sorry! Something went wrong');
            return redirect()->back();
        }
    }

    public function deposit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            Toastr::error($validator->errors()->first());
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        DB::beginTransaction();
        try {
            Transaction::create([
                'user_id' => auth()->user()->id,
                'amount' => $request->amount,
                'transaction_type' => 'deposit',
            ]);
            $user = User::where('id', auth()->user()->id)->first();
            $balance = auth()->user()->deposits->sum('amount') - auth()->user()->withdrawals->sum('amount');
            $user->update([
                'balance' => $balance
            ]);
            DB::commit();
            Toastr::success('Deposit Successful');
            return redirect()->back();
        }catch (\Throwable $th) {
            DB::rollBack();
            Toastr::error('Sorry! Something went wrong');
            return redirect()->back();
        }
    }

}
