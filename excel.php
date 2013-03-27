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

$dataTable = array(
/*first line*/
  array("hello","world","\t\n"),

/*start of second line*/
  array("this is second line","Hi,pretty girl","\t\n"),

// test chinese code
  array("北京余超","软件工程师"."\t\n"),
);


echo <<<EXCEL
<html xmlns:o="urn:schemas-microsoft-com:office:office"
  xmlns:x="urn:schemas-microsoft-com:office:excel"
  xmlns="http://www.w3.org/TR/REC-html40">
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html>
  <head>
  <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
  <style id="Classeur1_16681_Styles"></style>
  </head>
  <body>
  <div id="Classeur1_16681" align=center x:publishsource="Excel">
  <table x:str border=0 cellpadding=0 cellspacing=0 width=100% style="border-collapse: collapse">
EXCEL;

foreach($dataTable as $item)
{
  foreach($item as $key=>$value)
  echo "<tr><td class=xl2216681 nowrap>{$key}</td><td class=xl2216681 nowrap>{$value}</td></tr>";
}
echo <<<EXCELEND
  </table>
  </div>
  </body>
  </html>
EXCELEND;

?>
