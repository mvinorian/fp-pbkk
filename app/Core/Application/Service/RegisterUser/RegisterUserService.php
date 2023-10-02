<?php

namespace App\Core\Application\Service\RegisterUser;

use Exception;
use App\Core\Domain\Models\Email;
use App\Exceptions\UserException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Core\Domain\Models\User\User;
use App\Core\Domain\Models\User\UserType;
use App\Core\Application\ImageUpload\ImageUpload;
use App\Core\Application\Mail\AccountVerificationEmail;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Core\Domain\Models\AccountVerification\AccountVerification;
use App\Core\Domain\Repository\AccountVerificationRepositoryInterface;

class RegisterUserService
{
    private UserRepositoryInterface $user_repository;

    /**
     * @param UserRepositoryInterface $user_repository
     * @param AccountVerificationRepositoryInterface $account_verification_repository
     */
    public function __construct(UserRepositoryInterface $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(RegisterUserRequest $request)
    {
        // $registeredUser = $this->user_repository->findByEmail(new Email($request->getEmail()));
        // if ($registeredUser) {
        //     UserException::throw("Mohon Periksa Email Anda Untuk Proses Verifikasi Akun", 1022, 404);
        // }

        $image_url = ImageUpload::create(
            $request->getImage(),
            'Company/Image',
            $request->getEmail(),
            'Image'
        )->upload();

        $user = User::create(
            $request->getName(),
            new Email($request->getEmail()),
            $request->getNoTelp(),
            UserType::USER,
            $request->getAge(),
            $image_url,
            $request->getPassword()
        );
        $this->user_repository->persist($user);
    }
}
