<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface CalcsRepositoryInterface
{
    public function getAll();
    public function getByFilter($data): Collection;
}
