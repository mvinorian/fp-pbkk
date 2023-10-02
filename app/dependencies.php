<?php

use App\Infrastrucutre\Repository\SqlUserRepository;
use App\Core\Domain\Repository\UserRepositoryInterface;

/** @var Application $app */

$app->singleton(UserRepositoryInterface::class, SqlUserRepository::class);
