<?php

namespace App\Repositories;

use App\Contracts\WorkShift\WorkShiftContract;
use App\Models\WorkShift\WorkShift;
use App\Repositories\Interfaces\WorkShiftRepositoryInterface;
use Carbon\Carbon;
use Auth;
use Illuminate\Database\Eloquent\Collection;

class WorkShiftRepository implements WorkShiftRepositoryInterface
{

    public function find($id) {
        return WorkShift::with('employees')
            ->where('id', $id)
            ->first();
    }
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return WorkShift::all();
    }

    public function getByFilter($data): Collection
    {
        $year = $data['year'] ?? null;
        $month = $data['month'] ?? null;
        $city = $data['city_id'] ?? null;

        $query = new WorkShift;

        if ($year && !empty($year)) {
            $query = $query->whereYear(WorkShiftContract::FIELD_DATE, $year);
        }

        if ($month && !empty($month)) {
            $query = $query->whereMonth(WorkShiftContract::FIELD_DATE, $month);
        }

        if ($city) {
            $query = $query->where(WorkShiftContract::FIELD_CITY_ID, $city);
        }

        return $query->get();
    }

    public function getNext(WorkShift $workshift) {
        return WorkShift::where(WorkShiftContract::FIELD_PLACE_ID, $workshift->{WorkShiftContract::FIELD_PLACE_ID
    })
        ->where(WorkShiftContract::FIELD_CITY_ID, $workshift->{WorkShiftContract::FIELD_CITY_ID})
        ->where(WorkShiftContract::FIELD_ID, '>', $workshift->{WorkShiftContract::FIELD_ID})
        ->first();
    }

    public function getToday($data): Collection
    {
        $city = $data['city_id'] ?? null;
        $query = new WorkShift;
        $query = $query->whereDate('created_at', Carbon::today());
        $user = Auth::user();
        $city = $user->getWorkData()->city_id;
        if ($city) {
            $query = $query->where(WorkShiftContract::FIELD_CITY_ID, $city);
        }
        return $query->get();   
        //return WorkShift::whereDate('created_at', Carbon::today())->get();
    }

    public function getYesterday($data): Collection
    {
        $city = $data['city_id'] ?? null;
        $query = new WorkShift;
        $query = $query->whereDate('created_at', Carbon::yesterday());
        $user = Auth::user();
        $city = $user->getWorkData()->city_id;        
        if ($city) {
            $query = $query->where(WorkShiftContract::FIELD_CITY_ID, $city);
        }
        return $query->get();         
        //return WorkShift::whereDate('created_at', Carbon::yesterday())->get();
    }
}
