<?php

namespace App\Http\Controllers\Service;

use App\Contracts\Salary\PaysContract;
use App\Contracts\SettingContract;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\PaysRepositoryInterface;
use App\Repositories\Interfaces\SettingsRepositoryInterface;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelGeneratorController extends Controller
{
    protected PaysRepositoryInterface $paysRepository;
    protected SettingsRepositoryInterface $settingRepository;

    public function __construct(
        PaysRepositoryInterface $paysRepository,
        SettingsRepositoryInterface $settingRepository,
    )
    {
        $this->paysRepository = $paysRepository;
        $this->settingRepository = $settingRepository;
    }

    public function generatePaysLists($month, $year)
    {
        $payOptions = [
            'salary_10',
            'salary_25',
        ];

        $filterData = [
            'billing_month' => $month,
            'billing_year' => $year,
        ];

        $billingMonth = "{$year}-{$month}-01";

        foreach ($payOptions as $option) {
            $settingOption = $this->settingRepository->get($option);
            $optionValue = $settingOption && $settingOption->{SettingContract::FIELD_VALUE} ? $settingOption->{SettingContract::FIELD_VALUE} : null;

            $salaryPays = $this->paysRepository->getForLists(array_merge($filterData, ['calcType' => $optionValue]));
            $items = [];
            foreach ($salaryPays as $payItem) {
                $item = [
                    $payItem->user->name,
                    $payItem->{PaysContract::FIELD_AMOUNT},
                ];
                $items[] = $item;
            }
            //$fileName = "excel-files/{$year}/{$month}/$optionValue.xlsx";
            $fileName = $this->getSalaryPaysFilePath($year, $month, $option);
            $this->generateExcel($items, $fileName);
        }
    }

    protected function generateExcel($items, $fileName)
    {
        $header = [
            ['Сотрудник', 'Сумма'],
        ];

        $data = array_merge($header, $items);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray($data);

        $writer = new Xlsx($spreadsheet);
        $writer->save($fileName);
    }

    protected function getSalaryPaysFilePath($year, $month, $slug)
    {
        $dir = storage_path() . '/app/public/salary-excel-files';
        if (!file_exists($dir)) {
            mkdir($dir);
        }

        $dir = "{$dir}/$year";
        if (!file_exists($dir)) {
            mkdir($dir);
        }

        $dir = "{$dir}/$month";
        if (!file_exists($dir)) {
            mkdir($dir);
        }

        $fileName = "$dir/$slug.xlsx";
        return $fileName;
    }
}
