<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class PrintController extends Controller
{
    /**
     * Print the bill for a given payment ID.
     *
     * @param  mixed $payment_id
     * @return void
     */
    public function bill($payment_id)
    {
        $payment = Payment::query()
            ->with(['bill.customer.user', 'method', 'bill.customer.tarif'])
            ->where('status', 'verified')
            ->findOrFail(decrypt($payment_id));

        $title = "Tagihan {$payment->bill->invoice} {$payment->bill->period} {$payment->bill->customer->user->name} - " . config('app.name');

        $pdf = Pdf::loadView('print.bill', [
            'payment' => $payment,
            'bill' => $payment->bill,
            'method' => $payment->method,
            'customer' => $payment->bill->customer,
            'user' => $payment->bill->customer->user,
            'tarif' => $payment->bill->customer->tarif,
            'title' => $title,
        ])->output();

        return response()->stream(
            function () use ($pdf) {
                echo $pdf;
            },
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $title . '.pdf"',
            ]
        );
    }
}
