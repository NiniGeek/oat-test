<?php

namespace App\TestTaker\Domain\User\Entity;

use App\TestTaker\Infrastructure\DataProvider\Contract\SearchableInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Ramsey\Uuid\Uuid;

/**
 * Class User
 * @package App\TestTaker\Domain\User\Entity
 */
class User implements SearchableInterface
{
    /**
     * @var int
     * @Groups({"list", "user"})
     * @Assert\NotBlank
     */
    protected $id;

    /**
     * @var string
     * @Groups({"user"})
     * @Assert\NotBlank
     */
    protected $login;

    /**
     * @var string
     * @Groups({"user"})
     * @Assert\NotBlank
     */
    protected $password;

    /**
     * @var string
     * @Groups({"user"})
     * @Assert\NotBlank
     */
    protected $title;

    /**
     * @var string
     * @Groups({"list", "user"})
     * @Assert\NotBlank
     */
    protected $lastname;

    /**
     * @var string
     * @Groups({"list", "user"})
     * @Assert\NotBlank
     */
    protected $firstname;

    /**
     * @var string
     * @Groups({"user"})
     * @Assert\NotBlank
     */
    protected $gender;

    /**
     * @var string
     * @Groups({"user"})
     * @Assert\NotBlank
     */
    protected $email;

    /**
     * @var string
     * @Groups({"user"})
     * @Assert\NotBlank
     */
    protected $picture;

    /**
     * @var string
     * @Groups({"user"})
     * @Assert\NotBlank
     */
    protected $address;

    /**
     * @return string
     */
    public function getId(): string
    {
        if ($this->id === null) {
            var_dump($this); die();
        }
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     * @return self
     */
    public function setLogin(string $login): self
    {
        $this->id = Uuid::getFactory()->uuid5(Uuid::NAMESPACE_DNS, $login)->toString();
        $this->login = $login;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return self
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return self
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     * @return self
     */
    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     * @return self
     */
    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     * @return self
     */
    public function setGender(string $gender): self
    {
        $this->gender = $gender;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return self
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPicture(): string
    {
        return $this->picture;
    }

    /**
     * @param string $picture
     * @return self
     */
    public function setPicture(string $picture): self
    {
        $this->picture = $picture;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     * @return self
     */
    public function setAddress(string $address): self
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @param string $data
     * @return bool
     */
    public function hasData(string $data): bool
    {
        return mb_stripos($data, $this->getFirstname()) !== false
            || mb_stripos($data, $this->getLastname()) !== false
            || mb_stripos($data, $this->getLogin()) !== false
            || mb_stripos($data, $this->getEmail()) !== false
            || mb_stripos($data, $this->getAddress()) !== false;
    }

    /**
     * @param string $id
     * @return bool
     */
    public function hasId(string $id): bool
    {
        return $this->getId() === $id;
    }
}