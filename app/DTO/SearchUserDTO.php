<?php
declare(strict_types=1);
namespace App\DTO;

class SearchUserDTO
{
    private ?array $ids = null;
    private ?string $name = null;
    private ?string $email = null;
    private ?array $roles = null;

    public function getIds(): ?array
    {
        return $this->ids;
    }

    public function setIds(?array $ids): self
    {
        $this->ids = empty($ids) ? null : $ids;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name ?: null;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email ?: null;
        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(?array $roles): self
    {
        $this->roles = empty($roles) ? null : $roles;
        return $this;
    }
}
