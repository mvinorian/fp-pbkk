<?php

namespace App\Http\Controllers;

use App\Core\Application\Service\GetDetailSeri\GetDetailSeriService;
use Illuminate\Http\Request;
use App\Core\Application\Service\GetSeriList\GetSeriListRequest;
use App\Core\Application\Service\GetSeriList\GetSeriListService;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SeriController extends Controller
{
    public function getSeriList(Request $request, GetSeriListService $service)
    {
        $request->validate([
            'per_page' => 'numeric',
            'page' => 'numeric',
            'filter' => ['sometimes', function ($attr, $val, $fail) {
                if (!is_array($val)) {
                    $fail($attr . ' must be an array of numbers');
                }
                if (is_array($val)) {
                    foreach ($val as $number) {
                        if (!is_numeric($number)) {
                            $fail($attr . ' must be an array of numbers');
                        }
                    }
                }
            }],
            'search' => 'string',
        ]);

        $req = new GetSeriListRequest(
            $request->input('per_page') ?? 12,
            $request->input('page') ?? 1,
            $request->input('filter'),
            $request->input('search')
        );
        $response = $service->execute($req);

        return Inertia::render('seri/index', $this->successWithDataProps($response, 'Berhasil mendapatkan list seri'));
    }

    public function getDetailSeri(Request $request, GetDetailSeriService $service)
    {
        $response = $service->execute($request->route('id'));

        return Inertia::render('seri/detail', $this->successWithDataProps($response, 'Berhasil mendapatkan detail seri'));
    }
}
