<?php

namespace App\Core\Domain\Models\Penulis;

class Penulis
{
    private int $id;
    private string $nama_depan;
    private string $nama_belakang;
    private string $peran;

    /**
     * @param int $id
     * @param string $nama_depan
     * @param string $nama_belakang
     * @param string $peran
     */
    public function __construct(int $id, string $nama_depan, string $nama_belakang, string $peran)
    {
        $this->id = $id;
        $this->nama_depan = $nama_depan;
        $this->nama_belakang = $nama_belakang;
        $this->peran = $peran;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNamaDepan(): string
    {
        return $this->nama_depan;
    }

    public function getNamaBelakang(): string
    {
        return $this->nama_belakang;
    }

    public function getPeran(): string
    {
        return $this->peran;
    }
}