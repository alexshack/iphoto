<?php

namespace App\Repositories\Interfaces;

interface PaysGeneratorRepositoryInterface
{
    public function get($month, $year);
}
