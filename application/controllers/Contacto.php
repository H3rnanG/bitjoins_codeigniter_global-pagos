<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contacto extends CI_Controller {

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

		$head['pag_title'] = 'Contacto - AstroPay card';
		$head['pag_description'] = 'AstroPay card';
		$head['pag_keywords'] = '';
		
		$this->load->view('web/head', $head);
		$seusu = $this->session->userdata('apc_usuario');
		if($seusu){
			$this->load->view('web/bienvenido', $seusu);
		}else{
			$this->load->view('web/nav');
		}
		$data['template_footer'] = $this->load->view('web/footer', '', TRUE);
		$this->load->view('theme_contacto',$data);
		
		//$this->load->view('web/footer');
	}

	public function enviar(){
		header('Content-type: application/json; charset=utf-8');
		$this->load->library('utilitario');
		$this->load->library('email');

		$nombre = $this->input->post('nombre');
		$fono = $this->input->post('fono');
		$correo = $this->input->post('correo');
		$mensaje = $this->input->post('mensaje');


		$message = 'Mensaje enviado desde la sección Contacto: <br><br>';
		$message.='Nombres: '.$nombre.'<br>';
		$message.='Teléfono: '.$fono.'<br>';
		$message.='E-mail: '.$correo.'<br><br>';
		$message.='Mensaje: '.$mensaje.'<br>';

		$this->email->from('soporte@astropaycard.cl', 'AstroPay Card CL');
		$this->email->subject('AstroPay Card CL - Contacto');
		$this->email->message($message);
		
		$this->email->to('soporte@astropaycard.cl', 'Soporte'); //
		//$this->email->bcc('soporte@astropaycard.pe, carnalismo_01@hotmail.com');
	    //$result = $this->email->send();
	    //echo $this->email->print_debugger();

        
        if($this->email->send()){
        	$arrayRsp = array('rspt'=>'1','msj'=>'Mensaje enviado satisfactoriamente, muy pronto nos pondremos en contacto.');
        }else{
        	$arrayRsp = array('rspt'=>'0','msj'=>'Mensaje NO enviado.');
        }

        echo json_encode($arrayRsp);
        
	}

	
}
