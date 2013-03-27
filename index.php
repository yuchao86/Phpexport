<?php
include 'Phpexport.php';

$columns = array("第一列","第二列","第三列");

$data = array(
  array("1","2","3"),
  array("2","3","4"),
  array("english","英语","余超"),
  array("+","-","*")
);


$phpexport = new Phpexport($data);
//$phpexport->clearCache();
$phpexport->setColumns($columns);
$phpexport->setNotes("YuChao");

$phpexport->setFilename("yuchao_20130328");

$phpexport->getExportHeader('csv');

$phpexport->OutputCSV();
//$phpexport->extOutputCSV();

?>
