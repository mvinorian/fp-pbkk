<?php

namespace App\Infrastructure\Repository;

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

    public function getPenulisBySeriId(int $seri_id): array
    {
        $rows = DB::table('penulis')
            ->join('seri_penulis', 'penulis.id', '=', 'seri_penulis.penulis_id')
            ->where('seri_penulis.seri_id', $seri_id)
            ->get();
        $penulis = [];
        foreach ($rows as $row) {
            $penulis[] = $this->constructFromRows([$row])[0];
        }
        return $penulis;
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
