<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function TopUpNow(Request $request)
    {
        $user_id = Auth::user()->id;
        $credit = $request->credit;
        $status = "proses";
        $description = 'Top Up Saldo';

        Wallet::create([
            'user_id' => $user_id,
            'credit' => $credit,
            'status' => $status,
            'description' => $description
        ]);

        return redirect()->back()->with('status', 'Berhasil merequest top up. Silakan setor uangnya ke Teller Bank Mini');
    }

    public function acceptRequest(Request $request){
        $wallet_id = $request->wallet_id;

        Wallet::find($wallet_id)->update([
            'status' => 'selesai'
        ]);

        return redirect()->back()->with('status', 'successfully approved the top up request');
    }
}
