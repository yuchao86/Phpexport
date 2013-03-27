<?php

/**
 * Phpexport - Open source export data
 *
 * @link http://github.com/yuchao86/phpexport.git
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 * @category Phpexport
 * @package Phpexport
 */

/**
 * CSV export
 *
 * When rendered using the default settings, a CSV report has the following characteristics:
 * The first record contains headers for all the columns in the report.
 * All rows have the same number of columns.
 * The default field delimiter string is a comma (,).
 * Formatting and layout are ignored.
 *
 * @package Phpexport
 * @subpackage DataTable
 */
 
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
