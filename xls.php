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

header("Content-Transfer-Encoding: binary");
header("Content-Type: application/vnd.ms-execl");
header("Content-Disposition: attachment; filename=myExcel.xls");
header("Pragma: no-cache");
header("Expires: 0");

$dataTable = array(
/*first line*/
  array("hello","world","\t\n"),

/*start of second line*/
  array("this is second line","Hi,pretty girl","\t\n"),

// test chinese code
  array("北京余超","软件工程师"."\t\n"),
);

$phpexport = new Phpexport($dataTable);

echo $phpexport->getExcelFile($dataTable);



?>
