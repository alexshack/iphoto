<?php

namespace App\Http\Livewire\Service\Report\CustomData;

use App\Contracts\Service\ReportContract;
use App\Contracts\Structure\CityContract;
use App\Contracts\Structure\PlaceContract;
use App\Models\Service\Report;
use App\Repositories\Interfaces\CityRepositoryInterface;
use Auth;
use Livewire\Component;

class WorkShiftFields extends Component
{
    protected CityRepositoryInterface $cityRepository;

    public $companyStructure;
    public $customData = [];

    protected function buildCompanyStructure()
    {
        if ($this->companyStructure > 0) {
            return;
        }

        $cities = $this->cityRepository->getAvailable();
        foreach ($cities as $city) {
            $data = [
                'label' => $city->{CityContract::FIELD_NAME},
                'id' => $city->{ CityContract::FIELD_ID },
                'places' => [],
            ];

            $places = $city->places;
            if ($places->count() > 0) {
                foreach ($places as $place) {
                    $data['places'][] = [
                        'id' => $place->{ PlaceContract::FIELD_ID },
                        'label' => $place->{ PlaceContract::FIELD_NAME },
                    ];
                }
            }

            $this->companyStructure[] = $data;
        }
    }

    public function mount()
    {
        $this->customData = [
            'places' => [],
            'date_start' => null,
            'date_end' => null,
        ];
    }

    public function render(CityRepositoryInterface $cityRepository)
    {
        $this->cityRepository = $cityRepository;
        $this->buildCompanyStructure();
        return view('livewire.service.report.custom-data.work-shift-fields');
    }

    public function submit()
    {
        $data = [
            ReportContract::FIELD_CUSTOM_DATA => json_encode($this->customData),
            ReportContract::FIELD_USER_ID => Auth::user()->id,
            ReportContract::FIELD_TYPE => 'workshift',
        ];
        Report::create($data);

        return redirect()->route('reports.index')
            ->with([
                'message' => 'Данные для отчета заполнены. Отчет отправлен на генерацию. После генерации будет доступна ссылка на скачивание',
            ]);
    }
}
