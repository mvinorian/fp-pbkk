<?php

namespace App\Core\Application\Service\CreatePeminjaman;

use Exception;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Models\Peminjaman\Peminjaman;
use App\Core\Domain\Models\Peminjaman\PeminjamanId;
use App\Infrastructure\Repository\SqlPeminjamanRepository;

class CreatePeminjamanService
{
    private SqlPeminjamanRepository $peminjaman_repository;

    public function __construct(SqlPeminjamanRepository $peminjaman_repository)
    {
        Configuration::setXenditKey(env('XENDIT_API_KEY', ""));
        $this->peminjaman_repository = $peminjaman_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(string $amount)
    {
        $invoiceApi = new InvoiceApi();
        $user_id = "fa621d02-4659-42a2-bb21-80d70e2cf953";
        $input = [
            'external_id' => PeminjamanId::generate()->toString(),
            "type" => "INVOICE",
            "amount" => $amount,
            "callback_url" => "https://1fef-2a09-bac1-34c0-50-00-279-45.ngrok-free.app/peminjaman/webhook"
        ];
        $response = $invoiceApi->createInvoice($input);

        $peminjaman_id = new PeminjamanId($response['external_id']);

        $invoice = Peminjaman::create(
            $peminjaman_id,
            new UserId($user_id),
            $response['created']->format('Y-m-d H:i:s'),
            $response['invoice_url'],
            $response['status'],
            1,
            $response['amount']
        );

        $this->peminjaman_repository->persist($invoice);
        return $response;
    }
}
