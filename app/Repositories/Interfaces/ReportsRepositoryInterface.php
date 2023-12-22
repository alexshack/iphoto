<?php

namespace App\Repositories\Interfaces;

interface ReportsRepositoryInterface
{
    public function all();

    public function find($id);
}
