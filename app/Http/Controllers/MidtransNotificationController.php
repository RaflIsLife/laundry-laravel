<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Midtrans\Notification;

class MidtransNotificationController extends Controller
{
    public function notificationHandler(){
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is3ds');

        try {
            $notification = new Notification();
        }
        catch (\Exception $e) {
            exit($e->getMessage());
        }

        $transactionStatus = $notification->transaction_status;
        $type = $notification->payment_type;
        $order_id = $notification->order_id;
        $fraud = $notification->fraud_status;

        $transaksi = Transaksi::where('id', $order_id)->first();

        if ($transactionStatus == 'capture') {
            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $transaksi->status_pembayaran = 'Challenge by FDS';
                    echo "transactionStatus order_id: " . $order_id ." is challenged by FDS";
                } else {
                    $transaksi->status_pembayaran = 'Success';
                    echo "transactionStatus order_id: " . $order_id ." successfully captured using " . $type;
                }
            }
        } else if ($transactionStatus == 'settlement') {
            $transaksi->status_pembayaran = 'Success';
            if($transaksi->cara_pemesanan == 'offline'){
                $transaksi->status = 'antrian laundry';
            } else {
                $transaksi->status = 'menunggu pengambilan';
            }
            echo "transactionStatus order_id: " . $order_id ." successfully transfered using " . $type;
        } else if ($transactionStatus == 'pending') {
            $transaksi->status_pembayaran = 'Pending';
            echo "Waiting customer to finish transactionStatus order_id: " . $order_id . " using " . $type;
        } else if ($transactionStatus == 'deny') {
            $transaksi->status_pembayaran = 'Denied';
            echo "Payment using " . $type . " for transactionStatus order_id: " . $order_id . " is denied.";
        } else if ($transactionStatus == 'expire') {
            $transaksi->status_pembayaran = 'expire';
            echo "Payment using " . $type . " for transactionStatus order_id: " . $order_id . " is expired.";
        } else if ($transactionStatus == 'cancel') {
            $transaksi->status_pembayaran = 'Denied';
            echo "Payment using " . $type . " for transactionStatus order_id: " . $order_id . " is canceled.";
        }

        $transaksi->save();
    }
}
