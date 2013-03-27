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

        if(!is_string($name))
        {
            return false;
        }
        $this->filename = $name;
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
        }
        if ($type == 'excel') {
            $excelfilename = $filename . ".xls";

            // output csv file header Csv filename exchange your file name
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment;filename=" . $excelfilename);
            header('Cache-Control: max-age=0');
            header('Expires:0');
            header('Pragma:public');
        }
        if ($type == 'xml') {

        }
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
    public function extOutputCSV($format='csv') {
        // code...
        $filename = $this->filename;
        $column_headers = $this->dataTable;
        // Print format-appropriate beginning
        if ($format == 'csv') {
            $output = fopen('php://output', 'w') or die("Can't open php://output");
            header('Content-Type: application/csv');
            header("Content-Disposition: attachment; filename=".$filename);
            fputcsv($output, $column_headers);
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
    function array_to_string($result) {
        if (empty($result)) {
            return PhpexportIconv("Not export data");
        }
        $data = $this->columns . "\n";
        $size_result = sizeof($result);
        for ($i = 0; $i < $size_result; $i++) {
            $data .= PhpexportIconv($result[$i]['name']) . ',' . i($result[$i]['option']) . "\n";
        }
        return $data;
    }

    /**
     *
     * @param type $strInput
     * @return type
     */
    function PhpexportIconv($strInput) {
        return iconv('utf-8', 'gbk', $strInput); // not used the utf-8
    }

}

?>
