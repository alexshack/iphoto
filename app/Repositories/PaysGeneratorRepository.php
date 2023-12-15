<?php

namespace App\Repositories;

use App\Contracts\Service\PaysGeneratorContract;
use App\Models\Service\PaysGenerator;
use App\Repositories\Interfaces\PaysGeneratorRepositoryInterface;

class PaysGeneratorRepository implements PaysGeneratorRepositoryInterface
{
    public function get($month, $year)
    {
        return PaysGenerator::where(PaysGenerator::FIELD_MONTH, $month)
            ->where(PaysGenerator::FIELD_YEAR, $year)
            ->orderBy(PaysGenerator::FIELD_ID, 'desc')
            ->first();
    }
}
