<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Turboemail
{
    public function __construct()
    {
        require_once APPPATH.'third_party/turboemail/TurboApiClient.php'; 
    }
}