<?php
namespace App\Libraries;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelDownload
{

    public function run(array $data , array $field , string $file_name ) : void
    {

        $spreadsheet        = new Spreadsheet();
        $activeWorksheet    = $spreadsheet->getActiveSheet();
        $abcd               = getAlphabet();


        foreach ($field as $k => $v) $activeWorksheet->setCellValue("{$abcd[$k]}1", $v);

        $excelIndex = 2;
        foreach ($data as $r) {
            $i = 0;
            foreach ($r as $v) {
                $activeWorksheet->setCellValue("{$abcd[$i]}{$excelIndex}", $v);
                $i++;
            }
            $excelIndex++;
        }

        $writer = new Xlsx($spreadsheet);
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename='.urlencode($file_name.'.xlsx'));
        header("Cache-Control: max-age=0");

        try {
            $writer->save('php://output');
        } catch (Exception $e) {
        }

    }

}