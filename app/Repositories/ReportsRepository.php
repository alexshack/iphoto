<?php

namespace App\Repositories;

use App\Contracts\Service\ReportContract;
use App\Models\Service\Report;
use App\Repositories\Interfaces\ReportsRepositoryInterface;

class ReportsRepository implements ReportsRepositoryInterface
{
    public function all()
    {
        $builder = Report::orderBy(ReportContract::FIELD_ID, 'desc');

        return $builder->get();
    }

    public function find($id)
    {
        return Report::find($id);
    }

    public function get($filterData = [], $paginate = 40)
    {
        return Report::filterData($filterData)
            ->orderBy(ReportContract::FIELD_ID, 'desc')
            ->paginate($paginate);
    }

}
