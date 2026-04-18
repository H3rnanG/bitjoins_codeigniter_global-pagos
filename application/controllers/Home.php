<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
    {
            parent::__construct();
            // Your own constructor code
    }

	/*public function _remap($method)
	{
		//die('llego!!!');
		die('M: '.$method);
        if ($method === 'some_method')
        {
			$this->$method();
        }
        else
        {
			$this->default_method();
        }
	}*/

	public function index()
	{
		$this->load->library('utilitario');

		$head['pag_title'] = 'Home - AstroPay card';
		$head['pag_description'] = 'AstroPay card';
		$head['pag_keywords'] = '';
		
		$this->load->view('web/head', $head);
		$seusu = $this->session->userdata('apc_usuario');
		if($seusu){
			$this->load->view('web/bienvenido', $seusu);
		}else{
			$this->load->view('web/nav');
		}
		
		$tc = $this->utilitario->get_tc();
		$data_sld['tc'] = $tc;

		$this->load->view('web/sidebar-banners', $data_sld);

		$data['template_footer'] = $this->load->view('web/footer', '', TRUE);

		//$tc = $this->utilitario->get_tc(); $data['tc'] = $tc;

		$this->load->view('theme_home',$data);
		
		//$this->load->view('web/footer');
	}


	



	
}
