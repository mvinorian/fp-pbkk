<?php

namespace App\Core\Application\Service\GetUserList;

use Exception;
use App\Core\Domain\Repository\UserRepositoryInterface;

class GetUserListService
{
    private UserRepositoryInterface $user_repository;

    /**
     * @param UserRepositoryInterface $user_repository
     */
    public function __construct(UserRepositoryInterface $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    /**
     * @throws Exception
     */
    public function execute()
    {
        $list_user = $this->user_repository->getAll();

        $response = [];
        foreach ($list_user as $user) {
            $response[] = new GetUserListResponse($user);
        }

        return $response;
    }
}
