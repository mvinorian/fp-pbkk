<?php

namespace App\Infrastructure\Repository;

use App\Core\Domain\Models\Seri\Seri;
use Exception;
use Illuminate\Support\Facades\DB;

class SqlSeriRepository
{
    public function persist(Seri $seri): void
    {
        DB::table('seri')->upsert([
            'id' => $seri->getId(),
            'penerbit_id' => $seri->getPenerbitId(),
            'judul' => $seri->getJudul(),
            'sinopsis' => $seri->getSinopsis(),
            'tahun_terbit' => $seri->getTahunTerbit(),
            'skor' => $seri->getSkor(),
            'foto' => $seri->getFoto(),
        ], 'id');
    }

    /**
     * @throws Exception
     */
    public function find(int $id): ?Seri
    {
        $row = DB::table('seri')->where('id', $id)->first();

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
        $seri = [];
        foreach ($rows as $row) {
            $seri[] = new Seri(
                $row->id,
                $row->penerbit_id,
                $row->judul,
                $row->sinopsis,
                $row->tahun_terbit,
                $row->skor,
                $row->foto,
            );
        }
        return $seri;
    }
}
