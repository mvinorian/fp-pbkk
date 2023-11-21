<?php

namespace App\Http\Controllers;

use Xendit\Configuration;
use Xendit\Invoice\Invoice;
use Illuminate\Http\Request;
use Xendit\Invoice\InvoiceApi;
use Xendit\Invoice\CreateInvoiceRequest;
use App\Core\Domain\Models\Peminjaman\Peminjaman;
use App\Core\Domain\Models\Peminjaman\PeminjamanId;
use App\Core\Domain\Models\User\UserId;
use App\Infrastructure\Repository\SqlPeminjamanRepository;
use DateTime;

class PeminjamanController extends Controller
{
    public function __construct() {
        Configuration::setXenditKey(env('XENDIT_API_KEY', ""));
    }

    public function create(Request $request) {
        $invoiceApi = new InvoiceApi();
        $sql = new SqlPeminjamanRepository();
        // dd($request->all());
        $input = [
            'external_id' => PeminjamanId::generate()->toString(),
            "type" => $request->input('type'),
            "amount"=> $request->input('amount'),
            "callback_url"=> "http://localhost:8000/callback"
        ];
        $response = $invoiceApi->createInvoice($input);

        $invoice = Peminjaman::create(
            new PeminjamanId($response['external_id']),
            new UserId('6c84fb9e-5ab2-4d98-b44b-9713a16d7a7e'),
            $response['created']->format('Y-m-d H:i:s'),
            $response['invoice_url'],
            $response['status'],
            1,
            $response['amount']
        );

        $sql->persist($invoice);

        return response()->json($response['invoice_url']);
    }

    public function webhook(Request $request) {
        $invoiceApi = new InvoiceApi();
        $getInvoice = $invoiceApi->getInvoiceById($request->input('id'));

        $sql = new SqlPeminjamanRepository();
        $payment = $sql->find($getInvoice['external_id']);

        $payment->setStatus($getInvoice['status']);
        $sql->persist($payment);

        return response()->json($getInvoice);
    }
}
