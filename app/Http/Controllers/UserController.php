<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Core\Application\Service\GetUserList\GetUserListService;
use App\Core\Application\Service\RegisterUser\RegisterUserRequest;
use App\Core\Application\Service\RegisterUser\RegisterUserService;

class UserController extends Controller
{
    public function createUser(Request $request, RegisterUserService $service): JsonResponse
    {
        $request->validate([
            'email' => 'email|email',
            'password' => 'min:8|max:64|string',
            'name' => 'min:8|max:128|string',
        ]);

        $input = new RegisterUserRequest(
            $request->input('email'),
            $request->input('name'),
            $request->input('no_telp'),
            $request->input('age'),
            $request->file('image'),
            $request->input('password')
        );

        DB::beginTransaction();
        try {
            $service->execute($input);
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $this->success("Berhasil Registrasi");
    }

    public function getUserList(GetUserListService $service): JsonResponse
    {
        $response = $service->execute();
        dd($response);
        return $this->successWithData($response, "Berhasil Mendapatkan List User");
    }
}
