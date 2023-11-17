<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Core\Application\Service\GetUserList\GetUserListService;
use App\Core\Application\Service\RegisterUser\RegisterUserRequest;
use App\Core\Application\Service\RegisterUser\RegisterUserService;

class UserController extends Controller
{
    public function test(): JsonResponse
    {
        return response()->json(
            [
                'success' => true,
                'message' => "Test",
            ]
        );
    }

    public function storeUser(Request $request, RegisterUserService $service)
    {
        $request->validate([
            'email' => 'email:rfc',
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
        return redirect()->route('login');
    }

    public function storeLogin(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $userdata = [
            'email'     => $request->email,
            'password'  => $request->password
        ];

        if (Auth::attempt($userdata)) {
            // Alert::success('Berhasil Login');
            return redirect()->intended('/');
        } else {
            // Alert::error('Email atau Password Salah');
            return redirect('login');
        }
    }

    public function destroyLogin(): RedirectResponse
    {
        Auth::logout();
        return redirect('/');
    }

    public function getUserList(GetUserListService $service)
    {
        $response = $service->execute();
        return view('users', ['users' => $response]);
    }

    public function getUserListApi(GetUserListService $service)
    {
        $response = $service->execute();
        return $this->successWithData($response, "Berhasil mendapatkan data");
    }
}
