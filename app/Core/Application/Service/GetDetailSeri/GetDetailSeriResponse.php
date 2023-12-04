<?php

namespace App\Core\Application\Service\GetDetailSeri;

use JsonSerializable;

class GetDetailSeriResponse implements JsonSerializable
{
    private string $id;
    private string $judul;
    private string $sinopsis;
    private string $tahun_terbit;
    private string $skor;
    private string $foto;
    private string $penerbit;
    private array $volume;
    private array $penulis;
    private array $genre;

    public function __construct(string $id, string $judul, string $sinopsis, string $tahun_terbit, string $skor, string $foto, string $penerbit, array $volume, array $penulis, array $genre)
    {
        $this->id = $id;
        $this->judul = $judul;
        $this->sinopsis = $sinopsis;
        $this->tahun_terbit = $tahun_terbit;
        $this->skor = $skor;
        $this->foto = $foto;
        $this->penerbit = $penerbit;
        $this->volume = $volume;
        $this->penulis = $penulis;
        $this->genre = $genre;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'judul' => $this->judul,
            'sinopsis' => $this->sinopsis,
            'tahun_terbit' => $this->tahun_terbit,
            'skor' => $this->skor,
            'foto' => $this->foto,
            'penerbit' => $this->penerbit,
            'volume' => $this->volume,
            'penulis' => $this->penulis,
            'genre' => $this->genre
        ];
    }
}
