<?php

namespace App\TestTaker\Infrastructure\User;


use App\TestTaker\App\Support\AppEntityRepository;
use App\TestTaker\Domain\User\Contract\UserRepositoryInterface;
use App\TestTaker\Domain\User\Entity\User;
use App\TestTaker\Infrastructure\DataProvider\Contract\DataProviderInterface;

/**
 * Class UserRepository
 * @package App\TestTaker\Infrastructure\User
 */
class UserRepository extends AppEntityRepository implements UserRepositoryInterface
{
    /**
     * @param string|null $limit
     * @param string|null $offset
     * @param string|null $filter
     * @return User[]
     */
    public function findUserList(?string $limit = null, ?string $offset = null, ?string $filter = null): array
    {
        return $this->dataProvider
            ->setLimit($limit)
            ->setOffset($offset)
            ->setFilter($filter)
            ->query(User::class);
    }

    /**
     * @param string $id
     * @return User|null
     */
    public function findUserById(string $id): ?User
    {
        return $this->dataProvider->find(User::class, $id);
    }
}