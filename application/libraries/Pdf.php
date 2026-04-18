<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'third_party/TCPDF/tcpdf.php';
require_once APPPATH.'third_party/FPDI-1.6.1/fpdi.php';

class Pdf extends FPDI
{
    function __construct()
    {
        parent::__construct();
    }
}



/*
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'third_party/TCPDF/tcpdf.php';

class Pdf //extends FPDI
{

    public function __construct()
    {
    	//require_once APPPATH.'third_party/FPDF/fpdf.php'; 
    	require_once APPPATH.'third_party/TCPDF/tcpdf.php';
		require_once APPPATH.'third_party/FPDI-1.6.1/fpdi.php'; 
        //parent::__construct();
    }
}

*/