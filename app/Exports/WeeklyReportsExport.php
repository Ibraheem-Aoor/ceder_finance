<?php namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class WeeklyReportsExport implements FromCollection, WithHeadings, WithStyles
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

        foreach ($this->reportData as $weekNumber => $weekData) {
            $totalHours = 0; // Initialize total hours for the week

            // Add the week number with a background color
            $data[] = ['Week' => "Week $weekNumber"];
            // Add headings for day, date, and working_hours
            $data[] = ['Day' => 'Day', 'Date' => 'Date', 'Hours' => 'Hours'];

            // Add each day's data for the week
            foreach ($weekData as $dayData) {
                // Remove the employee name from each day's data
                unset($dayData['employee_name']);
                $data[] = $dayData;
                $totalHours += $dayData['hours']; // Sum up total hours
            }

            // Add a row for the total working hours for the week
            $data[] = ['Total' => 'Total', "",'Total Hours' => $totalHours];
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [];
    }

    public function styles(Worksheet $sheet)
    {
        // Apply styles to the week number rows (with background color)
        $highestRow = $sheet->getHighestRow();
        for ($i = 1; $i <= $highestRow; $i++) {
            if ($sheet->getCell('A' . $i)->getValue() && strpos($sheet->getCell('A' . $i)->getValue(), 'Week') !== false) {
                $sheet->getStyle('A' . $i . ':C' . $i)->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'CCEEFF'],
                    ],
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => ['horizontal' => 'center'],
                ]);
            }
        }

        // Apply styles to the headings row (day, date, working_hours)
        for ($i = 3; $i <= $highestRow; $i += 4) {
            $sheet->getStyle('A' . $i . ':C' . $i)->applyFromArray([
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '808080'],
                ],
                'alignment' => ['horizontal' => 'center'],
            ]);
        }

        // Apply styles to the rest of the cells (day, date, hours, total, total hours)
        $sheet->getStyle('A4:C' . $highestRow)->applyFromArray([
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
