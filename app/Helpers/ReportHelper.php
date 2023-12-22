<?php

namespace App\Helpers;

use App\Contracts\Service\ReportContract;
use App\Models\Service\Report;

class ReportHelper
{
    public static function generateReport(Report $report)
    {
        $aliases = config('reports.aliases');
        if (isset($aliases[$report->{ ReportContract::FIELD_TYPE }])) {
            $className = $aliases[$report->{ ReportContract::FIELD_TYPE }];
            app($className)->generate($report);
        }
    }
}
