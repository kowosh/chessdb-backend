<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\CustomIdGenerator;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields="email", message="user.email.unique")
 * @UniqueEntity(fields="username", message="user.username.unique")
 */
class User implements UserInterface
{
    /**
     * @Id()
     * @Column(type="uuid", unique=true)
     * @GeneratedValue(strategy="CUSTOM")
     * @CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $id;

    /**
     * @Column(type="string", unique=true)
     * @NotBlank(message="user.username.not_blank")
     */
    private $username;

    /**
     * @Column()
     * @NotBlank(message="user.password.not_blank")
     */
    private $password;

    /**
     * @Column(type="string", unique=true)
     * @NotBlank(message="user.email.not_blank")
     * @Email(message="user.email.invalid")
     */
    private $email;

    /**
     * @Column(type="simple_array")
     */
    private $roles;

    public function __construct(
        string $username,
        string $email,
        string $password,
        array $roles = []
    ) {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->roles = array_merge($roles, ['ROLE_USER']);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {
    }
}
