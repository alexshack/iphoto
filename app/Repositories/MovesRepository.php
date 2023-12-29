<?php

namespace App\Repositories;

use App\Contracts\Money\MovesContract;
use App\Contracts\WorkShift\WorkShiftContract;
use App\Contracts\UserContract;
use App\Contracts\UserPersonalDataContract;
use App\Models\Money\Move;
use App\Models\WorkShift\WorkShift;
use App\Models\WorkShift\WorkShiftGood;
use App\Repositories\Interfaces\MovesRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class MovesRepository implements MovesRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Move::all();
    }

    public function getByFilter($data): Collection {
        return Move::whereYear(MovesContract::FIELD_DATE, $data['year'])
            ->whereMonth(MovesContract::FIELD_DATE, $data['month'])
            ->get();
    }

    public function getByWorkshift(WorkShift $workShift, $from = 'place') {
        $fieldFrom = null;
        if ($from === 'place') {
            $fieldFrom = $workShift->{WorkShiftContract::FIELD_PLACE_ID};
        }
        $moves = Move::whereDate(MovesContract::FIELD_DATE, $workShift->{WorkShiftContract::FIELD_DATE})
            ->where(MovesContract::FIELD_PAYER_TYPE, $from)
            ->where(MovesContract::FIELD_PAYER_ID, $fieldFrom)
            ->where(MovesContract::FIELD_CITY_ID, $workShift->{WorkShiftContract::FIELD_CITY_ID})
            ->with(
                'payerManager',
                'payerPlace',
                'recipientManager',
                'recipientManager.personalData:'. UserContract::FIELD_ID . ',' . UserPersonalDataContract::FIELD_USER_ID . ',' . UserPersonalDataContract::FIELD_LAST_NAME . ',' .UserPersonalDataContract::FIELD_FIRST_NAME . ',' .UserPersonalDataContract::FIELD_MIDDLE_NAME,
                'recipientPlace'
            )
            ->get();
        $moves = $moves->map(function ($move) {
            if ($move->{MovesContract::FIELD_PAYER_TYPE} === 'manager') {
                unset($move->payerPlace);
            } else {
                unset($move->payerManager);
            }

            if ($move->{MovesContract::FIELD_RECIPIENT_TYPE} === 'manager') {
                unset($move->recipientPlace);
            } else {
                unset($move->recipientManager);
            }

            return $move;
        });

        return $moves;
    }

    public function find($id) {
        return Move::find($id);
    }
}
