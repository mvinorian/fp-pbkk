<?php

namespace App\Infrastrucutre\Repository;

use App\Core\Domain\Models\Penulis\Penulis;
use Exception;
use Illuminate\Support\Facades\DB;

class SqlPenulisRepository
{
    public function persist(Penulis $penulis): void
    {
        DB::table('penulis')->upsert([
            'id' => $penulis->getId(),
            'nama_depan' => $penulis->getNamaDepan(),
            'nama_belakang' => $penulis->getNamaBelakang(),
            'peran' => $penulis->getPeran(),
        ], 'id');
    }

    /**
     * @throws Exception
     */
    public function find(int $id): ?Penulis
    {
        $row = DB::table('penulis')->where('id', $id)->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    /**
     * @throws Exception
     */
    public function constructFromRows(array $rows): array
    {
        $penulis = [];
        foreach ($rows as $row) {
            $penulis[] = new Penulis(
                $row->id,
                $row->nama_depan,
                $row->nama_belakang,
                $row->peran,
            );
        }
        return $penulis;
    }
}
