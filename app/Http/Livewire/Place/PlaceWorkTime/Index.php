<?php

namespace App\Http\Livewire\Place\PlaceWorkTime;

use App\Contracts\Structure\PlaceContract;
use App\Contracts\Structure\PlaceWorkTimeContract;
use App\Models\Structure\Place;
use App\Models\Structure\PlaceWorkTime;
use Livewire\Component;

class Index extends Component
{
    public Place $place;

    public $workTimes = [];

    public function render()
    {
        $this->workTimes = $this->place->place_work_times;
        return view('livewire.place.place-work-time.index');
    }

    public function submit() {
        foreach ($this->workTimes as $key => $workTimeData) {
            $id = $workTimeData[PlaceWorkTimeContract::FIELD_ID];
            $workTime = PlaceWorkTime::find($id);
            if ($workTime) {
                $workTime->{PlaceWorkTimeContract::FIELD_START_TIME} = $workTimeData[PlaceWorkTimeContract::FIELD_START_TIME];
                $workTime->{PlaceWorkTimeContract::FIELD_END_TIME} = $workTimeData[PlaceWorkTimeContract::FIELD_END_TIME];
                $workTime->save();
            }
        }
        $this->emit('$refresh');
    }
}
