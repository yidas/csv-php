<?php

namespace yidas\csv;

use Exception;

/**
 * CSV Reader
 * 
 * @author  Nick Tsai <myintaer@gmail.com>
 * @version 1.0.0
 */
class Reader
{
    // PHP csv handler uses UTF-8 encoding in default
    const DEFAULT_ENCODING = 'UTF-8';

    /**
     * Current PHP file pointer stream of the reader
     *
     * @var resource
     */
    protected $fileStream = null;

    /**
     * Controls which the encoding should be generated by the writer
     *
     * @var boolean
     */
    protected $encoding = null;

    /**
     * Constructor
     *
     * @param resource|string File pointer or filePath
     * @param array $optParams API Key or option parameters
     * @return self
     */
    function __construct($fileStream, $optParams=[]) 
    {
        // FilePath type input
        if (is_string($fileStream)) {
            // Check
            if (!file_exists($fileStream)) {
                throw new Exception("File not found at argument 1: {$fileStream}", 400);
            }

            $fileStream = fopen($fileStream, 'r');
        }
        // Check file stream
        if (!is_resource($fileStream)) {
            throw new Exception("Invalid file stream at argument 1", 400);
        }

        // Assignment
        $this->fileStream = $fileStream;
        $this->encoding = isset($optParams['encoding']) ? $optParams['encoding'] : $this->encoding;

        return $this;
    }

    /**
     * Read a row from current file pointer.
     *
     * @return array Returns an indexed array containing the fields read.
     */
    public function readRow()
    {
        $row = fgetcsv($this->fileStream);
        
        // Encoding handler
        if (is_array($row) && $this->encoding && $this->encoding!=self::DEFAULT_ENCODING) {
            foreach ($row as $key => & $value) {
                $value = mb_convert_encoding($value, self::DEFAULT_ENCODING, $this->encoding);
            }
        }

        return $row;
    }

    /**
     * Read all the rows from current file pointer.
     *
     * @param array $rowsData
     * @return self 
     */
    public function readRows()
    {
        $rows = [];
        while ( ($row = $this->readRow($this->fileStream) ) !== FALSE ) {
            $rows[] = $row;
        }
        
        return $rows;
    }

    /**
     * fclose for current file stream
     *
     * @return boolean Result
     */
    public function fclose()
    {
        return fclose($this->fileStream);
    }
}
