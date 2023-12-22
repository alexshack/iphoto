<?php

namespace App\Http\Controllers\Service\Reports;

use App\Contracts\Money\SalesTypeContract;
use App\Contracts\Service\ReportContract;
use App\Contracts\Structure\CityContract;
use App\Contracts\Structure\PlaceContract;
use App\Contracts\WorkShift\WorkShiftContract;
use App\Helpers\WorkShiftHelper;
use App\Http\Controllers\Controller;
use App\Models\Service\Report;
use App\Repositories\Interfaces\PlaceRepositoryInterface;
use App\Repositories\Interfaces\SalesTypeRepositoryInterface;
use App\Repositories\Interfaces\WorkShiftRepositoryInterface;
use Carbon\Carbon;
use DatePeriod;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class WorkShiftReportController extends Controller
{

    protected $places = [];
    protected $placeTotalColumns = 0;
    protected $salesTypes;
    protected $spreadsheetAgendaOffset = 0;

    protected PlaceRepositoryInterface $placeRepository;
    protected SalesTypeRepositoryInterface $salesTypeRepository;
    protected WorkShiftRepositoryInterface $workShiftRepository;

    public function __construct(PlaceRepositoryInterface $placeRepository,
        SalesTypeRepositoryInterface $salesTypeRepository,
        WorkShiftRepositoryInterface $workShiftRepository)
    {
        $this->placeRepository = $placeRepository;
        $this->salesTypeRepository = $salesTypeRepository;
        $this->workShiftRepository = $workShiftRepository;
    }

    public function generate(Report $report)
    {
        $this->salesTypes = $this->salesTypeRepository->getActive();
        $reportData = $report->{ ReportContract::FIELD_CUSTOM_DATA };
        if (!is_array($reportData)) {
            $reportData = json_decode($reportData, true);
        }

        if (!isset($reportData['places']) || empty($reportData['places'])) {
            return;
        }

        $placesIds = [];
        foreach ($reportData['places'] as $placeID => $useInReport) {
            if ($useInReport) {
                $placeIds[] = $placeID;
            }
        }

        $salesTypesLabels = [];
        $cities = [];

        $placesEntities = $this->placeRepository->getByIds($placeIds);
        foreach ($placesEntities as $place) {
            $this->places[$place->{ PlaceContract::FIELD_ID }] = [
                'label' => $place->{ PlaceContract::FIELD_NAME },
                'city_label' => $place->city->{ CityContract::FIELD_NAME },
                'salesTypesTotals' => [],
                'total' => 0,
            ];
        }

        foreach ($this->salesTypes as $saleType) {
            $salesTypesLabels[$saleType->{ SalesTypeContract::FIELD_ID }] = $saleType->{ SalesTypeContract::FIELD_NAME };
            foreach ($this->places as $placeKey => $place) {
                $this->places[$placeKey]['salesTypesTotals'][$saleType->{ SalesTypeContract::FIELD_ID }] = 0;
            }
        }

        $endPeriod = null;
        if ($reportData['date_end']) {
            $endPeriod = new DateTime($reportData['date_end']);
        } else {
            $endPeriod = new DateTime();
        }

        $periodData = [];

        $periodDataTitle = [];
        $periodDataTitleBaseHeading = [
            'Дата',
            "День\nнедели",
            'Город',
            'Точка',
        ];
        foreach ($salesTypesLabels as $label) {
            $periodDataTitleBaseHeading[] = $label;
        }
        $periodDataTitleBaseHeading[] = 'Итого';
        $periodDataTitleBaseHeading[] = 'Средний чек';
        $periodDataTitleBaseHeading[] = 'Проходка';
        for ($i = 0; $i < count($this->places); $i ++) {
            $periodDataTitle = array_merge($periodDataTitle, $periodDataTitleBaseHeading);
        }
        $periodData[] = $periodDataTitle;

        $period = new DatePeriod(
            new DateTime($reportData['date_start']),
            new DateInterval('P1D'),
            $endPeriod
        );

        $emptyStringsArray = [];
        $baseEmptyStringsCount = 7;
        $baseEmptyStringsCount += $this->salesTypes->count();
        $this->placeTotalColumns = $baseEmptyStringsCount;
        for ($i = 0; $i < $baseEmptyStringsCount; $i++) {
            $emptyStringsArray[] = '';
        }

        foreach ($period as $periodKey => $periodValue) {
            $pushData = false;

            $periodDataItem = [];
            $date = $periodValue->format('Y-m-d');
            $carbonTime = new Carbon($periodValue);
            $dayName = $carbonTime->locale('ru')->dayName;

            foreach ($reportData['places'] as $placeID => $useInReport) {
                if (!$useInReport) {
                    continue;
                }

                $workShift = $this->workShiftRepository->getByDateAndPlace($date, $placeID);

                if (!$workShift) {
                    $periodDataItem = array_merge($periodDataItem, $emptyStringsArray);
                    continue;
                } else {
                    $pushData = true;
                }

                $periodItem = [
                    $date,
                    $dayName,
                    $this->places[$placeID]['city_label'],
                    $this->places[$placeID]['label'],
                ];

                $stats = WorkShiftHelper::recalculateStats($workShift);

                $workShiftTotal = 0;
                foreach ($this->salesTypes as $saleType) {
                    $saleTypeAmount = 0;
                    $workShiftTotalSales = 0;
                    if (isset($stats['agenda']['cashBox']['children'][$saleType->{ SalesTypeContract::FIELD_ID }])) {
                        $saleTypeAmount = $stats['agenda']['cashBox']['children'][$saleType->{ SalesTypeContract::FIELD_ID }]['amount'];
                    }
                    $periodItem[] = $saleTypeAmount;
                    $this->places[$placeKey]['salesTypesTotals'][$saleType->{ SalesTypeContract::FIELD_ID }] += $saleTypeAmount;
                    $workShiftTotal += $saleTypeAmount;
                }
                $periodItem[] = $workShiftTotal;
                $periodItem[] = $workShift->{ WorkShiftContract::FIELD_CHECK_AVERAGE };
                $periodItem[] = $workShift->{ WorkShiftContract::FIELD_VISITORS_TOTAL };
                $periodDataItem = array_merge($periodDataItem, $periodItem);
            }

            if ($pushData) {
                $periodData[] = $periodDataItem;
            }
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $agendaData = [
            ['', ''],
        ];
        foreach($salesTypesLabels as $label) {
            $agendaData[0][] = $label;
        }
        $agendaData[0][] = "Итого \n сумма";

        foreach ($this->places as $place) {
            $placeTotal = 0;
            $placeData = [
                $place['city_label'],
                $place['label'],
            ];

            foreach ($place['salesTypesTotals'] as $saleTypeTotal) {
                $placeData[] = $saleTypeTotal;
                $placeTotal += $saleTypeTotal;
            }

            $placeData[] = $placeTotal;
            $agendaData[] = $placeData;
        }

        $spreadsheet->getActiveSheet()
            ->fromArray(
                $agendaData,
                null,
                'B3'
            );

        $baseSpreadsheetAgendaOffset = 6;
        $this->spreadsheetAgendaOffset = $baseSpreadsheetAgendaOffset + count($this->places);

        $spreadsheet->getActiveSheet()
            ->fromArray([['С','По',],
                [$reportData['date_start'],$endPeriod->format('Y-m-d')]
            ],
            null,
            'A1'
        );

        $spreadsheet->getActiveSheet()
            ->fromArray(
                $periodData,
                null,
                "A{$this->spreadsheetAgendaOffset}"
            );

        $spreadsheet->getProperties()
            ->setCreator($report->user->name)
            ->setTitle($report->title);

        $sheet = $spreadsheet->getActiveSheet();
        $cellIterator = $sheet->getRowIterator()->current()->getCellIterator();

        foreach ($cellIterator as $cell) {
            $sheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
        }

        $this->setSheetStyles($spreadsheet);

        $writer = new Xlsx($spreadsheet);
        $writer->save($this->getReportFilePath($report->fileName));

        $report->{ ReportContract::FIELD_COMPLETED_AT } = Carbon::now();
        $report->save();
    }

    protected function getReportFilePath($slug)
    {
        $dir = storage_path() . '/app/public/report-files';
        if (!file_exists($dir)) {
            mkdir($dir);
        }
        $fileName = "$dir/$slug";
        return $fileName;
    }

    protected function setSheetStyles(&$spreadsheet)
    {
        $cityStyle = [
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'CCFFCC',
                ],
            ],
        ];

        $dateStyle = [
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => "00ECEC",
                ],
            ],
        ];

        $saleTypeStyle = [
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'feff00',
                ],
            ],
        ];

        $totalsStyle = [
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'CC99FF',
                ],
            ],
        ];

        $indexes = [
            0 => 'dateStyle',
            1 => 'dateStyle',
            2 => 'cityStyle',
            3 => 'cityStyle',
        ];

        foreach ($this->salesTypes as $saleType) {
            $indexes[] = 'saleTypeStyle';
        }
        $indexes[] = 'saleTypeStyle';

        $indexes[] = 'totalsStyle';
        $indexes[] = 'totalsStyle';

        $currentIndex = 0;
        $indexesCount = count($indexes);
        $highestColumn = $spreadsheet->getActiveSheet()->getHighestColumn();
        $worksheet = $spreadsheet->getActiveSheet();
        $highestColumnIndex = Coordinate::columnIndexFromString($highestColumn);
        for ($i = 1; $i <= $highestColumnIndex; $i++) {
            $columnString = Coordinate::stringFromColumnIndex($i);
            $cellIndex = "{$columnString}{$this->spreadsheetAgendaOffset}";
            $cellStyle = $indexes[$currentIndex];
            if (isset($$cellStyle)) {
                $worksheet->getStyle($cellIndex)
                    ->applyFromArray($$cellStyle);
            }

            $currentIndex = $currentIndex + 1;
            if ($currentIndex >= $indexesCount) {
                $currentIndex = 0;
            }
        }

        $saleTypesStartIndex = Coordinate::columnIndexFromString('D');
        for ($i = 0; $i < $this->salesTypes->count() + 1; $i++) {
            $saleTypeIndex = $saleTypesStartIndex + $i;
            $columnString = Coordinate::stringFromColumnIndex($saleTypeIndex);
            $cellIndex = "{$columnString}3";
            $worksheet->getStyle($cellIndex)
                ->applyFromArray($saleTypeStyle);
        }

        $placesStartRow = 4;
        for ($i = 0; $i < count($this->places); $i++) {
            $placeRow = $placesStartRow + $i;
            $placeColumns = ['B', 'C'];
            foreach ($placeColumns as $column) {
                $cellIndex = "{$column}{$placeRow}";
                $worksheet->getStyle($cellIndex)
                    ->applyFromArray($cityStyle);
            }
        }
    }
}
