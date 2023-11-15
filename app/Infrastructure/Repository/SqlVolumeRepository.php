<?php

namespace App\Infrastructure\Repository;

use App\Core\Domain\Models\Volume\Volume;
use Exception;
use Illuminate\Support\Facades\DB;

class SqlVolumeRepository
{
    public function persist(Volume $volume): void
    {
        DB::table('volume')->upsert([
            'id' => $volume->getId(),
            'seri_id' => $volume->getSeriId(),
            'volume' => $volume->getVolume(),
            'jumlah_tersedia' => $volume->getJumlahTersedia(),
            'harga_sewa' => $volume->getHargaSewa(),
        ], 'id');
    }

    /**
     * @throws Exception
     */
    public function find(int $id): ?Volume
    {
        $row = DB::table('volume')->where('id', $id)->first();

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
        $volume = [];
        foreach ($rows as $row) {
            $volume[] = new Volume(
                $row->id,
                $row->seri_id,
                $row->volume,
                $row->jumlah_tersedia,
                $row->harga_sewa,
            );
        }
        return $volume;
    }
}
