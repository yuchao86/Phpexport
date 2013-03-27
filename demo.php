<?php
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
?>
