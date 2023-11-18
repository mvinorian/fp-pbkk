<?php

namespace App\Core\Application\Service\GetCartUser;

use JsonSerializable;

class GetCartUserResponse implements JsonSerializable
{
    // private string $id;
    private string $foto;
    private string $jumlah_tersedia;
    private string $jumlah_sewa;
    private string $harga_sewa;
    private string $volume;
    private string $harga_sub_total;
    private string $judul_seri;

    public function __construct(string $foto, string $jumlah_tersedia, string $jumlah_sewa, string $harga_sewa, string $volume, string $harga_sub_total, string $judul_seri)
    {
        // $this->id = $id;
        $this->foto = $foto;
        $this->jumlah_tersedia = $jumlah_tersedia;
        $this->jumlah_sewa = $jumlah_sewa;
        $this->harga_sewa = $harga_sewa;
        $this->volume = $volume;
        $this->harga_sub_total = $harga_sub_total;
        $this->judul_seri = $judul_seri;
    }

    public function jsonSerialize(): array
    {
        return [
            // 'id' => $this->id,
            'foto' => $this->foto,
            'jumlah_tersedia' => $this->jumlah_tersedia,
            'jumlah_sewa' => $this->jumlah_sewa,
            'harga_sewa' => $this->harga_sewa,
            'volume' => $this->volume,
            'harga_sub_total' => $this->harga_sub_total,
            'judul_seri' => $this->judul_seri,
        ];
    }
}
