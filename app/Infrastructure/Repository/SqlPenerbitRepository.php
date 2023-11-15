<?php

namespace App\Infrastrucutre\Repository;

use App\Core\Domain\Models\Penerbit\Penerbit;
use Exception;
use Illuminate\Support\Facades\DB;

class SqlPenerbitRepository
{
    public function persist(Penerbit $penerbit): void
    {
        DB::table('penerbit')->upsert([
            'id' => $penerbit->getId(),
            'nama' => $penerbit->getNama(),
        ], 'id');
    }

    /**
     * @throws Exception
     */
    public function find(int $id): ?Penerbit
    {
        $row = DB::table('penerbit')->where('id', $id)->first();

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
        $penerbit = [];
        foreach ($rows as $row) {
            $penerbit[] = new Penerbit(
                $row->id,
                $row->nama,
            );
        }
        return $penerbit;
    }
}
