<?php

namespace App\Rules;

use App\Contracts\WorkShift\WorkShiftWithdrawalContract;
use App\Models\WorkShift\WorkShiftWithdrawal;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class WithdrawalValue implements ValidationRule
{
    private $attributes = [];

    public function __construct($attributes) {
        $this->attributes = $attributes;
    }

    private function getPreviousWithdrawal() {
        return WorkShiftWithdrawal::where(WorkShiftWithdrawalContract::FIELD_WORK_SHIFT_ID, $this->attributes[WorkShiftWithdrawalContract::FIELD_WORK_SHIFT_ID])
            ->where(WorkShiftWithdrawalContract::FIELD_TIME, '<', $this->attributes[WorkShiftWithdrawalContract::FIELD_TIME])
            ->orderBy(WorkShiftWithdrawalContract::FIELD_TIME, 'desc')
            ->first();
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $previous = $this->getPreviousWithdrawal();
        \Log::info(serialize([
            'prev' => $previous->{WorkShiftWithdrawalContract::FIELD_SUM},
            'prevID' => $previous->{WorkShiftWithdrawalContract::FIELD_ID},
            'value' => $value,
        ]));
        if ($previous && $previous->{WorkShiftWithdrawalContract::FIELD_SUM} > $value) {
            $fail(__('validation.withdrawal_sum_incorrect', [
                'time' => $previous->{WorkShiftWithdrawalContract::FIELD_TIME},
            ]));
        }

    }
}
