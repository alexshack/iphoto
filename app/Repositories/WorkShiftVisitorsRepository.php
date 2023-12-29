<?php

namespace App\Repositories;

use App\Contracts\WorkShift\WorkShiftVisitorContract;
use App\Models\WorkShift\WorkShiftVisitor;
use App\Repositories\Interfaces\WorkShiftVisitorsRepositoryInterface;

class WorkShiftVisitorsRepository implements WorkShiftVisitorsRepositoryInterface
{
    public function find($id)
    {
        return WorkShiftVisitor::find($id);
    }

    public function getByWorkShiftID($id)
    {
        $builder = WorkShiftVisitor::where(WorkShiftVisitorContract::FIELD_WORK_SHIFT_ID, $id);
        $visitors = $builder->get();
        if ($visitors->count() === 0) {
            foreach (WorkShiftVisitorContract::TYPES as $typeID => $type) {
                $data = [
                    WorkShiftVisitorContract::FIELD_WORK_SHIFT_ID => $id,
                    WorkShiftVisitorContract::FIELD_TYPE => $typeID,
                ];
                WorkShiftVisitor::create($data);
            }
            $visitors = $builder->get();
        }
        return $visitors;
    }
}

