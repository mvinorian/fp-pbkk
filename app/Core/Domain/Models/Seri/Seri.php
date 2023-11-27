<?php

namespace App\Core\Domain\Models\Seri;

class Seri
{
    private int $id;
    private int $penerbit_id;
    private string $judul;
    private string $sinopsis;
    private string $tahun_terbit;
    private string $skor;
    private string $foto;

    /**
     * @param int $id
     * @param int $penerbit_id
     * @param string $judul
     * @param string $sinopsis
     * @param string $tahun_terbit
     * @param string $skor
     * @param string $foto
     */
    public function __construct(int $id, int $penerbit_id, string $judul, string $sinopsis, string $tahun_terbit, string $skor, string $foto)
    {
        $this->id = $id;
        $this->penerbit_id = $penerbit_id;
        $this->judul = $judul;
        $this->sinopsis = $sinopsis;
        $this->tahun_terbit = $tahun_terbit;
        $this->skor = $skor;
        $this->foto = $foto;
    }

    public static function create(int $id, int $penerbit_id, string $judul, string $sinopsis, string $tahun_terbit, string $skor, string $foto)
    {
        return new self(
            $id,
            $penerbit_id, 
            $judul, 
            $sinopsis, 
            $tahun_terbit, 
            $skor, 
            $foto
        );
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPenerbitId(): int
    {
        return $this->penerbit_id;
    }

    public function getJudul(): string
    {
        return $this->judul;
    }

    public function getSinopsis(): string
    {
        return $this->sinopsis;
    }

    public function getTahunTerbit(): string
    {
        return $this->tahun_terbit;
    }

    public function getSkor(): string
    {
        return $this->skor;
    }

    public function getFoto(): string
    {
        return $this->foto;
    }
}
