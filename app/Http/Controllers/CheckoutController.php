<?php

namespace App\Http\Controllers;


use Mail;
use App\Transaction;
use App\TransactionDetail;
use App\TravelPackage;
use App\Mail\TransactionSuccess;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;


class CheckoutController extends Controller
{
    public function index(Request $request, $id)
    {
        $item = Transaction::with(['details', 'travel_package', 'user'])->findOrFail($id);

        return view('pages.checkout', ['item' => $item]);
    }


    public function process(Request $request, $id)
    {
        $travel_package = TravelPackage::findOrFail($id);
        $transaction = Transaction::create(
            [
                'travel_packages_id'    => $id,
                'users_id'              => Auth::user()->id,
                'additional_visa'       => 0,
                'transaction_total'     => $travel_package->price,
                'transaction_status'    => 'IN_CART'
            ]
        );

        TransactionDetail::create([
            'transactions_id' => $transaction->id,
            'username' => Auth::user()->username,
            'nationality' => 'IND',
            'is_visa' => false,
            'doe_passport' => Carbon::now()->addYears(5)

        ]);
        return redirect()->route('checkout', $transaction->id);
    }


    public function remove(Request $request, $detail_id)
    {
        $item = TransactionDetail::findorFail($detail_id);


        $transaction = Transaction::with([
            'details', 'travel_package'
        ])->findOrFail($item->transactions_id);

        if ($item->is_visa) {
            $transaction->transaction_total -= 190;
            $transaction->additional_visa -= 190;
        }
        $transaction->transaction_total -= $transaction->travel_package->price;

        $transaction->save();

        $item->delete();

        return redirect()->route('checkout', $item->transactions_id);
    }


    public function create(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|string|exists:users,name',
            'nationality' => 'required|string',
            'is_visa' => 'required|boolean',
            'doe_passport' => 'required'

        ]);

        $data = $request->all();

        $data['transactions_id'] = $id;

        TransactionDetail::create($data);
        $transaction = Transaction::with(['travel_package'])->find($id);

        if ($request->is_visa) {
            $transaction->transaction_total += 190;
            $transaction->additional_visa += 190;
        }
        $transaction->transaction_total += $transaction->travel_package->price;

        $transaction->save();

        return redirect()->route('checkout', $id);
    }


    public function success(Request $request, $id)
    {
        $transaction = Transaction::with(['details', 'travel_package.galleries', 'user'])->findOrFail($id);

        $transaction->transaction_status = 'PENDING';

        $transaction->save();

        // return $transaction;

        //kirim ke email
        // Mail::to($transaction->user)->send(new TransactionSuccess($transaction));

        // return view('pages.success');

        // Set your Merchant Server Key
        Config::$serverKey = config('midtrans.serverKey');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        Config::$isProduction = config('midtrans.isProduction');
        // Set sanitization on (default)
        Config::$isSanitized = config('midtrans.isSanitized');
        // Set 3DS transaction for credit card to true
        Config::$is3ds = config('midtrans.is3ds');

        //buat deskripsi array untuk dikirimkan ke midtrans
        $midtrans_params =
            [
                'transaction_details'   =>
                [
                    'order_id'               => 'MIDTRANS-' . $transaction->id,
                    'gross_amount'      => (int) $transaction->transaction_total
                ],
                'customer_details'      =>
                [
                    'first_name'        => $transaction->user->name,
                    'email'              => $transaction->user->email
                ],
                'enable_payments'       => ["gopay", "bank_transfer", "credit_card", 
                "bca_klikpay", "bca_klikbca", "bri_epay", "mandiri_clickpay", "telkomsel_cash", 
                "echannel", "indosat_dompetku", "cstore"],
                'vtweb'                 => []
            ];

        try {
            // Get Snap Payment Page URL
            $paymentUrl = Snap::createTransaction($midtrans_params)->redirect_url;

            // Redirect to Snap Payment Page
            return redirect ($paymentUrl);
            // header( ' Location: ' . $paymentUrl);
        } 
        catch (Exception $e) {
            echo $e->getMessage();
        }
            // dd($paymentUrl);
    }
}
