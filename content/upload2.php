<?php

include '/opt/lampp/htdocs/EF_INF/content/PHPExcel/PHPExcel/IOFactory.php';

$inputFileName = '/home/efadmin/Dokumente/file.xlsx';

try{
    


$inputFileType = PHPExcel_IOFactory::identify($inputFileName);

$reader = PHPExcel_IOFactory::createReader($inputFileType);

$reader->setReadDataOnly(true);
$objPHPExcel = $reader->load($inputFileName);



} catch (PHPExcel_Reader_Exception $ex) {
    die('Error loading file: '.$e->getMessage());
}
?>