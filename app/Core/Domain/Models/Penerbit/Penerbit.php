<?php

namespace App\Core\Domain\Models\Penerbit;

class Penerbit
{
    private int $id;
    private string $nama;

    /**
     * @param int $id
     * @param string $nama
     */
    public function __construct(int $id, string $nama)
    {
        $this->id = $id;
        $this->nama = $nama;
    }

    public static function create(int $id, string $nama)
    {
        return new self(
            $id,
            $nama
        );
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNama(): string
    {
        return $this->nama;
    }
}
