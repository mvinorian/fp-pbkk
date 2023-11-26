<?php

namespace App\Core\Application\Service\CreateCart;

use Exception;
use App\Core\Domain\Models\Email;
use App\Exceptions\UserException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Core\Domain\Models\User\User;
use App\Core\Domain\Models\User\UserType;
use App\Core\Application\ImageUpload\ImageUpload;
use App\Core\Application\Mail\AccountVerificationEmail;
use App\Core\Domain\Models\AccountVerification\AccountVerification;
use App\Core\Domain\Models\Cart\Cart;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Repository\AccountVerificationRepositoryInterface;
use App\Infrastructure\Repository\SqlCartRepository;
use App\Infrastructure\Repository\SqlUserRepository;
use App\Infrastructure\Repository\SqlVolumeRepository;

class CreateCartService
{
    private SqlCartRepository $cart_repository;
    private SqlVolumeRepository $volume_repository;

    public function __construct(SqlCartRepository $cart_repository, SqlVolumeRepository $volume_repository)
    {
        $this->cart_repository = $cart_repository;
        $this->volume_repository = $volume_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(CreateCartRequest $request, string $user_id)
    {
        $check_volume = $this->volume_repository->getVolumeById($request->getVolumeId());
        if (!$check_volume) {
            throw new Exception("Volume tidak ditemukan");
        }
        if ($check_volume->getJumlahTersedia() < $request->getJumlah()) {
            throw new Exception("Jumlah volume tidak mencukupi");
        }

        for ($i = 0; $i < $request->getJumlah(); $i++) {
            $input = Cart::create(
                new UserId($user_id),
                $request->getVolumeId()
            );
            $this->cart_repository->persist($input);
        }
    }
}
