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

header("Content-Transfer-Encoding: binary");
header("Content-Type: application/vnd.ms-execl");
header("Content-Disposition: attachment; filename=myExcel.xls");
header("Pragma: no-cache");
header("Expires: 0");
/*first line*/
echo "hello"."\t";
echo "world"."\t";
echo "\t\n";

/*start of second line*/
echo "this is second line"."\t";
echo "Hi,pretty girl"."\t";
echo "\t\n";

// test chinese code
$me = "北京余超"."\t";
$carrer = "软件工程师"."\t";

echo mb_convert_encoding($me,'GBK', 'UTF-8');
echo iconv('UTF-8', 'GBK',$carrer);

echo "\t\n";
?>
