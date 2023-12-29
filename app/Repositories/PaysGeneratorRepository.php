<?php

namespace App\Repositories;

use App\Contracts\Service\PaysGeneratorContract;
use App\Models\Service\PaysGenerator;
use App\Repositories\Interfaces\PaysGeneratorRepositoryInterface;

class PaysGeneratorRepository implements PaysGeneratorRepositoryInterface
{
    public function get($month, $year)
    {
        return PaysGenerator::where(PaysGeneratorContract::FIELD_MONTH, $month)
            ->where(PaysGeneratorContract::FIELD_YEAR, $year)
            ->orderBy(PaysGeneratorContract::FIELD_ID, 'desc')
            ->first();
    }
}
