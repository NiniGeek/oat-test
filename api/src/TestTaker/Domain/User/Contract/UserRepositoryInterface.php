<?php

namespace App\TestTaker\Domain\User\Contract;


use App\TestTaker\Domain\User\Entity\User;

/**
 * Interface UserRepositoryInterface
 * @package App\TestTaker\Domain\User\Contract
 */
interface UserRepositoryInterface
{
    /**
     * @param string|null $limit
     * @param string|null $offset
     * @param string|null $filter
     * @return User[]
     */
    public function findUserList(?string $limit = null, ?string $offset = null, ?string $filter = null): array;

    /**
     * @param string $id
     * @return User|null
     */
    public function findUserById(string $id): ?User;
}