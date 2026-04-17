<?php

declare(strict_types=1);

namespace Hatepopcorn\Domain\User;

use Hatepopcorn\Domain\ValueObjects\Datetime;
use Hatepopcorn\Domain\ValueObjects\Password;
use Hatepopcorn\Infrastructure\Utils\Assert;

class User implements \JsonSerializable
{
    use UserAttributes;

    private function __construct(
        string $name,
        string $email,
        Password $password,
        string $bio = '',
        ?UserId $id = null,
        ?Datetime $createdAt = null,
        ?Datetime $updatedAt = null,
        UserRole $role = UserRole::USER,
    ) {
        $this->changeBio($bio);
        $this->changeName($name);
        $this->changeEmail($email);
        $this->id        = $id;
        $this->role      = $role;
        $this->password  = $password;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public static function database(int $id, int $role, string $name, string $bio, string $email, string $password, string $createdAt, string $updatedAt): static
    {
        return new static($name, $email, Password::from($password), $bio,
            UserId::from($id),
            Datetime::from($createdAt),
            Datetime::from($updatedAt),
            UserRole->from($role),
        );
    }

    public static function aNew(string $name, string $email, string $password): static
    {
        return new static($name, $email, Password::encrypt($password));
    }

    public function markAsPersisted(int $id, string $createdAt, string $updatedAt): static
    {
        Assert::null($this->id, 'User id');

        $this->id        = UserId::from($id);
        $this->createdAt = Datetime::from($createdAt);
        $this->updatedAt = Datetime::from($updatedAt);

        return $this;
    }

    public function jsonSerialize(): array
    {
        $role = $this->role();

        return [
            'id'         => $this->id()->value,
            'name'       => $this->name()->value,
            'bio'        => $this->bio()->value,
            'role'       => ['id' => $role->value, 'name' => $role->label()],
            'created_at' => $this->createdAt()->format(),
            'updated_at' => $this->updatedAt()->format(),
        ];
    }
}
