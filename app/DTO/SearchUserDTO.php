<?php

declare(strict_types=1);

namespace App\DTO;

class SearchUserDTO
{
    private ?array $ids = NULL;

    private ?string $name = NULL;

    private ?string $email = NULL;

    private ?array $roles = NULL;

    public function getIds(): ?array
    {
        return $this->ids;
    }

    public function setIds(?array $ids): self
    {
        $this->ids = empty($ids) ? NULL : $ids;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name ?: NULL;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email ?: NULL;

        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(?array $roles): self
    {
        $this->roles = empty($roles) ? NULL : $roles;

        return $this;
    }
}
