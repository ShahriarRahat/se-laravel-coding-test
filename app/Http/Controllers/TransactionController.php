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
            $data['balance'] = auth()->user()->balance;
        }

        return view('welcome', compact('data'));
    }

    public function deposits()
    {
        $data['deposits'] = auth()->user()->deposits;
        $data['total'] = $data['deposits']->sum('amount');
        $data['balance'] = auth()->user()->balance;
        return view('deposit', compact('data'));
    }

    public function withdrawals()
    {
        $data['withdrawals'] = auth()->user()->withdrawals;
        $data['total'] = $data['withdrawals']->sum('amount');
        $data['balance'] = auth()->user()->balance;
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
            $user = User::where('id', auth()->id())->first();

            $transaction = Transaction::create([
                'user_id' => $user->id,
                'amount' => $request->amount,
                'fee' => $this->feeCount($request->amount),
                'transaction_type' => 'withdrawal',
                'date' => now()->toDateString()
            ]);

            $balance = $user->balance - ($transaction->amount + $transaction->fee);
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
            $user = User::where('id', auth()->id())->first();

            Transaction::create([
                'user_id' => $user->id,
                'amount' => $request->amount,
                'transaction_type' => 'deposit',
                'date' => now()->toDateString()
            ]);

            $balance = $user->balance + $request->amount;
            $user->update([
                'balance' => $balance
            ]);

            DB::commit();
            Toastr::success('Deposit Successful');
            return redirect()->back();
        }catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            Toastr::error('Sorry! Something went wrong');
            return redirect()->back();
        }
    }

    private function feeCount($amount)
    {
        $user = auth()->user();

        $start_date = now()->startOfMonth();
        $end_date = now()->endOfMonth();

        $currentMonthWithdrawal = $user->withdrawals->whereBetween('date', [$start_date, $end_date])->where('user_id', $user->id)->sum('amount');

        if($user->account_type == 'individual') {
            if(now()->format('l') == 'Friday' || $currentMonthWithdrawal <= 5000) {
                $fee = 0;
            }else{
                $fee = $amount <= 1000 ? 0 : ($amount -1000) * 0.015/100;
            }
        }else{
            $totalWithDrawal = $user->withdrawals->sum('amount');
            if($totalWithDrawal > 5000) {
                $fee = $amount * 0.015/100;
            }else{
                $fee = $amount * 0.025/100;
            }
        }

        return $fee;
    }

}
