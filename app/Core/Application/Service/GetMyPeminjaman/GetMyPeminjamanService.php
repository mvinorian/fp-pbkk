<?php

namespace App\Core\Application\Service\GetMyPeminjaman;

use Exception;
use App\Core\Domain\Models\Seri\Seri;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Models\Volume\Volume;
use App\Infrastructure\Repository\SqlCartRepository;
use App\Infrastructure\Repository\SqlSeriRepository;
use App\Infrastructure\Repository\SqlVolumeRepository;
use App\Infrastructure\Repository\SqlPeminjamanRepository;
use App\Infrastructure\Repository\SqlPeminjamanVolumeRepository;
use App\Core\Application\Service\GetMyPeminjaman\GetMyPeminjamanResponse;

class GetMyPeminjamanService
{
    private SqlPeminjamanRepository $peminjaman_repository;
    private SqlPeminjamanVolumeRepository $peminjaman_volume_repository;
    private SqlVolumeRepository $volume_repository;
    private SqlSeriRepository $seri_repository;

    public function __construct(SqlPeminjamanRepository $peminjaman_repository, SqlPeminjamanVolumeRepository $peminjaman_volume_repository, SqlVolumeRepository $volume_repository, SqlSeriRepository $seri_repository)
    {
        $this->peminjaman_repository = $peminjaman_repository;
        $this->peminjaman_volume_repository = $peminjaman_volume_repository;
        $this->volume_repository = $volume_repository;
        $this->seri_repository = $seri_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(string $user_id)
    {
        $peminjamans = $this->peminjaman_repository->getAllPeminjamanByUserId($user_id);
        $peminjaman_response = [];
        foreach ($peminjamans as $peminjaman) {
            $volumes = [];
            $seris = [];
            foreach ($this->peminjaman_volume_repository->getAllPeminjamanVolumeByPeminjamanId($peminjaman->getId()) as $peminjaman_volume) {
                $volume = $this->volume_repository->find($peminjaman_volume->getVolumeId());
                $seri = $this->seri_repository->find($volume->getSeriId());
                $volumes[] = new Volume(
                    $volume->getId(),
                    $volume->getSeriId(),
                    $volume->getVolume(),
                    $volume->getJumlahTersedia(),
                    $volume->getHargaSewa(),
                );
                $seris[] = new Seri(
                    $seri->getId(),
                    $seri->getPenerbitId(),
                    $seri->getJudul(),
                    $seri->getSinopsis(),
                    $seri->getTahunTerbit(),
                    $seri->getSkor(),
                    $seri->getFoto()
                );
            }
            dd($seris);
            // $peminjaman_response[] = new GetMyPeminjamanResponse(
            //     $p->getId()->toString(),
            //     $p->getUserId()->toString(),
            //     $p->getPaidAt(),
            //     $p->getInvoiceUrl(),
            //     $p->getStatus(),
            //     $p->getJumlah(),
            //     $p->getHargaTotal(),
            // );
        }
        return $peminjaman_response;
    }
}
