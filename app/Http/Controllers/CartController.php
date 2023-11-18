<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Core\Application\Service\CreateCart\CreateCartRequest;
use App\Core\Application\Service\CreateCart\CreateCartService;
use App\Core\Application\Service\GetCartList\GetCartListRequest;
use App\Core\Application\Service\GetCartList\GetCartListService;
use App\Core\Application\Service\GetDetailCart\GetDetailCartService;

class CartController extends Controller
{
    public function createCart(Request $request, CreateCartService $service)
    {
        $request->validate([
            'volume_id' => 'required',
            'jumlah' => 'required'
        ]);

        $input = new CreateCartRequest(
            $request->input('volume_id'),
            $request->input('jumlah'),
        );

        DB::beginTransaction();
        try {
            $service->execute($input, Auth::user()->id);
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return redirect()->route('sign-in');
    }
}
