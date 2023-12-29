<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface PaysRepositoryInterface
{
    public function getAll();
    public function getByFilter($data, $paginate = false): Collection | LengthAwarePaginator;
}
