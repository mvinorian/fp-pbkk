<?php

namespace App\Http\Controllers;

use Throwable;
use Inertia\Inertia;
use Xendit\Configuration;
use Illuminate\Http\Request;
use Xendit\Invoice\InvoiceApi;
use Illuminate\Support\Facades\DB;
use App\Infrastructure\Repository\SqlPeminjamanRepository;
use App\Core\Application\Service\WebhookXendit\WebhookXenditService;
use App\Core\Application\Service\GetMyPeminjaman\GetMyPeminjamanService;
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
            return Inertia::render('auth/register', $this->errorProps(1022, 'Email sudah terdaftar'));
        }
        DB::commit();

        return Inertia::location($response['invoice_url']);
    }

    public function webhook(Request $request, WebhookXenditService $service)
    {
        $service->execute($request->input('external_id'));
    }

    public function getMyPeminjamanList(Request $request, GetMyPeminjamanService $service)
    {
        $response = $service->execute('fa621d02-4659-42a2-bb21-80d70e2cf953');
        dd($response);
        return Inertia::render('auth/register', $this->errorProps(1022, 'Email sudah terdaftar'));
    }
}
