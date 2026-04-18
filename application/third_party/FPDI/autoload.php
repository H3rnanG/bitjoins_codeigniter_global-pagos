<?php
/**
 * This file is part of FPDI
 *
 * @package   setasign\Fpdi
 * @copyright Copyright (c) 2019 Setasign - Jan Slabon (https://www.setasign.com)
 * @license   http://opensource.org/licenses/mit-license The MIT License
 */

spl_autoload_register(function ($class) {
    if (strpos($class, '\setasign\Fpdi\\') === 0) {  //setasign\Fpdi\Fpdi
        $filename = str_replace('\\', DIRECTORY_SEPARATOR, substr($class, 14)) . '.php';
        $fullpath = __DIR__ . DIRECTORY_SEPARATOR . $filename;
        //echo $fullpath.' --- ';
        if (file_exists($fullpath)) {
            require_once $fullpath;
        }
    }
});
