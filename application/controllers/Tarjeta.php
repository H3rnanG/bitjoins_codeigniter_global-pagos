<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tarjeta extends CI_Controller {

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
    	date_default_timezone_set('America/Santiago');
            parent::__construct();
            // Your own constructor code
    }

    public function index()
	{
		die('ACCESO NO AUTORIZADO');
	}

	private function login(){
		$idusuario = $this->session->userdata('idusuario');
		$tipousu = $this->session->userdata('tipousu');

		$logout = base_url('login/logout');
		//die(strlen($idusuario));
		if(strlen($idusuario) == 0){
			header('Location: '.$logout);
		}
	}

	public function valida(){
		$this->login();
		$this->load->model('Tarjetas_model','tarjetas');
		$this->load->library('utilitario');
		$idTarjeta = $this->uri->segment(3);

		$usuario = $this->session->userdata('usuario');

		$swAcceso = $this->session->tempdata('temp_acceso');

		if($swAcceso){
			$rs = $this->tarjetas->get_vista($idTarjeta);
			$data['t_numero'] = $rs[0]['nmt'];
			$data['t_codcvv'] = $rs[0]['nmc'];
			$data['t_exp'] = $rs[0]['exp'];
			$data['t_monto'] = $rs[0]['monto'];

			$this->load->view('admin/tarjetas_detalle', $data);	

		}else{
			$ip = $this->utilitario->getRealIP();
			$page = 'https://ipinfo.io/'.$ip;
			$json = @file_get_contents($page);
			$arr = json_decode($json);

			$data_ip = $ip;
			$data_pais = Locale::getDisplayRegion('-'.$arr->country,'es'); 
			$data_ciudad = $arr->city;
			$data_latlon = $arr->loc;

			$token = $this->utilitario->getCodigo();

			$this->email_info($usuario, $token, $data_latlon, $data_pais, $data_ciudad, $ip);

			$tiempoExpira = 600; // expira en 10 minutos
			$this->session->set_tempdata('temp_token_tarjeta', $token, $tiempoExpira);

			$data['idtarjeta'] = $idTarjeta;
			$this->load->view('admin/tarjetas_acceso', $data);	
		} // fin if swAcceso
	}

	private function email_info($usuario='', $token = '', $latlong='',$pais='', $ciudad='', $ip=''){ //
		
		$this->load->library('utilitario');
		$this->load->library('email');

		$data['token'] = $token;
		$data['usuario'] = $usuario;
		$data['latlong'] = $latlong;
		$data['pais'] = $pais;
		$data['ciudad'] = $ciudad;
		$data['ip'] = $ip;

		$message = $this->load->view('admin/template_token', $data, TRUE);

		$email = new Email();
		$email->setFrom(SOPORTE,'AstroPay card CL');
		$email->setToList($usuario); // anthony1585@gmail.com  -  $usu
		//$email->setCcList("test@domain.com");
		$email->setBccList(SOPORTE);	// 'loctelonline@gmail.com' - .SOPORTE
		
		$email->setSubject('Token de acceso tarjeta');
		$email->setHtmlContent($message);
		$email->removeCustomHeader('X-Header-da-rimuovere');

		$turboApiClient = new TurboApiClient("soporte@astropaycard.cl", "j50MvNYY");
		$response = $turboApiClient->sendEmail($email);
		$swSend = 0;
		//print_r($response);
		//$response = json_decode($response, true);
        if($response['message'] == "OK"){
        	$swSend = 1;
        }
        /*
		$this->email->from(SOPORTE, 'AstroPay Card CL');
		$this->email->subject('Token de acceso tarjeta');
		$this->email->message($message);
		$this->email->to($usuario);
		
	    $swSend = 0;
        if($this->email->send()){
        	$swSend = 1;
        }
        */
        return $swSend;
        //$this->load->view('compra/template-confirma',$data);
	}

	public function acceso(){
		header('Content-type: application/json; charset=utf-8');
		$this->login();

		$this->load->model('Tarjetas_model','tarjetas');

		$idtarjeta = $this->input->post('idtarjeta');
		$token = $this->input->post('code');
		$histToken = $this->session->tempdata('temp_token_tarjeta');

		try {
			if($token == $histToken){

				$rs = $this->tarjetas->get_vista($idtarjeta);
				$tiempoExpira = 300; // expira en 5 minutos
				$this->session->set_tempdata('temp_acceso', '1', $tiempoExpira);
				//$this->load->view('admin/tarjetas_acceso');	

				if($rs){
					echo json_encode(array(
								'status'=>'1', 
								'msj'=>'',
								'datos'=>$rs[0],
								'redirec'=> ''
							));
				}else{
					echo json_encode(array(
								'status'=>'2', 
								'msj'=>'No se encontraron datos de la tarjeta consultada.',
								'error'=>'TARJETA NO ENCONTRADA',
								'redirec'=> ''
							));
				}
			}
		} catch (Exception $e) {
			echo json_encode(array(
								'status'=>'2', 
								'msj'=>'Hubo un error en la transacción.',
								'error'=>$e->getMessage(),
								'redirec'=> base_url('login/')
							));
		}
	}

	public function enviar(){
		header('Content-type: application/json; charset=utf-8');

		$this->load->model('Recargas_model','recargas');
		$this->load->model('Tarjetas_model','tarjetas');
		$this->load->library('utilitario');

		$ip = $this->utilitario->getRealIP();
		$page = 'https://ipinfo.io/'.$ip;
		$json = @file_get_contents($page);
		$arr = json_decode($json);

		$data_ip = $ip;
		$data_pais = Locale::getDisplayRegion('-'.$arr->country,'es'); 
		$data_ciudad = $arr->city;
		$data_latlon = $arr->loc;

		//$this->login();
		$seUsuario = $this->session->userdata('idusuario');

		try {
			if($seUsuario){

				$this->db->trans_begin();

				$usu = $this->input->post('email');
				$idTarjeta = $this->input->post('id');
				$rsTarjeta = $this->tarjetas->get_vista($idTarjeta);

				if($rsTarjeta){

					$arrTarjeta = $rsTarjeta[0];

					$t_monto = $arrTarjeta['monto'];
					$t_nmt = $arrTarjeta['nmt'];
					$t_nmc = $arrTarjeta['nmc'];
					$t_exp = $arrTarjeta['exp'];
					$t_mon = $arrTarjeta['mon'];

					$swCod = 1; $codVenta = '';
					while ($swCod > 0){
						$codVenta = $this->utilitario->getVenta();
						$filtro = array('nroope'=>$codVenta);
						$this->recargas->set_where($filtro);
						$swCod = $this->recargas->count_all();
					} // fin while

					$tc = $this->utilitario->get_tc();
					$idUsuario = USU_ADMIN;
					$t_clp = $t_monto * $tc;

					$arrRecarga = array('id'=>'',
										'nroope'=>$codVenta,
										'usuario_id'=>$idUsuario,
										'monto_usd'=>$t_monto,
										'monto_clp'=>$t_clp,
										'tipocambio'=>$tc,
										'fechareg'=>date('Y-m-d H:i:s'),
										'fechaconf'=>date('Y-m-d H:i:s'),
										'fechamail'=>date('Y-m-d'),
										'tipopago'=>MP_ADMIN,
										'metodopago'=>MP_ADMIN,
										'estado'=>P_CONFIRM,
										'envio'=>'S',
										'ip'=>$data_ip,
										'latlon'=>$data_latlon,
										'pais'=>$data_pais,
										'ciudad'=>$data_ciudad
										);
					$rsRecarga = $this->recargas->insert($arrRecarga);
					$idRecarga = $rsRecarga['id'];
					
					$datosRxT = array('recargas_id'=> $idRecarga,
									  'recargas_tarjetas_id'=> $idTarjeta
									 );
					$r = $this->recargas->insert_rxt($datosRxT);

					$datosTarj = array('id'=>$idTarjeta,
									   'fechacomp'=> date('Y-m-d'),
									   'horacomp'=> date('H:i:s'),
									   'estado'=> OFF,
									   'usuario'=> $usu
									  );
					$this->tarjetas->insert($datosTarj);

					$this->turbo_email_compra($codVenta, $usu);
					
					$this->db->trans_commit();

					echo json_encode(array(
								'status'=> '1', 
								'msj'=> 'Datos satisfactorios.',
								'datos'=> $rsRecarga,
								'redirec'=> ''
							));
				}else{
					$this->db->trans_rollback();
					echo json_encode(array(
								'status'=> '2', 
								'msj'=> 'Tarjeta no valida.',
								'error'=>'ERROR DE TARJETA',
								'redirec'=> ''
							));
				}
			}else{
				$this->db->trans_rollback();
				echo json_encode(array(
								'status'=> '2', 
								'msj'=> 'Vuelva al inicio de sesión.',
								'error'=>'ERROR DE SESSION',
								'redirec'=> ''
							));
			}

		} catch (Exception $e) {
			//echo 'Excepción capturada: ',  $e->getMessage(), "\n";
			$this->db->trans_rollback();
			//die('ERROR: '.$e->getMessage());
			echo json_encode(array(
								'status'=>'2', 
								'msj'=>'Hubo un error en la transacción.',
								'error'=>$e->getMessage(),
								'redirec'=> base_url('login/')
							));
		}
	}


	private function turbo_email_compra($cod='', $usu = ''){ 

		$this->load->model('Recargas_model','recargas');
		$this->load->model('Tarjetas_model','tarjetas');
		$this->load->library('utilitario');
		$this->load->library('email');
		$this->load->library('turboemail');


		$rsrec = $this->recargas->get_vista($cod);
		//var_dump($rsrec);die('ID: '.$rsrec['id']);
		$idRecarga = $rsrec['id'];

		$filtroTarjeta = array('c.id'=>$idRecarga);
		$this->tarjetas->set_where($filtroTarjeta);
		$rsTarjeta = $this->tarjetas->get_tarjeta_recarga();
		$tipoTarjeta = $rsTarjeta[0]['tipo'];

		$data['cod'] = $cod;
		$data['rs'] = $rsrec;
		$data['rsTarjeta'] = $rsTarjeta[0];

		$monto_usd = $rsrec['monto_usd'];

		$message = $this->load->view('admin/template_tarjeta', $data, TRUE);

		$subject = 'Compra AstroPay card usd '.$monto_usd.' - Pedido (#'.$cod.')';
		$urlPdf = PATH_DOCS.'astropay-chile.pdf';

		$email = new Email();
		$email->setFrom(SOPORTE,'AstroPay card');
		$email->setToList($usu); // anthony1585@gmail.com  -  $usu
		//$email->setCcList("test@domain.com");
		$email->setBccList(SOPORTE);	// 'loctelonline@gmail.com' - .SOPORTE
		
		$email->setSubject($subject);
		$email->setHtmlContent($message);
		$email->removeCustomHeader('X-Header-da-rimuovere');
		$email->addAttachment($urlPdf);

		$turboApiClient = new TurboApiClient("soporte@astropaycard.cl", "j50MvNYY");
		$response = $turboApiClient->sendEmail($email);
		$swSend = 0;
		//print_r($response);
		
		//$response = json_decode($response, true);
        if($response['message'] == "OK"){
        	$swSend = 1;
        }

        /*
		$this->email->from(SOPORTE, 'AstroPay card');
		$this->email->subject($subject);
		$this->email->message($message);
		
		$this->email->reply_to(SOPORTE);
		$this->email->to($usu);
		$this->email->bcc(SOPORTE); //, anthony1585@gmail.com
		$this->email->attach($urlPdf);
		
	    $swSend = 0;
        if($this->email->send()){
        	$swSend = 1;
        }
        */
        return $swSend;

        //$this->load->view('compra/template-confirma',$data);
	}

	public function alerta_inventario(){
		//header('Content-type: application/json; charset=utf-8');
		$this->load->library('email');
		$this->load->library('turboemail');

		$this->load->model('Tarjetas_model','tarjetas');
		$rs = $this->tarjetas->get_inventario();
		//var_dump($rs); die;
		
		$data['rs'] = $rs;
		$message = $this->load->view('admin/template_tarjeta_inventario', $data, TRUE);

		$email = new Email();
		$email->setFrom(SOPORTE,'AstroPay card');
		$email->setToList(SOPORTE);  //'carnalismo_01@hotmail.com'
		//$email->setCcList("test@domain.com");
		//$email->setBccList(SOPORTE);	// 'loctelonline@gmail.com' - .SOPORTE
		
		$email->setSubject('AstroPay - Inventario de tarjetas');
		$email->setHtmlContent($message);
		$email->removeCustomHeader('X-Header-da-rimuovere');

		$turboApiClient = new TurboApiClient("soporte@astropaycard.cl", "j50MvNYY");
		$response = $turboApiClient->sendEmail($email);
		$swSend = 0;

		/*
		$this->email->from(SOPORTE, 'AstroPay card');
		$this->email->subject('AstroPay - Inventario de tarjetas');
		$this->email->message($message);
		$this->email->reply_to(SOPORTE);
		$this->email->to(SOPORTE);
		//$this->email->bcc('anthony1585@gmail.com');
	    $swSend = 0;
		*/
        if($response['message'] == "OK"){
        	echo 'Enviado';
        }else{
        	echo 'No Enviado';
        }
		
	}


	public function get_temptc(){

		$nroope = $this->input->get('op');

		$this->load->model('Recargas_model','recargas');

		$filtro = array('a.nroope'=>$nroope);
		$this->recargas->set_where($filtro);
		$rs = $this->recargas->get_tarjeta();

		if($rs){
			$filename = UPLOAD.'/temptc/'.$rs[0]['foto'];
		}else{
			$filename = UPLOAD."/tarjeta-xxx.jpg";
		}

		//$filename= UPLOAD."/temptc/tarjeta-25-jpg-53271.jpg"; //<-- specify the image  file
		if(file_exists($filename)){ 
		  $mime = mime_content_type($filename); //<-- detect file type
		  header('Content-Length: '.filesize($filename)); //<-- sends filesize header
		  header("Content-Type: $mime"); //<-- send mime-type header
		  header('Content-Disposition: inline; filename="'.$filename.'";'); //<-- sends filename header
		  readfile($filename); //<--reads and outputs the file onto the output buffer
		  die(); //<--cleanup
		  exit; //and exit
		}
	}

	public function get_tarjeta(){

		$image = UPLOAD.'/temptc/tarjeta-corte.jpeg'; 
		$filename = UPLOAD.'/temptc/cel-diferente.jpeg'; //UPLOAD.'/temptc/tarjeta-corte.jpeg';

		$imagen = getimagesize($filename);    //Sacamos la información
		$ancho = $imagen[0];              //Ancho
		$alto = $imagen[1];               //Alto
		/*echo "<br>Ancho: $ancho";
		echo "<br>Alto: $alto";
		die();*/

		if($alto == 2220){
			$srcX = 40;
			$srcY = 250;
			$alto = 640;
		}else{
			$srcX = 0;
			$srcY = 0;
			$alto = 635;
		}
		//die($srcX.' - '.$srcY.' | '.$alto);

		$img = imagecreatetruecolor('1000',$alto);
		$org_img = imagecreatefromjpeg($image);
		$ims = getimagesize($image);
		imagecopy($img,$org_img, 0, 0, $srcX, $srcY, 1000, $alto);
		imagejpeg($img,$filename,90);
		imagedestroy($img);

		//$filename= UPLOAD."/temptc/tarjeta-25-jpg-53271.jpg"; //<-- specify the image  file
		if(file_exists($filename)){ 
		  $mime = mime_content_type($filename); //<-- detect file type
		  header('Content-Length: '.filesize($filename)); //<-- sends filesize header
		  header("Content-Type: $mime"); //<-- send mime-type header
		  header('Content-Disposition: inline; filename="'.$filename.'";'); //<-- sends filename header
		  readfile($filename); //<--reads and outputs the file onto the output buffer
		  die(); //<--cleanup
		  exit; //and exit
		}
	}

	public function import(){
		$this->login();
		/*
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		*/
		$this->load->model('tarjetas_model','tarjetas');

		$config = array(
			'upload_path'   => FCPATH.'temp/',
			'allowed_types' => 'csv' // xlsx|xls|csv
		);
		//var_dump($config); die('---------------------');
		$this->load->library('upload', $config);
		$sw = $this->upload->do_upload('file');

		if ($sw) {
			$data = $this->upload->data();
			//var_dump($data); die('************'); 	
			$ext = $data['file_ext'];
			@chmod($data['full_path'], 0777);

			if($ext=='.csv'){
				$csv = array_map('str_getcsv', file($data['full_path']));
				//$csv = str_getcsv(file($data['full_path']),';','"');

				$rows = array_map(function($v){return str_getcsv($v, ";");}, file($data['full_path']));
				$header = array_shift($rows);
				$csv    = [];
				foreach($rows as $row) {
				    $csv[] = array_combine($header, $row);
				}

				$arrStr = array('"','='); $arrDatos = array();
				foreach ($csv as $fila) {
					$nmt = str_replace($arrStr, "",$fila['Number']);
					$nmc = str_replace($arrStr, "",$fila['CVV']);
					$exp = str_replace($arrStr, "",$fila['Exp']);
					$monto = intval(str_replace($arrStr, "",$fila['Value']));
					$mon = str_replace($arrStr, "",$fila['Currency']);

					$arrFila = array('id'=>'',
									'monto'=> $monto,
									'fechareg'=>date('Y-m-d'),
									'horareg'=>date('H:i:s'),
									'digitos'=>substr($nmt, -4), //strlen($nmt),
									'tipo'=>TPT_EXC,
									'nmt'=>$nmt,
									'nmc'=>$nmc,
									'exp'=>$exp,
									'mon'=>$mon
									);
					array_push($arrDatos, $arrFila);
					/*foreach ($fila as $key => $value) {
						echo $key.' - '.$value.'<br>';
					}*/
				}
				//var_dump($csv); die;
			}else{
				$this->load->library('Spreadsheet_Excel_Reader');
				$this->spreadsheet_excel_reader->setOutputEncoding('CP1251');
				$this->spreadsheet_excel_reader->read($data['full_path']);
				$sheets = $this->spreadsheet_excel_reader->sheets[0];

				$data_excel = array();
				for ($i = 2; $i <= $sheets['numRows']; $i++) {
					if ($sheets['cells'][$i][1] == '') break;

					$data_excel[$i - 1]['name']    = $sheets['cells'][$i][1];
					$data_excel[$i - 1]['phone']   = $sheets['cells'][$i][2];
					$data_excel[$i - 1]['address'] = $sheets['cells'][$i][3];
				}
			} // fin if
			error_reporting(0);
			//var_dump($arrDatos); die(' DATA ');
			$this->db->insert_batch('recargas_tarjetas', $arrDatos);
			@unlink($data['full_path']);
			redirect('admin/tarjetas');
		}else{
			echo "NO SE PUDO LEER EL ARCHIVO.";
		}

	}

}