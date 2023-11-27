<?php

namespace App\Http\Controllers;

use Throwable;
use Inertia\Inertia;
use Xendit\Configuration;
use Illuminate\Http\Request;
use Xendit\Invoice\InvoiceApi;
use Illuminate\Support\Facades\DB;
use App\Infrastructure\Repository\SqlPeminjamanRepository;
use App\Core\Application\Service\CreatePeminjaman\CreatePeminjamanService;

class PeminjamanController extends Controller
{
    public function __construct()
    {
        Configuration::setXenditKey(env('XENDIT_API_KEY', ""));
    }

    public function create(Request $request, CreatePeminjamanService $service)
    {
        DB::beginTransaction();
        try {
            $response = $service->execute($request->input('amount'));
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e);
            return Inertia::render('auth/register', $this->errorProps(1022, 'Email sudah terdaftar'));
        }
        DB::commit();

        return Inertia::location($response['invoice_url']);
    }

    public function webhook(Request $request)
    {
        $invoiceApi = new InvoiceApi();
        $getInvoice = $invoiceApi->getInvoiceById($request->input('id'));

        $sql = new SqlPeminjamanRepository();
        $payment = $sql->find($getInvoice['external_id']);

        $payment->setStatus($getInvoice['status']);
        $sql->persist($payment);

        return response()->json($getInvoice);
    }
}
