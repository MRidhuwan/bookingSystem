<?php

namespace App\Http\Controllers;


use App\Mail\TransactionSuccess;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransController extends Controller
{
    //
    
    public function callbackNotification(Request $request)
    {

        //configurasi pembayaran melalui Midtrans
        Config::$serverKey     = config('midtrans.serverKey');
       Config::$isProduction  = config('midtrans.isProduction');
        Config::$isSanitized      = config('midtrans.isSanitized');
        Config::$is3ds              = config('midtrans.is3ds');

        $notification = new Notification();

        //pecah order id nya agar bisa diterima oleh db
        $order = explode( ' - ', $notification->order_id);

        //assign ke variable untuk memudahkan coding
        $status = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status;
       
        // $order_id ='MIDTRANS-' . $notification->order_id;
        $order_id = [1];
       
        //cari transaksi berdasrkan id
        $transaction = Transaction::findorFail($order_id);
        // dd($transaction);
        //handle notifikasi status payment midtrans
      if ($status == 'capture') {
            if ($type == 'credit_card'){
                if($fraud == 'challenge'){
                    $transaction->payment_status = 'CHALLENGE';
                }
                else {
                    $transaction->payment_status = 'SUCCESS';
                }
            }
        }
        else if ($status == 'settlement'){
            $transaction->payment_status = 'SUCCESS';
        }
        else if($status == 'pending'){
            $transaction->payment_status = 'PENDING';
        }
        else if ($status == 'deny') {
            $transaction->payment_status = 'FAILED';
        }
        else if ($status == 'expire') {
            $transaction->payment_status = 'EXPIRED';
        }
        else if ($status == 'cancel') {
            $transaction->payment_status = 'FAILED';
        }

        // Simpan transaksi
        $transaction->save();

        // Kirimkan email
        if ($transaction)
        {
            if($status == 'capture' && $fraud == 'accept' )
            {
                Mail::to($transaction->user)->send(
                    new TransactionSuccess($transaction)
                );
            }
            else if ($status == 'settlement')
            {
                Mail::to($transaction->user)->send(
                    new TransactionSuccess($transaction)
                );
            }
            else if ($status == 'success')
            {
                Mail::to($transaction->user)->send(
                    new TransactionSuccess($transaction)
                );
            }
            else if($status == 'capture' && $fraud == 'challenge' )
            {
                return response()->json([
                    'meta' => [
                        'code' => 200,
                        'message' => 'Midtrans Payment Challenge'
                    ]
                ]);
            }
            else
            {
                return response()->json([
                    'meta' => [
                        'code' => 200,
                        'message' => 'Midtrans Payment not Settlement'
                    ]
                ]);
            }

            return response()->json([
                'meta' => [
                    'code' => 200,
                    'message' => 'Midtrans Notification Success'
                ]
            ]);
        }
    }

    public function finishRedirect(Request $request)
    {
        return view('pages.success');
    }

    public function unfinishRedirect(Request $request)
    {
        return view('pages.unfinish');
    }

    public function errorRedirect(Request $request)
    {
        return view('pages.failed');
    }
}
