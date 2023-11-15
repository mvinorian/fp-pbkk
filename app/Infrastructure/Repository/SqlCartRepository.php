<?php

namespace App\Infrastructure\Repository;

use App\Core\Domain\Models\Cart\Cart;
use App\Core\Domain\Models\Cart\CartId;
use App\Core\Domain\Models\User\UserId;
use Exception;
use Illuminate\Support\Facades\DB;

class SqlCartRepository
{
    public function persist(Cart $cart): void
    {
        DB::table('cart')->upsert([
            'id' => $cart->getId()->toString(),
            'user_id' => $cart->getUserId()->toString(),
            'volume_id' => $cart->getVolumeId(),
        ], 'id');
    }

    /**
     * @throws Exception
     */
    public function find(CartId $id): ?Cart
    {
        $row = DB::table('cart')->where('id', $id->toString())->first();

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
        $cart = [];
        foreach ($rows as $row) {
            $cart[] = new Cart(
                new CartId($row->id),
                new UserId($row->user_id),
                $row->volume_id,
            );
        }
        return $cart;
    }
}
