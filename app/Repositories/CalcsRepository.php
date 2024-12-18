<?php

namespace App\Repositories;

use App\Contracts\Salary\CalcsContract;
use App\Contracts\UserContract;
use App\Contracts\UserPersonalDataContract;
use App\Contracts\WorkShift\WorkShiftContract;
use App\Models\Salary\Calc;
use App\Models\WorkShift\WorkShift;
use App\Repositories\Interfaces\CalcsRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CalcsRepository implements CalcsRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Calc::all();
    }

    public function getByWorkshift(WorkShift $workShift, $withoutRelations = false) {
        $calcs = Calc::where(CalcsContract::FIELD_DATE, $workShift->{WorkShiftContract::FIELD_DATE})
            ->where(CalcsContract::FIELD_PLACE_ID, $workShift->{WorkShiftContract::FIELD_PLACE_ID})
            ->where(CalcsContract::FIELD_CITY_ID, $workShift->{WorkShiftContract::FIELD_CITY_ID});

        if (!$withoutRelations) {
            $calcs = $calcs->with(
                'calcType',
                'user',
                'user.personalData:'. UserContract::FIELD_ID . ',' . UserPersonalDataContract::FIELD_USER_ID . ',' . UserPersonalDataContract::FIELD_LAST_NAME . ',' .UserPersonalDataContract::FIELD_FIRST_NAME . ',' .UserPersonalDataContract::FIELD_MIDDLE_NAME,
            );
        }

        return $calcs->get();
    }

    public function find($id) {
        return Calc::find($id);
    }

    public function getByFilter($data): Collection {
        $year = $data['year'] ?? null;
        $month = $data['month'] ?? null;
        $city = $data['city_id'] ?? null;

        $query = new Calc;

        if ($year && !empty($year)) {
            $query = $query->whereYear(CalcsContract::FIELD_DATE, $year);
        }

        if ($month && !empty($month)) {
            $query = $query->whereMonth(CalcsContract::FIELD_DATE, $month);
        }

        if ($city) {
            $query = $query->where(CalcsContract::FIELD_CITY_ID, $city);
        }

        return $query->get();
    }

    public function getByUserID($userID, $filterData = [], $paginate = true)
    {
        $builder = Calc::where(CalcsContract::FIELD_USER_ID, $userID)
            ->filterData($filterData);

        $entriesBuilder = clone $builder;

        return [
            'ids' => $builder->select(CalcsContract::FIELD_TYPE_ID)->distinct()->get()->map(function ($item) {
                return $item->{ CalcsContract::FIELD_TYPE_ID };
            })->toArray(),
            'total' => $builder->sum(CalcsContract::FIELD_AMOUNT),
            'entries' => $paginate ? $entriesBuilder->orderBy(CalcsContract::FIELD_ID, 'desc')->paginate(40) : $entriesBuilder->get(),
        ];
    }
}
