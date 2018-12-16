<?php

namespace App\TestTaker\Domain\User;


use App\TestTaker\Domain\User\Contract\UserRepositoryInterface;
use App\TestTaker\Domain\User\Entity\User;

/**
 * Class UserService
 * @package App\TestTaker\Domain\User
 */
class UserService
{
    /** @var UserRepositoryInterface */
    protected $userRepository;

    /**
     * UserService constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param string|null $limit
     * @param string|null $offset
     * @param string|null $filter
     * @return array
     */
    public function getUserList(?string $limit = null, ?string $offset = null, ?string $filter = null): array
    {
        return $this->userRepository->findUserList($limit, $offset, $filter);
    }

    /**
     * @param string $id
     * @return User
     */
    public function getUser(string $id): User
    {
        return $this->userRepository->findUserById($id);
    }
}