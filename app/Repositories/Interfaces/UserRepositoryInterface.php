<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function getAll();

    public function getByRoleSlug(string $slug);

    public function getByCityAndRole(int $cityID, string $roleSlug);

    public function getMaleCountByRoleSlug(string $slug);

    public function getFemaleCountByRoleSlug(string $slug);

    public function getActiveManagers();
}
