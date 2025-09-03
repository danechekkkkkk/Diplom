<?php
date_default_timezone_set('Europe/Moscow');
require_once '../connect.php'; 
require '../autoload.php'; 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;


$id = $_GET['id'];


$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();


$sheet->getPageSetup()
      ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4)
      ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE) 
      ->setFitToPage(true) 
      ->setFitToWidth(1) 
      ->setFitToHeight(0); 

$line = 1;
$sheet->setCellValue("A{$line}", 'Товарная накладная № ' . $id . ' от ' . date('d.m.Y H:i'));
$sheet->mergeCells("A{$line}:D{$line}"); 
$sheet->getStyle("A{$line}")->getFont()->setBold(true); 
$sheet->getStyle("A{$line}")->getFont()->setSize(18); 

$line++; 
$sheet->setCellValue("A{$line}", '');
$sheet->mergeCells("A{$line}:D{$line}");

$line++;
$sheet->setCellValue("A{$line}", 'Поставщик:'); 
$sheet->getStyle("A{$line}")->getFont()->setBold(true);

$queryInvoice = "SELECT supplier, address, phone, buyer FROM invoices WHERE id = \$1";
$resultInvoice = pg_query_params($connect, $queryInvoice, array($id));
$invoice = pg_fetch_assoc($resultInvoice);

$sheet->setCellValue("B{$line}", htmlspecialchars_decode($invoice['supplier']));
$sheet->getStyle("B{$line}")->getFont()->setBold(true);
$sheet->mergeCells("B{$line}:D{$line}");

$line++;
$sheet->setCellValue("B{$line}", 'Адрес: ____________,  Тел: ____________');
$sheet->mergeCells("B{$line}:D{$line}");
$sheet->getStyle("B{$line}")->getFont()->setBold(true);

$line++; 
$sheet->setCellValue("A{$line}", 'Покупатель:');
$sheet->getStyle("A{$line}")->getFont()->setBold(true);
$sheet->setCellValue("B{$line}", htmlspecialchars_decode($invoice['buyer']));
$sheet->getStyle("B{$line}")->getFont()->setBold(true);
$sheet->mergeCells("B{$line}:D{$line}");

$line++;
$sheet->setCellValue("B{$line}", 'Адрес: ' . htmlspecialchars_decode($invoice['address']). ', тел: ' .htmlspecialchars_decode($invoice['phone']));
$sheet->mergeCells("B{$line}:D{$line}");
$sheet->getStyle("B{$line}")->getFont()->setBold(true);

$line++; 
$sheet->setCellValue("A{$line}", '');
$sheet->mergeCells("A{$line}:D{$line}");

$line++;
$start_table = $line;

$sheet->setCellValue("A{$line}", 'Наименование');
$sheet->setCellValue("B{$line}", 'Кол-во');
$sheet->setCellValue("C{$line}", 'Цена');
$sheet->setCellValue("D{$line}", 'Сумма');
$sheet->getStyle("A{$line}")->getFont()->setBold(true);
$sheet->getStyle("B{$line}")->getFont()->setBold(true);
$sheet->getStyle("C{$line}")->getFont()->setBold(true);
$sheet->getStyle("D{$line}")->getFont()->setBold(true);

$sheet->getColumnDimension('A')->setWidth(30); 
$sheet->getColumnDimension('B')->setWidth(15); 
$sheet->getColumnDimension('C')->setWidth(15); 
$sheet->getColumnDimension('D')->setWidth(25); 

$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['argb' => 'FF000000'], 
        ],
    ],
    'font' => [
        'bold' => true, 
    ],
];

$sheet->getStyle("A{$line}:D{$line}")->applyFromArray($styleArray);

$line++;


$queryItems = "SELECT name, count, price, total FROM items WHERE invoices_id = \$1"; 
$resultItems = pg_query_params($connect, $queryItems, array($id));
$rowNumber = $line; 

$totalSum = 0; 

while ($row = pg_fetch_assoc($resultItems)) {
    $sheet->setCellValue('A' . $rowNumber, htmlspecialchars_decode($row['name']));
    $sheet->setCellValue('B' . $rowNumber, $row['count']);
    $sheet->setCellValue('C' . $rowNumber, number_format($row['price'], 2, ',', ' '));
    $sheet->setCellValue('D' . $rowNumber, number_format($row['total'], 2, ',', ' '));
    
    $totalSum += $row['total'];

    $sheet->getStyle("A{$rowNumber}:D{$rowNumber}")->applyFromArray($styleArray);

    $sheet->getStyle("B{$rowNumber}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

    
    $rowNumber++;
}

$line = $rowNumber; 
$sheet->setCellValue("A{$line}", 'Итого:');
$sheet->mergeCells("A{$line}:C{$line}");
$sheet->setCellValue("D{$line}", number_format($totalSum, 2, ',', ' ')); 
$sheet->getStyle("A{$line}:D{$line}")->getFont()->setBold(true);
$sheet->getStyle("A{$line}:D{$line}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

$line++;
$sheet->setCellValue("A{$line}", 'Отпустил:_________  Получил:_________');
$sheet->mergeCells("A{$line}:C{$line}");
$sheet->getStyle("A{$line}:C{$line}")->getFont()->setBold(true);


header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Накладная_' . date('Y-m-d_H-i-s') . '.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>

