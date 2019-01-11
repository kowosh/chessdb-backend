<?php declare(strict_types=1);

namespace App\Security;

use App\Validator\Contraints\UsernameUnique;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserRegistration
{
    /**
     * @NotBlank(message="user_registration.username.not_blank")
     * @Length(min="6", minMessage="user_registration.username.length")
     * @UsernameUnique(message="user_registration.username.unique")
     */
    private $username;

    /**
     * @NotBlank(message="user_registration.plain_password.not_blank")
     * @Length(min="6", minMessage="user_registration.plain_password.length")
     */
    private $password;

    /**
     * @NotBlank(message="user_registration.email.not_blank")
     * @Email(message="user_registration.email.invalid")
     */
    private $email;

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getSalt(): ?string
    {
        return null;
    }
}
