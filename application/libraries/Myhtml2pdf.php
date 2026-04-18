<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Myhtml2pdf
{
    public function __construct()
    {
        require_once APPPATH.'third_party/html2pdf/html2pdf.class.php'; //-4.5.1
    }
}