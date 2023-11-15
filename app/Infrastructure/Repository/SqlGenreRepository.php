<?php

namespace App\Infrastrucutre\Repository;

use App\Core\Domain\Models\Genre\Genre;
use Exception;
use Illuminate\Support\Facades\DB;

class SqlGenreRepository
{
    public function persist(Genre $genre): void
    {
        DB::table('genre')->upsert([
            'id' => $genre->getId(),
            'nama' => $genre->getNama(),
        ], 'id');
    }

    /**
     * @throws Exception
     */
    public function find(int $id): ?Genre
    {
        $row = DB::table('genre')->where('id', $id)->first();

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
        $genre = [];
        foreach ($rows as $row) {
            $genre[] = new Genre(
                $row->id,
                $row->nama,
            );
        }
        return $genre;
    }
}
