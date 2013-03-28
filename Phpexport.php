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
class Phpexport {

    /**
     *
     * @var type
     */
    public $filename = 'Phpexport';

    /**
     *
     * @var type
     */
    public $columns = array();

    /**
     *
     * @var type
     */
    public $dataTable = array();

    /**
     *
     * @var type
     */
    public $counts = array();

    /**
     *
     * @var type
     */
    public $notes = '';
    public $force = false;

    /**
     *
     * @param type $argument
     * @return boolean
     */
    function __construct($argument) {
        if (!is_array($argument)) {
            return false;
        }
        $this->dataTable = $argument;
    }

    /**
     *
     * @param type $counts
     * @return boolean
     */
    public function setCounts($counts) {
        if (!is_number($counts)) {
            return false;
        }
        $this->counts = $counts;
        // code...
    }

    /**
     *
     * @param type $notes
     */
    public function setNotes($notes) {

        $this->notes = $notes;
        // code...
    }

    /**
     *
     * @param type $name
     * @return boolean
     */
    public function setFilename($name) {

        if (!is_string($name)) {
            return false;
        }
        $this->filename = $name;
    }

    public function setforce($flag = 'true') {
        $this->force = $flag;
        // code...
    }

    /**
     *
     * @param type $type
     * @param string $filename
     * @return boolean
     */
    public static function getExportHeader($type, $filename = '') {
        // exprot header
        $typeArray = array('csv', 'excel', 'pdf', 'xml', 'json', 'rss', 'html');

        if (!in_array($type, $typeArray, true)) {
            return false;
        }
        if (!is_string($filename)) {
            return false;
        }
        if (empty($filename)) {
            $filename = 'phpexport_' . date('YmdHis');
        }
        if ($type == 'csv') {

            $csvfilename = $filename . ".csv";
            header("Content-type:text/csv");
            header("Content-Disposition:attachment;filename=" . $csvfilename);
            header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
            header('Expires:0');
            header('Pragma:public');
            if ($this->force) {
                self::enforceDownload();
            }
        }
        if ($type == 'excel') {
            $excelfilename = $filename . ".xls";

            // output csv file header Csv filename exchange your file name
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment;filename=" . $excelfilename);
            header('Cache-Control: max-age=0');
            header('Expires:0');
            header('Pragma:public');
            if ($this->force) {
                self::enforceDownload();
            }
        }
        if ($type == 'xml') {
            
        }
    }

    public function enforceDownload() {
        // force download dialog
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
    }

    /**
     *
     */
    public static function clearCache() {

        //refrush the output buffer

        ob_flush();
        flush();
    }

    /**
     *
     */
    public function OutputCSV() {
        // code...
        // open the PHP file handler php://output indecated direct output the broswer.
        $fp = fopen('php://output', 'a');

        // output Excel columns information
        $head = $this->dataTable;
        foreach ($head as $i => $v) {
            // CSV Excel iconv GBK
            $head[$i] = iconv('utf-8', 'gbk', $v);
        }

        // call the fputcsv write the file
        fputcsv($fp, $head);
    }

    /**
     *
     * @param type $param
     * @return type
     */
    public static function getParam($param = 'format') {

        // Decide what format to use
        $format = $_GET[$param] == 'csv' ? 'csv' : 'excel';
        return $format;
        // code...
    }

    /**
     *
     * @param type $columns
     * @return boolean
     */
    public function setColumns($columns) {
        if (!is_array($columns)) {
            return false;
        }

        $this->columns = $columns;

        // code...
    }

    /**
     *
     * @param type $format
     */
    public function extOutputCSV($format = 'csv') {
        // code...
        $filename = $this->filename;
        $column_headers = $this->dataTable;
        $column_headers = self::array_to_string($column_headers);

        // Print format-appropriate beginning
        if ($format == 'csv') {
            //$output = fopen('php://output', 'w') or die("Can't open php://output");
            header('Content-Type: application/csv');
            header("Content-Disposition: attachment; filename=" . $filename);
            echo $column_headers;
        } else {
            echo '<table><tr><th>';
            echo implode('</th><th>', $column_headers);
            echo '</th></tr>';
        }
    }

    /**
     *
     * @param type $result
     * @return string
     */
    public function array_to_string($result) {
        if (empty($result)) {
            return self::PhpexportIconv("Not export data");
        }
        $data = $this->columns . "\n";
        $size_result = sizeof($result);

        for ($i = 0; $i < $size_result; $i++) {
            foreach ($result[$i] as $value)
                $data .= self::PhpexportIconv($value) . ",";
            //$data .= self::PhpexportIconv($result[$i]['name']) . ',' . self::PhpexportIconv($result[$i]['option']) . "\n";
            $data .= "\n";
        }
        return $data;
    }

    /**
     *
     * @param type $strInput
     * @return type
     */
    public function PhpexportIconv($strInput) {
        return iconv('utf-8', 'gbk', $strInput); // not used the utf-8
    }

    /**
     * 
     * @param type $fullPath
     */
    public function downloadFile($fullPath) {

        // Must be fresh start
        if (headers_sent())
            die('Headers Sent');

        // Required for some browsers
        if (ini_get('zlib.output_compression'))
            ini_set('zlib.output_compression', 'Off');

        // File Exists?
        if (file_exists($fullPath)) {

            // Parse Info / Get Extension
            $fsize = filesize($fullPath);
            $path_parts = pathinfo($fullPath);
            $ext = strtolower($path_parts["extension"]);

            // Determine Content Type
            switch ($ext) {
                case "pdf": $ctype = "application/pdf";
                    break;
                case "exe": $ctype = "application/octet-stream";
                    break;
                case "zip": $ctype = "application/zip";
                    break;
                case "doc": $ctype = "application/msword";
                    break;
                case "xls": $ctype = "application/vnd.ms-excel";
                    break;
                case "ppt": $ctype = "application/vnd.ms-powerpoint";
                    break;
                case "gif": $ctype = "image/gif";
                    break;
                case "png": $ctype = "image/png";
                    break;
                case "jpeg":
                case "jpg": $ctype = "image/jpg";
                    break;
                default: $ctype = "application/force-download";
            }

            header("Pragma: public"); // required
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private", false); // required for certain browsers
            header("Content-Type: $ctype");
            header("Content-Disposition: attachment; filename=\"" . basename($fullPath) . "\";");
            header("Content-Transfer-Encoding: binary");
            header("Content-Length: " . $fsize);
            ob_clean();
            flush();
            readfile($fullPath);
        }
        else
            die('File Not Found');
    }

    /**
     * 
     * @param type $dataTable
     * @return type
     */
    public function getExcelFile($dataTable) {

        $html = "";

        $start = <<<EXCEL
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

        $html .= $start;

        foreach ($dataTable as $item) {
            foreach ($item as $key => $value)
                $html .= "<tr><td class=xl2216681 nowrap>{$key}</td><td class=xl2216681 nowrap>{$value}</td></tr>";
        }
        $end = <<<EXCELEND
  </table>
  </div>
  </body>
  </html>
EXCELEND;

        $html .= $end;

        return $html;
    }

}

?>
