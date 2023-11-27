<?php

namespace App\Rules;

use App\Contracts\WorkShift\WorkShiftWithdrawalContract;
use App\Models\WorkShift\WorkShiftWithdrawal;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class WithdrawalValue implements ValidationRule
{
    private $attributes = [];

    public function __construct($attributes) {
        $this->attributes = $attributes;
    }

    private function getPreviousWithdrawal() {
        $currentTime = Carbon::parse($this->attributes[WorkShiftWithdrawalContract::FIELD_TIME]);
        $placeWorkStartTime = Carbon::parse('08:00:00');

        if ($currentTime->greaterThan($placeWorkStartTime)) {
            return WorkShiftWithdrawal::where(WorkShiftWithdrawalContract::FIELD_WORK_SHIFT_ID, $this->attributes[WorkShiftWithdrawalContract::FIELD_WORK_SHIFT_ID])
                ->where(WorkShiftWithdrawalContract::FIELD_TIME, '<', $this->attributes[WorkShiftWithdrawalContract::FIELD_TIME])
                ->where(WorkShiftWithdrawalContract::FIELD_TIME, '>', $placeWorkStartTime)
                ->orderBy(WorkShiftWithdrawalContract::FIELD_TIME, 'desc')
                ->first();
        } else {
            $firstPassAfterMidnight = WorkShiftWithdrawal::where(WorkShiftWithdrawalContract::FIELD_WORK_SHIFT_ID, $this->attributes[WorkShiftWithdrawalContract::FIELD_WORK_SHIFT_ID])
                ->where(function ($query) use ($placeWorkStartTime) {
                    $query->where(WorkShiftWithdrawalContract::FIELD_TIME, '<', $this->attributes[WorkShiftWithdrawalContract::FIELD_TIME])
                        ->where(WorkShiftWithdrawalContract::FIELD_TIME, '>', '00:00:00');
                })
                ->orderBy(WorkShiftWithdrawalContract::FIELD_TIME, 'desc')
                ->first();

            if (!$firstPassAfterMidnight) {
                return WorkShiftWithdrawal::where(WorkShiftWithdrawalContract::FIELD_WORK_SHIFT_ID, $this->attributes[WorkShiftWithdrawalContract::FIELD_WORK_SHIFT_ID])
                ->orderBy(WorkShiftWithdrawalContract::FIELD_TIME, 'desc')
                ->first();
            } else {
                return $firstPassAfterMidnight;
            }
        }
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $previous = $this->getPreviousWithdrawal();
        if ($previous && (int) $previous->{WorkShiftWithdrawalContract::FIELD_SUM} > $value) {
            $fail(__('validation.withdrawal_sum_incorrect', [
                'time' => $previous->{WorkShiftWithdrawalContract::FIELD_TIME},
            ]));
        }
    }
}
