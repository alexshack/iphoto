<?php

namespace App\Observers\Money;

use App\Contracts\Money\MovesContract;
use App\Contracts\UserWorkDataContract;
use App\Contracts\Structure\PlaceContract;
use App\Models\Money\Move;
use Illuminate\Support\Facades\DB;

class MovesObserver
{
    protected $afterCommit = true;

    /**
     * Handle the Move "created" event.
     */
    public function created(Move $move): void
    {
        $amount = $move->{ MovesContract::FIELD_AMOUNT };
        $payer = null;
        $payerField = null;
        $recipient = null;
        $recipientField = null;

        if ($move->{ MovesContract::FIELD_PAYER_TYPE } === 'place') {
            $payer = $move->payerPlace;
            $payerField = PlaceContract::FIELD_CURRENT_BALANCE;
        } elseif ($move->{ MovesContract::FIELD_PAYER_TYPE } === 'manager') {
            $payer = $move->payerManager->workData;
            $payerField = UserWorkDataContract::FIELD_CURRENT_BALANCE;
        }

        if ($move->{ MovesContract::FIELD_RECIPIENT_TYPE } === 'place') {
            $recipient = $move->recipientPlace;
            $recipientField = PlaceContract::FIELD_CURRENT_BALANCE;
        } elseif ($move->{ MovesContract::FIELD_RECIPIENT_TYPE } === 'manager') {
            $recipient = $move->recipientManager->workData;
            $recipientField = UserWorkDataContract::FIELD_CURRENT_BALANCE;
        }

        DB::transaction(function () use ($amount, $payer, $payerField, $recipient, $recipientField) {
            $payer->{ $payerField } = $payer->{ $payerField } - $amount;
            $payer->save();

            $recipient->{ $recipientField } = $recipient->{ $recipientField } - $amount;
            $recipient->save();
        });
    }

    /**
     * Handle the Move "updated" event.
     */
    public function updated(Move $move): void
    {
        //
    }

    /**
     * Handle the Move "deleted" event.
     */
    public function deleted(Move $move): void
    {
        //
    }

    /**
     * Handle the Move "restored" event.
     */
    public function restored(Move $move): void
    {
        //
    }

    /**
     * Handle the Move "force deleted" event.
     */
    public function forceDeleted(Move $move): void
    {
        //
    }
}
