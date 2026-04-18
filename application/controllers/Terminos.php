<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Terminos extends CI_Controller {

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

	public function index()
	{

		$head['pag_title'] = 'Terminos y Condiciones - AstroPay Card';
		$head['pag_description'] = 'AstroPay Card';
		$head['pag_keywords'] = '';
		
		$this->load->view('web/head', $head);
		$seusu = $this->session->userdata('apc_usuario');
		if($seusu){
			$this->load->view('web/bienvenido', $seusu);
		}else{
			$this->load->view('web/nav');
		}

		$data['template_footer'] = $this->load->view('web/footer','', TRUE);

		$this->load->view('theme_terminos',$data);
		
		//$this->load->view('web/footer');
	}
	
}
