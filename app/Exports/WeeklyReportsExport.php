<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class WeeklyReportsExport implements FromCollection, ShouldAutoSize, WithHeadings, WithStyles
{
    protected $reportData;
    protected $employeeName;

    public function __construct($reportData, $employeeName)
    {
        $this->reportData = $reportData;
        $this->employeeName = $employeeName;
    }

    public function collection()
    {
        $data = [];
        $weekColumns = [
            'Week',
            'Employee Name',
            'Location',
            'Customer',
            __('Monday'),
            __('Tuesday'),
            __('Wednesday'),
            __('Thursday'),
            __('Friday'),
            __('Saturday'),
            __('Sunday'),
            'Totaaluren'
        ];

        // Iterate through each week's data
        foreach ($this->reportData as $weekNumber => $weekData) {
            $weekTotalHours = 0; // Initialize total hours for the entire week

            // Group data by location
            $locations = collect($weekData)->groupBy('location');

            foreach ($locations as $location => $locationData) {
                $totalHours = 0; // Initialize total hours for the location
                $weekRow = array_fill_keys($weekColumns, ''); // Template for each location's row

                // Extract customer and employee name from the first entry for the location
                $customer = $locationData[0]['customer'];
                $employeeName = $locationData[0]['employee_name'];

                $weekRow['Week'] = "Week $weekNumber";
                $weekRow['Employee Name'] = $employeeName;
                $weekRow['Location'] = $location;
                $weekRow['Customer'] = $customer;

                // Fill in hours for each day of the week
                foreach ($locationData as $dayData) {
                    $day = $dayData['day'];
                    $hours = $dayData['hours'];
                    $weekRow[__($day)] = $hours;
                    $totalHours += $hours;
                }

                // Add total hours to the row
                $weekRow['Totaaluren'] = $totalHours;
                $data[] = $weekRow;
                $weekTotalHours += $totalHours; // Add location's total hours to the week's total
            }

            // Add a row for the total hours of the week
            $data[] = [
                'Week' => "Totaaluren voor for Week $weekNumber",
                'Employee Name' => '',
                'Location' => '',
                'Customer' => '',
                __('Monday') => '',
                __('Tuesday') => '',
                __('Wednesday') => '',
                __('Thursday') => '',
                __('Friday') => '',
                __('Saturday') => '',
                __('Sunday') => '',
                'Totaaluren' => $weekTotalHours
            ];
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Week',
            'Employee Name',
            'Location',
            'Customer',
            __('Monday'),
            __('Tuesday'),
            __('Wednesday'),
            __('Thursday'),
            __('Friday'),
            __('Saturday'),
            __('Sunday'),
            'Totaaluren'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();

        // Apply styles to the heading row
        $sheet->getStyle('A1:L1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '808080'],
            ],
            'alignment' => ['horizontal' => 'center'],
        ]);

        // Apply styles to the "Total Hours" columns
        $sheet->getStyle('L2:L' . $highestRow)->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'FFFF00'],
            ],
        ]);

        // Apply styles to the week total rows
        for ($i = 2; $i <= $highestRow; $i++) {
            if (strpos($sheet->getCell('A' . $i)->getValue(), 'Totaaluren voor for Week') !== false) {
                $sheet->getStyle('A' . $i . ':L' . $i)->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'CCEEFF'],
                    ],
                    'alignment' => ['horizontal' => 'center'],
                ]);
            }
        }

        // Apply styles to the rest of the cells (week, employee name, location, customer, hours)
        $sheet->getStyle('A2:L' . $highestRow)->applyFromArray([
            'alignment' => ['horizontal' => 'center'],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);

        return [];
    }
}
