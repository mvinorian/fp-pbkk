<?php

namespace App\Core\Application\Service\CreatePeminjaman;

use Exception;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Models\Peminjaman\Peminjaman;
use App\Core\Domain\Models\Peminjaman\PeminjamanId;
use App\Infrastructure\Repository\SqlCartRepository;
use App\Infrastructure\Repository\SqlPeminjamanRepository;
use App\Core\Domain\Models\PeminjamanVolume\PeminjamanVolume;
use App\Infrastructure\Repository\SqlPeminjamanVolumeRepository;

class CreatePeminjamanService
{
    private SqlPeminjamanRepository $peminjaman_repository;
    private SqlPeminjamanVolumeRepository $peminjaman_volume_repository;
    private SqlCartRepository $cart_repository;

    public function __construct(SqlPeminjamanRepository $peminjaman_repository, SqlPeminjamanVolumeRepository $peminjaman_volume_repository, SqlCartRepository $cart_repository)
    {
        Configuration::setXenditKey(env('XENDIT_API_KEY', ""));
        $this->peminjaman_repository = $peminjaman_repository;
        $this->peminjaman_volume_repository = $peminjaman_volume_repository;
        $this->cart_repository = $cart_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(string $amount)
    {
        $invoiceApi = new InvoiceApi();
        // $user_id = auth()->user()->id;
        $user_id = "6c84fb9e-5ab2-4d98-b44b-9713a16d7a7e";
        $input = [
            'external_id' => PeminjamanId::generate()->toString(),
            "type" => "INVOICE",
            "amount"=> $amount,
            "callback_url"=> "http://localhost:8000/callback"
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
        
        $carts = $this->cart_repository->findByUserId(new UserId($user_id));
        foreach ($carts as $cart) {
            $peminjaman_volume = PeminjamanVolume::create(
                $peminjaman_id,
                $cart->getVolumeId(),
            );
            $this->peminjaman_volume_repository->persist($peminjaman_volume);

            $this->cart_repository->delete($cart->getId());
        }

        return $response;
    }
}
