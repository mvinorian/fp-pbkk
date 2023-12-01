<?php

namespace App\Core\Application\Service\WebhookXendit;

use Exception;
use Xendit\Configuration;
use App\Core\Domain\Models\Peminjaman\PeminjamanId;
use App\Infrastructure\Repository\SqlCartRepository;
use App\Infrastructure\Repository\SqlPeminjamanRepository;
use App\Core\Domain\Models\PeminjamanVolume\PeminjamanVolume;
use App\Infrastructure\Repository\SqlPeminjamanVolumeRepository;

class WebhookXenditService
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
    public function execute(string $id)
    {
        $peminjaman = $this->peminjaman_repository->find(new PeminjamanId($id));

        $peminjaman->setStatus('SUCCESS');
        $this->peminjaman_repository->persist($peminjaman);

        $carts = $this->cart_repository->findByUserId($peminjaman->getUserId());
        foreach ($carts as $cart) {
            $peminjaman_volume = PeminjamanVolume::create(
                $peminjaman->getId(),
                $cart->getVolumeId(),
            );
            $this->peminjaman_volume_repository->persist($peminjaman_volume);

            $this->cart_repository->delete($cart->getVolumeId());
        }
    }
}
