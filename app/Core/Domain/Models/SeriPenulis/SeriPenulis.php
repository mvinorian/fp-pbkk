<?php

namespace App\Core\Domain\Models\SeriPenulis;

class SeriPenulis
{
    private int $id;
    private int $seri_id;
    private int $penulis_id;

    /**
     * @param int $id
     * @param int $seri_id
     * @param int $penulis_id
     */
    public function __construct(int $id, int $seri_id, int $penulis_id)
    {
        $this->id = $id;
        $this->seri_id = $seri_id;
        $this->penulis_id = $penulis_id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getSeriId(): int
    {
        return $this->seri_id;
    }

    public function getPenulisId(): int
    {
        return $this->penulis_id;
    }
}
