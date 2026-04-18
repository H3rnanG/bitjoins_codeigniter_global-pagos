<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {

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
            date_default_timezone_set('America/Santiago');
            // Your own constructor code
    }

    public function testsms(){
    	//require __DIR__ . '/vendor/autoload.php';
		//use Twilio\Rest\Client;

    	$this->load->library('utilitario');
    	$token = $this->utilitario->getCodigo();

		// Your Account SID and Auth Token from twilio.com/console
		$account_sid = ''
		$auth_token = ''
		// In production, these should be environment variables. E.g.:
		// $auth_token = $_ENV["TWILIO_AUTH_TOKEN"]

		// A Twilio number you own with SMS capabilities
		$twilio_number = "+14242772248"; // "+14242772248"; // 995378361
		$twilio_sms = 'AstroPay card código de acceso: '.$token;

		//$client = new Client($account_sid, $auth_token);
		$client = new Twilio\Rest\Client($account_sid, $auth_token);
		$client->messages->create(
		    // Where to send a text message (your cell phone?)
		    '+51980456099',
		    array(
		        'from' => $twilio_number,
		        'body' => $twilio_sms
		    )
		);
		
		/*
		$client->messages->create(
		    // Where to send a text message (your cell phone?)
		    'whatsapp:+51980456099',
		    array(
		        'from' => $twilio_number,
		        'body' => $twilio_sms
		    )
		);

		print($message->sid);
		*/
		echo 'SMS: '.$twilio_sms;

    }

	public function index()
	{
		//$this->load->model('Producto_model','producto');

		$head['pag_title'] = 'Registro de Usuario - AstroPay Card';
		$head['pag_description'] = 'AstroPay Card - Registro de Usuario';
		$head['pag_keywords'] = '';
		
		$this->load->view('web/head', $head);

		$seusu = $this->session->userdata('apc_usuario');
		if($seusu){
			$this->load->view('web/bienvenido', $seusu);
		}else{
			$this->load->view('web/nav');
		}

		$data['template_footer'] = $this->load->view('web/footer', '', TRUE);

		$keyForm = rand(1,9999999999);
		$this->session->set_tempdata('keyform', $keyForm, SE_CARRITO);
		$data['keyform'] = $keyForm;

		$this->load->view('usuario/registro',$data);
		
		//$this->load->view('web/footer');
	}

	public function frmresetpass()
	{
		//$this->load->model('Producto_model','producto');

		$head['pag_title'] = 'Reset Password - AstroPay Card';
		$head['pag_description'] = 'AstroPay Card - Reset Password';
		$head['pag_keywords'] = '';

		$usu = $this->uri->segment(3);
		$tkn = $this->uri->segment(4);

		/*if(strlen($usu) > 0){
			$usu = str_replace('---', '@', $usu);
		}*/
		
		$this->load->view('web/head', $head);


		$seusu = $this->session->userdata('apc_usuario');
		if($seusu){
			$this->load->view('web/bienvenido', $seusu);
		}else{
			$this->load->view('web/nav');
		}
		$data['template_footer'] = $this->load->view('web/footer', '', TRUE);

		$keyForm = $tkn;
		$this->session->set_tempdata('keyform', $keyForm, SE_CARRITO);
		$data['keyform'] = $keyForm;

		$data['usuario'] = $usu;
		$data['token'] = $tkn;

		$this->load->view('usuario/resetpass-frm',$data);
		
		//$this->load->view('web/footer');
	}	


	public function grbresetpass(){
		header('Content-type: application/json;');
		$this->load->model('Usuario_model','usuario');

		$seKeyForm = STRKEY.$this->session->tempdata('keyform');

		try {
			//$this->db->trans_start(TRUE);
			$this->db->trans_begin();
			//$carrito = $this->session->tempdata('pbk_carrito');
			$post = $this->input->post();
			$datos = array('estado'=>'2','msj'=>'No se realizo ninguna operación.','error'=>'vacio','datos'=>'','redirec'=>base_url());

			if(array_key_exists('keyform', $post)){

				$keyForm = STRKEY.$post['keyform'];
				$post['id'] = '';
				$post['token'] = $post['keyform'];
				unset($post['keyform']);


				if($keyForm == $seKeyForm){
					if ($this->db->trans_status() === FALSE)
					{
						$this->db->trans_rollback();
						$datos = array(
										'estado'=>'2', 
										'msj'=>'Hubo un error al registar los datos, contacto con el administrador del Sitio Web.',
										'error'=> 'Error de SQL',
										'redirec'=> '',
										'datos'=>array()
									);
					}
					else
					{
						$usuario = $post['usuario'];
						$token = $post['token'];

						$usuario = str_replace('---', '@', $usuario);
							
						$filtro = array('usuario' => $usuario,
										'token' => $post['token'],
										);
						$upddatos['fechareg'] = date('Y-m-d');
						$upddatos['password'] = $post['pass'];
						$upddatos['token'] = '';

						//if($usuexiste == 1){
						$rs = $this->usuario->updatepass($filtro, $upddatos);

						$datos = array(
									'estado'=>'1', 
									'msj'=>'Sus datos fueron actualizados. <a href="'.base_url('usuario/login').'" <br> >>> CLICK PARA INICIAR SESSIÓN <<< </a>',
									'error'=> '0',
									'redirec'=> '',
									'datos'=>$rs
								);	
					}
				}else{
					$datos = array(
									'estado'=>'2', 
									'msj'=>'El token a caducado o no es el correcto, debe volver a realizar el registro <a href="'.base_url('usuario').'">CLICK AQUÍ</a>.',
									'error'=> 'Token errado',
									'redirec'=> base_url('usuario')
									);
				} // fin if keycart
			} // if key_exists keyform
			$this->db->trans_commit();
			echo json_encode($datos, JSON_FORCE_OBJECT | JSON_HEX_TAG | JSON_HEX_APOS);

		} catch (Exception $e) {
			//echo 'Excepción capturada: ',  $e->getMessage(), "\n";
			//$this->session->sess_destroy();
			$this->db->trans_rollback();
			echo json_encode(array(
								'status'=>'2', 
								'msj'=>'Hubo un error en la transacción.',
								'error'=>$e->getMessage(),
								'redirec'=> base_url('error')
			), JSON_FORCE_OBJECT | JSON_HEX_TAG | JSON_HEX_APOS);
		}

	}



	public function resetpass()
	{
		//$this->load->model('Producto_model','producto');

		$head['pag_title'] = 'Reset Password - AstroPay Card';
		$head['pag_description'] = 'AstroPay Card - Reset Password';
		$head['pag_keywords'] = '';
		
		$this->load->view('web/head', $head);

		$seusu = $this->session->userdata('apc_usuario');
		if($seusu){
			$this->load->view('web/bienvenido', $seusu);
		}else{
			$this->load->view('web/nav');
		}
		
		//$this->load->view('web/sidebar-banners');

		$data['template_footer'] = $this->load->view('web/footer', '', TRUE);

		$keyForm = rand(1,9999999999);
		$this->session->set_tempdata('keyform', $keyForm, SE_CARRITO);
		$data['keyform'] = $keyForm;

		$this->load->view('usuario/resetpass',$data);
		
		//$this->load->view('web/footer');
	}

	public function actualizapass(){
		header('Content-type: application/json;');
		$this->load->model('Usuario_model','usuario');

		$seKeyForm = STRKEY.$this->session->tempdata('keyform');

		try {
			//$this->db->trans_start(TRUE);
			$this->db->trans_begin();
			//$carrito = $this->session->tempdata('pbk_carrito');
			$post = $this->input->post();
			$datos = array('estado'=>'2','msj'=>'No se realizo ninguna operación.','error'=>'vacio','datos'=>'','redirec'=>base_url());

			if(array_key_exists('keyform', $post)){
				$keyForm = STRKEY.$post['keyform'];
				//$post['id'] = '';
				$post['token'] = $post['keyform'];
				unset($post['keyform']);

				if($keyForm == $seKeyForm){
					if ($this->db->trans_status() === FALSE)
					{
						$this->db->trans_rollback();

						$datos = array(
										'estado'=>'2', 
										'msj'=>'Hubo un error al registar los datos, contacto con el administrador del Sitio Web.',
										'error'=> 'Error de SQL',
										'redirec'=> '',
										'datos'=>array()
									);
					}
					else
					{

						$post['fechareg'] = date('Y-m-d');
						$usuario = $post['usuario'];
						$usuexiste = $this->usuario->get_existe_usuario($usuario);
						
						$filtro = array('usuario' => $usuario);

						if($usuexiste == 1){
							$rs = $this->usuario->updatepass($filtro, $post);

							$token = $post['token'];
							$this->email_resetpass($usuario,$token);

							$datos = array(
										'estado'=>'1', 
										'msj'=>'Revise su E-mail en unos momentos le llegara un enlace para actualizar los datos. <a href="'.base_url().'"> >>> CLICK PARA VOLVER AL HOME <<< </a>',
										'error'=> '0',
										'redirec'=> '',
										'datos'=>$rs
									);	
						}
					}
				}else{
					$datos = array(
									'estado'=>'2', 
									'msj'=>'El token a caducado o no es el correcto, debe volver a realizar el registro <a href="'.base_url('usuario').'">CLICK AQUÍ</a>.',
									'error'=> 'Token errado',
									'redirec'=> base_url('usuario')
									);
				} // fin if keycart
			} // if key_exists keyform
			$this->db->trans_commit();
			echo json_encode($datos, JSON_FORCE_OBJECT | JSON_HEX_TAG | JSON_HEX_APOS);

		} catch (Exception $e) {
			//echo 'Excepción capturada: ',  $e->getMessage(), "\n";
			//$this->session->sess_destroy();
			$this->db->trans_rollback();
			echo json_encode(array(
								'status'=>'2', 
								'msj'=>'Hubo un error en la transacción.',
								'error'=>$e->getMessage(),
								'redirec'=> base_url('error')
			), JSON_FORCE_OBJECT | JSON_HEX_TAG | JSON_HEX_APOS);
		}

	}

	public function email_resetpass($usu='',$token=''){ //
		$this->load->model('Usuario_model','usuario');
		$this->load->library('utilitario');
		$this->load->library('email');

		$usulink = str_replace('@', '---', $usu);
		$data['usuario'] = $usulink;
		$data['token'] = $token;

		$message = $this->load->view('usuario/template-reset', $data, TRUE);

		$this->email->from('soporte@astropaycard.cl', 'AstroPay Card CL');
		$this->email->subject('AstroPay Card - Resetear Password');
		$this->email->message($message);
		
		$this->email->reply_to('soporte@astroypaycard.cl');
		$this->email->to($usu);
		//$this->email->bcc('soporte@astropaycard.pe, soporte@astropaycard.pe, anthony1585@gmail.com');
		
	    $swSend = 0;
        if($this->email->send()){
        	$swSend = 1;
        }

        return $swSend;

        //$this->load->view('compra/template-confirma',$data);

	}

	public function registro(){
		header('Content-type: application/json');
		$this->load->model('Usuario_model','usuario');

		$this->load->library('utilitario');
		$ip = $this->utilitario->getRealIP();
		$page = 'https://ipinfo.io/'.$ip;
		$json = @file_get_contents($page);
		$arr = json_decode($json);

		$data_ip = $ip;
		$data_pais = Locale::getDisplayRegion('-'.$arr->country,'es'); 
		$data_ciudad = $arr->city;
		$data_latlon = $arr->loc;

		$seKeyForm = STRKEY.$this->session->tempdata('keyform');

		try {
			//$this->db->trans_start(TRUE);
			$this->db->trans_begin();
			//$carrito = $this->session->tempdata('pbk_carrito');
			$post = $this->input->post();
			//echo 'datos post'; die(var_dump($post));

			$datos = array('estado'=>'2','msj'=>'No se realizo ninguna operación.','error'=>'vacio','datos'=>'','redirec'=>base_url());

			if(array_key_exists('keyform', $post)){
				$keyForm = STRKEY.$post['keyform'];
				$post['id'] = '';
				$post['token'] = $post['keyform'];
				unset($post['keyform']);

				if($keyForm == $seKeyForm){
					if ($this->db->trans_status() === FALSE)
					{
						$this->db->trans_rollback();
						$datos = array(
										'estado'=>'2', 
										'msj'=>'Hubo un error al registar los datos, contacto con el administrador del Sitio Web.',
										'error'=> 'Error de SQL',
										'redirec'=> '',
										'datos'=>array()
									);
					}
					else
					{
						$nrowsp = $post['nrowsp'];
						$pass1 = $post['pass'];
						unset($post['pass']);
						$pass2 = $post['passconf'];
						unset($post['passconf']);

						if($pass1 !== $pass2){
							$datos = array(
										'estado'=>'2', 
										'msj'=>'El password no coincide, revise los datos en el formulario.',
										'error'=> 'Error en los Passwords ingresados',
										'redirec'=> '',
										'datos'=>$post
									);
						}else{
							$post['password'] = $pass1;
							$post['fechareg'] = date('Y-m-d');

							$usunomb = $post['nombres'].' '.$post['apellidos'];
							$usuario = $post['usuario'];
							$usuexiste = $this->usuario->get_existe_usuario($usuario);

							if($usuexiste == 0){

								$token = $this->utilitario->getCodigo();
								$celular = $post['celular'];
								$celular = $this->utilitario->formatCelular($celular);

								$nrowsp = $post['nrowsp'];
								$nrowsp = $this->utilitario->formatCelular($nrowsp);

								$arrData['id'] = '';
								$arrData['nombres'] = $post['nombres'];
								$arrData['apellidos'] = $post['apellidos'];
								$arrData['usuario'] = $post['usuario'];
								$arrData['celular'] = $celular;
								$arrData['nrowsp'] = $nrowsp;
								$arrData['password'] = $pass1; 

								$arrData['tipodoc'] = $post['tipodoc'];
								$arrData['documento'] = $post['documento'];
								$arrData['direccion'] = $post['direccion'];
								$arrData['distrito'] = $post['distrito'];
								$arrData['nacionalidad'] = $post['nacionalidad'];
								$arrData['terminos'] = $post['terminos'];
								$arrData['fechareg'] = date('Y-m-d');

								$arrData['ip'] = $data_ip;
								$arrData['pais'] = $data_pais;
								$arrData['ciudad'] = $data_ciudad;
								$arrData['latlon'] = $data_latlon;
								$arrData['sw'] = TKN;
								$arrData['token'] = $token;
								$rs = $this->usuario->insert($arrData);

								unset($post['terminos']);

								if($rs){
									$arrLog = array();
									$usuario_id = $rs['id'];
									$arrLog['id'] = '';
									$arrLog['usuario_id'] = $usuario_id;
									$arrLog['fecha'] = date('Y-m-d');
									$arrLog['hora'] = date('H:i:s');
									$arrLog['ip'] = $data_ip;
									$arrLog['pais'] = $data_pais;
									$arrLog['ciudad'] = $data_ciudad;
									$arrLog['latlon'] = $data_latlon;
									$this->usuario->insertlog($arrLog);
								} // fin $rs

								//$this->email_infosoporte($usunomb, $usuario, $data_latlon, $data_pais, $data_ciudad, $data_ip);
						    	
								$twilio_sms = 'AstroPay card codigo de validacion: '.$token;
								$this->sendtoken($celular, $twilio_sms);

								//$token = $post['token'];
								$this->email_confirmacion($usuario,$token, $usunomb, $nrowsp);
								$arrUsuario = $this->usuario->get_login($usuario,$pass1);
								//unset($arrUsuario['sw']); 
								unset($arrUsuario['ps']);
								$this->session->set_userdata('apc_usuario',$arrUsuario);

								$usulink = str_replace('@', '---', $usuario);
								$datos = array(
											'estado'=>'1', 
											'msj'=>'Recibimos sus datos satisfactoriamente.', //necesitamos algunos datos adicionales <a href="'.base_url('usuario/confirma/'.$usuario.'/'.$token).'"> Click aquí para completar sus datos.</a>',
											'error'=> '0',
											'redirec'=> base_url('comprar/'), //base_url('usuario/confirma/'.$usulink.'/'.$token),
											'datos'=>$rs
										);	
							}else{
								$datos = array(
											'estado'=>'2', 
											'msj'=>'El usuario ingresado ya existe.',
											'error'=> '0',
											'redirec'=> '',
											'datos'=>$post
										);	
							}
						}
					}
				}else{
					$datos = array(
									'estado'=>'2', 
									'msj'=>'El token a caducado o no es el correcto, debe volver a realizar el registro <a href="'.base_url('usuario').'">CLICK AQUÍ</a>.',
									'error'=> 'Token errado',
									'redirec'=> base_url('usuario')
									);
				} // fin if keycart
			} // if key_exists keyform
			$this->db->trans_commit();
			echo json_encode($datos, JSON_FORCE_OBJECT | JSON_HEX_TAG | JSON_HEX_APOS);

		} catch (Exception $e) {
			//echo 'Excepción capturada: ',  $e->getMessage(), "\n";
			//$this->session->sess_destroy();
			$this->db->trans_rollback();
			echo json_encode(array(
								'status'=>'2', 
								'msj'=>'Hubo un error durante el registro de usuario.',
								'error'=>$e->getMessage(),
								'redirec'=> '', //base_url('usuario/error')
			), JSON_FORCE_OBJECT | JSON_HEX_TAG | JSON_HEX_APOS);
		}
	}

	public function generatoken(){
		header('Content-type: application/json');

		$this->load->model('Usuario_model','usuario');
		$this->load->library('utilitario');

		try {
			$seusu = $this->session->userdata('apc_usuario');
			if($seusu){

				$celular = $this->input->post('celular');
				$celular = $this->utilitario->formatCelular($celular);

				$token = $this->utilitario->getCodigo();
				$idUsuario = $seusu['id'];

				$dataUsu = array('id'=>$idUsuario, 'celular'=>$celular, 'token'=>$token);
				$this->usuario->insert($dataUsu);

				$twilio_sms = 'AstroPay card codigo de validacion: '.$token;
				$this->sendtoken($celular, $twilio_sms);

				$datos = array(
								'estado'=>'1', 
								'msj'=>'Su código fue enviado al número de celular'.$celular, //.' - '.$token
								'error'=> '0',
								'redirec'=> '',
								'datos'=>array()
							);
				echo json_encode($datos);
			}else{
				echo json_encode(array(
								'status'=>'2', 
								'msj'=>'Debe iniciar sesión.',
								'error'=>$e->getMessage(),
								'redirec'=> base_url('error')
								), JSON_FORCE_OBJECT | JSON_HEX_TAG | JSON_HEX_APOS);
			} // fin if session
			

		} catch (Exception $e) {

			echo json_encode(array(
								'status'=>'2', 
								'msj'=>'Hubo un error en la transacción.',
								'error'=>$e->getMessage(),
								'redirec'=> base_url('error')
			), JSON_FORCE_OBJECT | JSON_HEX_TAG | JSON_HEX_APOS);
		}

	}

	public function validatoken(){
		header('Content-type: application/json');

		$this->load->model('Usuario_model','usuario');
		$this->load->library('utilitario');

		try {
			$seusu = $this->session->userdata('apc_usuario');
			if($seusu){

				$celular = $this->input->post('celular');
				$token = $this->input->post('token');

				$celular = $this->utilitario->formatCelular($celular);
				$idUsuario = $seusu['id'];
				
				$usUsuario = $seusu['usuario'];
				$psUsuario = '';

				$rsUsu = $this->usuario->get_vista($idUsuario);

				if($rsUsu){
					$sw = false;
					foreach ($rsUsu as $key => $f) {
						if($celular == $f['celular'] && $token == $f['token']){
							$sw = true;
							$psUsuario = $f['password'];
						} // fin if
					} // fin foreach

					if($sw){
						$dataUsu = array('id'=>$idUsuario, 'token'=>'', 'sw'=>ON); //
						$this->usuario->insert($dataUsu);

						$arrUsuario = $this->usuario->get_login($usUsuario,$psUsuario);
						//unset($arrUsuario['sw']); 
						unset($arrUsuario['ps']);
						$this->session->set_userdata('apc_usuario',$arrUsuario);

						$datos = array(
									'estado'=>'1', 
									'msj'=>'Su validación fue un exito.',
									'error'=> '0',
									'redirec'=> base_url('comprar/'),
									'datos'=>array()
								);
					}else{
						$datos = array(
								'estado'=>'2', 
								'msj'=>'Los datos ingresado no coinciden con su usuario.',
								'error'=> '0',
								'redirec'=> '',
								'datos'=>array()
							);
					} // fin if rsUsu

				}else{
					$datos = array(
								'estado'=>'2', 
								'msj'=>'Usuario no encontrado, verifique si su sesión esta activa.',
								'error'=> '0',
								'redirec'=> '',
								'datos'=>array()
							);
				}

				echo json_encode($datos);
			}else{
				echo json_encode(array(
								'status'=>'2', 
								'msj'=>'Debe iniciar sesión.',
								'error'=>'0',
								'redirec'=> base_url('error')
								), JSON_FORCE_OBJECT | JSON_HEX_TAG | JSON_HEX_APOS);
			} // fin if session
			

		} catch (Exception $e) {

			echo json_encode(array(
								'status'=>'2', 
								'msj'=>'Hubo un error en la transacción.',
								'error'=>$e->getMessage(),
								'redirec'=> base_url('error')
			), JSON_FORCE_OBJECT | JSON_HEX_TAG | JSON_HEX_APOS);
		}

	}

	private function sendtoken($celular = '', $twilio_sms = ''){
		//$twilio_sms = 'AstroPay card código de acceso: '.$token;
		if(strlen($twilio_sms) > 0){
			$client = new Twilio\Rest\Client(TWL_SID, TWL_TKN);
			$client->messages->create(
			    $celular,
			    array(
			        'from' => TWL_NUM,
			        'body' => $twilio_sms
			    )
			);
		}
	}

	public function confirma(){

		$usu = $this->uri->segment(3);
		$token = $this->uri->segment(4);
		$usu = str_replace('---', '@', $usu);
		//die($usu.' --- '.$token);

		$head['pag_title'] = 'Datos de Usuario - AstroPay Card';
		$head['pag_description'] = 'AstroPay Card - Confirmación de Usuario';
		$head['pag_keywords'] = '';
		
		$this->load->view('web/head', $head);
		$seusu = $this->session->userdata('apc_usuario');
		if($seusu){
			$this->load->view('web/bienvenido', $seusu);
		}else{
			$this->load->view('web/nav');
		}

		$data['template_footer'] = $this->load->view('web/footer', '', TRUE);
		$data['usuario'] = $usu;
		$data['token'] = $token;

		if(strlen($usu) > 0 && strlen($token) > 0){
			$this->load->view('usuario/datos-confirmacion',$data);
		}else{
			$this->load->view('error',$data);
		}

		//die('confirmación');
	}


	public function confirmaregistro(){
		header('Content-type: application/json');
		$usu = $this->input->post('usuario');
		$token = $this->input->post('token');

		$direccion = $this->input->post('direccion');
		$telefono = $this->input->post('telefono');
		$celular = $this->input->post('celular');
		//$billetera = $this->input->post('billetera');

		$nacionalidad = $this->input->post('nacionalidad');
		$tipodoc = $this->input->post('tipodoc');
		$documento = $this->input->post('documento');
		$dni1 = $this->input->post('dni1');
		$dni2 = $this->input->post('dni2');

		$terminos = $this->input->post('terminos');
		$distrito = $this->input->post('distrito');
		//$usu = str_replace('---', '@', $usu);

		if(strlen($usu) > 0 && strlen($token) > 0){
			$this->db->set('sw',ON);
			$this->db->set('fechoraconf',date('Y-m-d'));
			$this->db->set('token','');

			$this->db->set('direccion',$direccion);
			$this->db->set('telefono',$telefono);
			$this->db->set('celular',$celular);

			//$this->db->set('billetera',$billetera);

			$this->db->set('nacionalidad',$nacionalidad);
			$this->db->set('tipodoc',$tipodoc);
			$this->db->set('documento',$documento);

			$this->db->set('terminos',$terminos);
			$this->db->set('distrito',$distrito);
			
			$this->db->set('dni1',$dni1);
			$this->db->set('dni2',$dni2);

			$this->db->where('sw',OFF);
			$this->db->where('usuario',$usu);
			$this->db->where('token',$token);

			$this->db->update('usuario');	
		}

		$filasAfec = $this->db->affected_rows();

		$usu = str_replace('@', '---', $usu);

		if($filasAfec > 0){
			$datos = array(
						'estado'=>'1', 
						'msj'=>'Registro exitoso',
						'error'=> '0',
						'redirec'=> base_url('usuario/registroexitoso/'.$usu),
						'datos'=>array()
					);
		}else{
			$datos = array(
						'estado'=>'2', 
						'msj'=>'Ocurrio un error al registrar los datos, revise los datos ingresados.',
						'error'=> '0',
						'redirec'=> '',
						'datos'=>array()
					);
			//$this->load->view('error',$data);
		}

		echo json_encode($datos);
		//die('confirmación');
	}

	public function registroexitoso(){

		$usu = $this->uri->segment(3);

		if(strlen($usu) > 0){
			$usu = str_replace('---', '@', $usu);
		}

		$head['pag_title'] = 'Confirmación de Usuario - AstroPay Card';
		$head['pag_description'] = 'AstroPay Card - Confirmación de Usuario';
		$head['pag_keywords'] = '';
		
		$this->load->view('web/head', $head);
		$seusu = $this->session->userdata('apc_usuario');
		if($seusu){
			$this->load->view('web/bienvenido', $seusu);
		}else{
			$this->load->view('web/nav');
		}

		$data['template_footer'] = $this->load->view('web/footer', '', TRUE);
		$data['usuario'] = $usu;
		$this->load->view('usuario/confirmacion',$data);
		
	}

	public function upload()
	{	
		header('Content-type: application/json');
		//var_dump($_FILES); die();
		$this->load->library('uploader');
	    $status = "";
	    $msg = "";
	    $archivo = $_FILES['avatar'];
	    /*if(!count($archivo)){
	    	$archivo = $_FILES['avatar2'];
	    }*/

	    $newfilename = rand(1,99999);
	    $nomarchivo = str_replace('.', '-', $archivo['name']);

	    if($archivo){
	    	$data = $this->uploader->upload($archivo, array(
		        'limit' => 1, //Maximum Limit of files. {null, Number}
		        'extensions' => array('jpg', 'jpeg', 'png', 'gif'), //Whitelist for file extension. {null, Array(ex: array('jpg', 'png'))}
		        'required' => false, //Minimum one file is required for upload {Boolean}
		        'uploadDir' => UPLOAD, //Upload directory {String}
		        'title' => $nomarchivo.'-'.$newfilename, //, '{{random}}' array('auto', 10) //New file name {null, String, Array} *please read documentation in README.md
		        'removeFiles' => true, //Enable file exclusion {Boolean(extra for jQuery.filer), String($_POST field name containing json data with file names)}
		        'perms' => null, //Uploaded file permisions {null, Number}
		        'onCheck' => null, //A callback function name to be called by checking a file for errors (must return an array) | ($file) | Callback
		        'onError' => null, //A callback function name to be called if an error occured (must return an array) | ($errors, $file) | Callback
		        'onSuccess' => null, //A callback function name to be called if all files were successfully uploaded | ($files, $metas) | Callback
		        'onUpload' => null, //A callback function name to be called if all files were successfully uploaded (must return an array) | ($file) | Callback
		        'onComplete' => null, //A callback function name to be called when upload is complete | ($file) | Callback
		        //'onRemove' =>  $urlDelete//A callback function name to be called by removing files (must return an array) | ($removed_files) | Callback
		    ));
	    } // fin if archivo
	    
	    if($data['isComplete']){
		    $files = $data['data'];
		    //print_r($files);
		    $status = "done";
	    	$msg = 'Archivo subido correctamente!';
	    	$arrDato = $data['data']['metas'][0];
	    	$archivo = ''; $nomarc = '';
	    	if($arrDato){
	    		$archivo = base_url('assets/upload/'.$arrDato['name']);
	    		$nomarch = $arrDato['name'];
	    	}
		}

		if($data['hasErrors']){
	        $errors = $data['errors'];
	        //print_r($errors);
	        $status = "error";
	    	$msg = $data['errors'];
	    	$archivo = '';
	    }

	    $arch = $files['files'][0];

	    echo json_encode(array('status'=>$status, 'msg' => $msg, 'url'=>$archivo, 'nombre'=>$nomarch));
	}

	public function email_infosoporte($nombres='', $usuario='', $latlong='',$pais='', $ciudad='', $ip='', $msg=''){ //
		$this->load->model('Usuario_model','usuario');
		$this->load->library('utilitario');
		$this->load->library('email');

		$data['nombres'] = $nombres;
		$data['usuario'] = $usuario;
		$data['latlong'] = $latlong;
		$data['pais'] = $pais;
		$data['ciudad'] = $ciudad;
		$data['ip'] = $ip;

		if(strlen($msg) == 0){
			$msg = 'Usuario nuevo registrado, los datos fueron obtenidos durante el registro de sus datos.';
		}
		$data['msg'] = $msg;

		$message = $this->load->view('usuario/template-infousu', $data, TRUE);

		$this->email->from('soporte@astropaycard.cl', 'AstroPay Card CL');
		$this->email->subject('AstroPay Card - Información de Usuario');
		$this->email->message($message);
		$this->email->reply_to('soporte@astroypaycard.cl');
		$this->email->to('soporte@astropaycard.cl');
		//$this->email->bcc('anthony1585@gmail.com');
		
	    $swSend = 0;
        if($this->email->send()){
        	$swSend = 1;
        }
        return $swSend;
        //$this->load->view('compra/template-confirma',$data);
	}

	public function test(){
		$this->load->library('utilitario');
		$ip = $this->utilitario->getRealIP();
		$page = 'https://ipinfo.io/'.$ip;
		$json = @file_get_contents($page);
		$arr = json_decode($json);

		$data_ip = $ip;
		$data_pais = Locale::getDisplayRegion('-'.$arr->country,'es'); 
		$data_ciudad = $arr->city;
		$data_latlon = $arr->loc;

		$data['usunom'] = 'Anthony Alvarez Roca';
		$data['nrowsp'] = '9898989898';
		$data['token'] = '9898989898';

		$data['nombres'] = 'Anthony Alvarez Roca';
		$data['usuario'] = 'anthony1585@gmail.com';
		$data['latlong'] = $data_latlon;
		$data['pais'] = $data_pais;
		$data['ciudad'] = $data_ciudad;
		$data['ip'] = $data_ip;
		$data['msg'] = '';
		$this->load->view('usuario/template-confirmacion',$data);
	}

	public function email_confirmacion($usu='',$token='', $usunom = '', $nrowsp = ''){ //
		$this->load->model('Usuario_model','usuario');
		$this->load->library('utilitario');
		$this->load->library('email');

		$usulink = str_replace('@', '---', $usu);
		$data['usuario'] = $usulink;
		//$data['token'] = $token;
		$data['usunom'] = $usunom;
		$data['nrowsp'] = $nrowsp;
		$message = $this->load->view('usuario/template-confirmacion', $data, TRUE);
		/*$config['protocol'] = 'smtp';
		$config['mailtype'] = 'html';
		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;
		$config['smtp_host'] = 'mail.astropaycard.pe';
		$config['smtp_user'] = 'soporte@astropaycard.pe';
		$config['smtp_pass'] = 'fRM2018++';
		$config['smtp_port'] = '25';*/

		$this->email->from('soporte@astropaycard.cl', 'AstroPay Card CL');
		$this->email->subject('AstroPay Card - Confirmación de Email');
		$this->email->message($message);
		$this->email->reply_to('soporte@astroypaycard.cl');
		$this->email->to($usu);
		$this->email->bcc('soporte@astropaycard.cl');
		
	    $swSend = 0;
        if($this->email->send()){
        	$swSend = 1;
        }
        return $swSend;
        //$this->load->view('compra/template-confirma',$data);
	}

	public function geo(){
		//header('Content-type: application/json; charset=utf-8');
		$path = '';
		$page = 'https://ipinfo.io/179.6.197.15';
		$json = @file_get_contents($page);
		$arr = json_decode($json);

		echo $arr->ip.'  <br> ';
		echo Locale::getDisplayRegion('-'.$arr->country,'es').'  <br> ';
		echo $arr->city.'  <br> ';
		echo $arr->loc.'  <br> ';
		echo $arr->timezone.'  <br> ';
		//die(var_dump($arr));
	}

	public function login(){

		$head['pag_title'] = 'Usuario - AstroPay Card';
		$head['pag_description'] = 'AstroPay Card';
		$head['pag_keywords'] = '';
		
		$this->load->view('web/head', $head);
		$seusu = $this->session->userdata('apc_usuario');
		if($seusu){
			$this->load->view('web/bienvenido', $seusu);
		}else{
			$this->load->view('web/nav');
		}
		$data['template_footer'] = $this->load->view('web/footer', '', TRUE);

		$keyForm = rand(1,9999999999);
		$this->session->set_tempdata('keyform', $keyForm, SE_CARRITO);
		$data['keyform'] = $keyForm;

		$this->load->view('usuario/login',$data);
	}

	public function loguear(){
		header('Content-type: application/json');
		$this->load->model('Usuario_model','usuario');

		$this->load->library('utilitario');
		$ip = $this->utilitario->getRealIP();
		$page = 'https://ipinfo.io/'.$ip;
		$json = @file_get_contents($page);
		$arr = json_decode($json);

		$data_ip = $ip;
		$data_pais = Locale::getDisplayRegion('-'.$arr->country,'es'); //geoip_country_name_by_name($ip);
		$data_ciudad = $arr->city;
		$data_latlon = $arr->loc;

		$seKeyForm = STRKEY.$this->session->tempdata('keyform');
		$usuario = $this->input->post('usuario');
		$password = $this->input->post('pass');
		$keyForm = STRKEY.$this->input->post('keyform');

		$datos = array('estado'=>'2','msj'=>'El token a caducado o no es el correcto, vuelva a intentarlo:.','error'=>'Token errado','datos'=>'','redirec'=>base_url());
		
		if($keyForm == $seKeyForm){
			
			$arrUsuario = $this->usuario->get_login($usuario,$password);
			//var_dump($arrUsuario); die;

			if($arrUsuario){
				$nmUsu = $arrUsuario['nombres'];
				$swUsu = ON; 
				$psUsu = $arrUsuario['ps'];
				//unset($arrUsuario['sw']); 
				unset($arrUsuario['ps']);

				if($swUsu == OFF){

					$msg = 'El usuario '.$usuario.' esta intentando acceder a su cuenta sin activar su cuenta de usuario desde el correo, brindar soporte oportunamente.';
					$this->email_infosoporte($nmUsu, $usuario, $data_latlon, $data_pais, $data_ciudad, $data_ip, $msg);

					$datos = array(
								'estado'=>'3', 
								'msj'=>'Su usuario aun no ha sido <u>activado</u>. También nos puede contactar a través del <strong>WhatsApp al Nro. +56 930173871</strong>',
								'error'=> '',
								'redirec'=> base_url('comprar')
								);

				}else if($psUsu == $password){
					$this->session->set_userdata('apc_usuario',$arrUsuario);
					$usuario_id = $arrUsuario['id'];
					$post['id'] = $usuario_id;
					$post['ip'] = $data_ip;
					$post['pais'] = $data_pais;
					$post['ciudad'] = $data_ciudad;
					$post['latlon'] = $data_latlon;
					$rs = $this->usuario->insert($post);

					$arrLog = array();
					$arrLog['id'] = '';
					$arrLog['usuario_id'] = $usuario_id;
					$arrLog['fecha'] = date('Y-m-d');
					$arrLog['hora'] = date('H:i:s');
					$arrLog['ip'] = $data_ip;
					$arrLog['pais'] = $data_pais;
					$arrLog['ciudad'] = $data_ciudad;
					$arrLog['latlon'] = $data_latlon;
					$this->usuario->insertlog($arrLog);

					$datos = array(
								'estado'=>'1', 
								'msj'=>'Usuario validado satisfactoriamente.',
								'error'=> '',
								'redirec'=> base_url('comprar')
								);
				}else{
					$datos = array(
								'estado'=>'4', 
								'msj'=>'El password es incorrecto puede volver a intentarlo: <a href="'.base_url('usuario/login').'">CLICK AQUÍ</a>.',
								'error'=> '',
								'redirec'=> base_url('comprar')
								);
				}
			}else{
				$datos = array(
							'estado'=>'2', 
							'msj'=>'Usuario no encontrado, verifique el Email ingresado vuelva a intentarlo: <a href="'.base_url('usuario/login').'">CLICK AQUÍ</a>.',
							'error'=> 'Error en validación de datos',
							'redirec'=> ''
							);
			}

		}else{
			$datos = array(
							'estado'=>'0', 
							'msj'=>'El token a caducado o no es el correcto, vuelva a intentarlo: <a href="'.base_url('usuario/login').'">CLICK AQUÍ</a>.',
							'error'=> 'Token errado',
							'redirec'=> base_url()
							);
		} // fin if keycart

		echo json_encode($datos, JSON_FORCE_OBJECT | JSON_HEX_TAG | JSON_HEX_APOS);
		//$seKeyForm = STRKEY.$this->session->tempdata('keyform');
	}

	public function logout(){
		$this->load->helper('cookie');

		$this->session->unset_userdata('id');
		$this->session->unset_userdata('nombres');
		$this->session->unset_userdata('usuario');
		
		$this->session->sess_destroy();

		$this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
		$this->output->set_header('Pragma: no-cache');

		delete_cookie("ci_session");

		$url = base_url();
		header('Location: '.$url);
	}

	
}
