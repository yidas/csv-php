<p align="center">
    <a href="https://codeigniter.com/" target="_blank">
        <img src="https://www.php.net/images/logos/php-logo-bigger.png" height="60px">
    </a>
    <h1 align="center">PHP CSV</h1>
    <br>
</p>

PHP CSV writer &amp; reader with settings of quoting enclosure and encoding

[![Latest Stable Version](https://poser.pugx.org/yidas/csv/v/stable?format=flat-square)](https://packagist.org/packages/yidas/csv)
[![License](https://poser.pugx.org/yidas/csv/license?format=flat-square)](https://packagist.org/packages/yidas/csv)


Features
--------

- *Support generating **Double Quotes** enclosure for all entities setting*

- *Support **Encoding** setting for local dialect*

- ***Elegent Interface** for setup and use*

---

OUTLINE
-------

- [Demonstration](#demonstration)
- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
    - [Options](#options)
    - [Writer](#writer)
    - [Reader](#reader)
    - [Exceptions](#exceptions) 
- [References](#references)

---

DEMONSTRATION
-------------

Quickstart with specifying the file name directly:

```php
// Read the CSV file
$csvReader = new yidas\csv\Reader('/tmp/file.csv');
$rows = $csvReader->readRows();
$csvReader->fclose();
// Write the CSV file
$csvWriter = new yidas\csv\Writer('/tmp/file.csv'); 
$csvWriter->writeRows($rows);
$csvWriter->fclose();
```

### Write to CSV

Open a file and use libray to write in CSV format:

```php
$fp = fopen("/tmp/file.csv", 'w');

$csvWriter = new yidas\csv\Writer($fp, [
    // 'quoteAll' => true,
    // 'encoding' => 'UTF-8'
]); 
$csvWriter->writeRow(["First", 'Second']);
$csvWriter->writeRows([
    ["Normal", 'Double"Quote'], 
    ["It's a context,\nNew line.", 'Encoded中文'],
]);

fclose($fp);
```

The content of generated CSV file will be:

```csv
"First","Second"
"Normal","Double""Quote"
"It's a context,
New line.","Encoded中文"
```

> In default setting, it will always add double quotes with `UTF-8` encoding.

### Read from CSV

Open a CSV file with local encoding (`Big5`) and use libray to read with `UTF-8` encoding:

```php
$fp = fopen("/tmp/file.csv", 'r');

$csvReader = new yidas\csv\Reader($fp, [
    'encoding' => 'Big5'
]); 
$firstRow = $csvReader->readRow();
$remainingRows = $csvReader->readRows();

fclose($fp);
```

---

REQUIREMENTS
------------

This library requires the following:

- PHP CLI 5.4.0+

---

INSTALLATION
------------

Run Composer in your project:

    composer require yidas/csv
    
Then you could use the class after Composer is loaded on your PHP project:

```php
require __DIR__ . '/vendor/autoload.php';

use yidas\csv\Writer;
use yidas\csv\Reader;
```

---

USAGE
-----

### Options

The options in parameter 2 for Writer/Reader class are as below:

#### quoteAll

Controls when quotes should be always generated by the writer.

#### Encoding

Controls which the encoding should be generated by the writer/reader.

> By defaule, Microsoft Excel will open CSV file with local encoding. 
> For example: Excel in Chinese(Traditional) Windows will open CSV with Big5 encoding.

### Writer

```php
$csvWriter = new yidas\csv\Writer($fp, [
    // 'quoteAll' => true,
    // 'encoding' => 'UTF-8'
]); 
```

#### writeRow()

Write the row parameter to the writer’s file stream, formatted according to the current setting.

```php
public static array writeRow(array $rowData)
```

#### writeRows()

Write the rows parameter to the writer’s file stream, formatted according to the current setting.

```php
public static array writeRows(array $rowsData)
```

### Reader

```php
$csvReader = new yidas\csv\Reader($fp, [
    // 'encoding' => 'UTF-8'
]); 
```

#### readRow()

Read a row from current file pointer.

```php
public static array readRow()
```

*Example:*

```php
while ( ($row = $csvReader->readRow($file) ) !== FALSE ) {
    var_dump($row);
}
```

#### readRows()

Read all the rows from current file pointer.

```php
public static array readRows()
```

*Example:*

```php
$rows = $csvReader->readRows();
var_dump($rows);
```

### Exceptions

```php

try {

    $csvWriter = new yidas\csv\Writer($fp, [
        // 'quoteAll' => true,
        // 'encoding' => 'UTF-8'
    ]); 
    $csvWriter->writeRow(["First", 'Second']);
    
} catch (\Exception $e) {

    echo 'Code:' . $e->getCode() . ' Message:' . $e->getMessage();
}
```

---

REFERENCES
----------

- [Comma-separated values - Basic rules - Wiki](https://en.wikipedia.org/wiki/Comma-separated_values#Basic_rules)

- [RFC 4180 - Common Format and MIME Type for Comma-Separated Values (CSV) Files](https://datatracker.ietf.org/doc/html/rfc4180)
