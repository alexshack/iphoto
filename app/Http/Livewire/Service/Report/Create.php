<?php

namespace App\Http\Livewire\Service\Report;

use App\Contracts\Service\ReportContract;
use Livewire\Component;

class Create extends Component
{
    public $reportType;

    public $types = [];

    public function render()
    {
        $this->types = ReportContract::TYPES;
        return view('livewire.service.report.create');
    }
}
