<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testkp extends CI_Controller {

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

	public function test(){
		die(dirname($_SERVER["SCRIPT_FILENAME"])."/assets/upload/");
	}

	public function index()
	{	

		$receiverId = '300604';
		$secretKey = 'c5b48749c913c1efc1652089487318b1f632037e';

		$c = new Khipu\Configuration();
		$c->setSecret($secretKey);
		$c->setReceiverId($receiverId);
		//$c->setDebug(true);
		$cl = new Khipu\ApiClient($c);
		//$exp = new DateTime();
		//$exp->setDate(2020, 20, 4);

		$kh = new Khipu\Client\PaymentsApi($cl);

		try {
		    $opts = array(
		    	//"expires_date" => $exp,
		    	"transaction_id" => rand(0,999999),
		    	"return_url" => base_url('testkp/return'),
		    	"cancel_url" => base_url('testkp/cancel'),
		    	"picture_url"=> base_url('/assets/images/logo-astropay-chile.png'),
		    	//"notify_api_version"=> "2.7",
		    	//"body" => "test body"
		    );
		    $resp = $kh->paymentsPost("Compra de prueba API", "CLP", 200, $opts);
		    //print_r($resp);
		    $r2 = $kh->paymentsIdGet($resp->getPaymentId());
		    echo "Success<br>".$r2['payment_id'].' / '.$r2['payment_url'];
		    //echo $r2->payment_id." - ".$r2->payment_url;
		    foreach ($r2 as $key => $f) {
		    	//var_dump($f);
		    	echo $key.'-> '.$f['payment_id'].'<br>';
		    }
		    //var_dump($r2);

		} catch(Exception $e) {
			echo "Error<br>";
		    echo $e->getMessage();
		}
	}

	public function formatearcel(){
		$this->load->library('utilitario');
		$nro = '51980456099';
		$nro = $this->utilitario->formatCelular($nro);
		echo $nro;
	}

	public function payidtest(){

		/*
		$datetime1 = date_create(date('Y-m-d H:i:s'));
	    $datetime2 = date_create('2020-06-25 18:35:00');
	   
	    $interval = date_diff($datetime1, $datetime2);
	    $r = $interval->format('%i');
	    echo $r;
		die(' --- '.date('Y-m-d H:i:s').' - '.'2020-06-25 18:35:00');
		*/
		header('Content-type: application/json; charset=utf-8');
		$c = new Khipu\Configuration();
		$c->setSecret(SECRETKEY);
		$c->setReceiverId(RECEIVERID);
		//$c->setDebug(true);
		$cl = new Khipu\ApiClient($c);
		$kh = new Khipu\Client\PaymentsApi($cl);

		$apc_payment_id = 'jxllkizjany0'; //'owls9cfwnnfs';  'o1igaq4qsyhx';
		$response = $kh->paymentsIdGet($apc_payment_id);

		//echo json_encode($response);

		var_dump($response);

	}

	public function testpendientes(){
		header('Content-type: application/json; charset=utf-8');
		$this->load->model('Recargas_model','recargas');
		$rs = $this->recargas->get_pendientes();
		echo json_encode($rs);
	}

	private function mailtesting(){
		$apc_codventa = 'EX5813';
		$usu = 'anthony1585@gmail.com';
		$r = $this->turbo_email_compra($apc_codventa, $usu, MP_KHIPU, ON, ON);
		die('ENVIO: '.$r);
	}


	private function phpmailertest(){

		$this->load->library('turboemail');

		$email = new Email();
		$email->setFrom(SOPORTE,'Astropay Card CL');
		$email->setToList("anthony.alvarez@bitjoins.pe"); // anthony1585@gmail.com
		//$email->setCcList("dd@domain.com,ee@domain.com");
		//$email->setBccList("ffi@domain.com,rr@domain.com");	
		$email->setSubject("AstroPay Card - Confirmación de Compra #4556546 - ".date('Y-m-d H:i:s'));
		//$email->setContent("content");
		$email->setHtmlContent('<html><body> <h2 style="color:red;">TESTING TURBO EMAIL</h2> <p style="color:blue;">LLego OK</p> </body></html>');
		/*
		$email->addCustomHeader('X-FirstHeader', "value");
		$email->addCustomHeader('X-SecondHeader', "value");
		$email->addCustomHeader('X-Header-da-rimuovere', 'value');*/
		$email->removeCustomHeader('X-Header-da-rimuovere');		
		//$email->addAttachment('./files/turbosmtp.png');

		$turboApiClient = new TurboApiClient("soporte@astropaycard.cl", "j50MvNYY");
		$response = $turboApiClient->sendEmail($email);
		var_dump($response);


		/*
        $this->load->library('email');
		//$mail = new PHPMailer(true);  // Passing `true` enables exceptions

        $config['protocol'] = 'smtp';
		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;

		$config['smtp_host'] = 'pro.turbo-smtp.com';
		$config['smtp_user'] = 'soporte@astropaycard.cl';
		$config['smtp_pass'] = 'j50MvNYY';
		$config['smtp_port'] = '25';
		//$config['smtp_crypto'] = 'ssl';
		$config['priority'] = '5';
		$config['mailtype'] = 'html';

		$this->email->initialize($config);

		$message = '<html><body> <h2>TESTING TURBO EMAIL</h2> <p style="color:blue;">LLego OK</p> </body></html>';

		$this->email->from(SOPORTE, 'AstroPay Card CL');
		$this->email->subject('AstroPay Card - Confirmación de Compra #232323');
		$this->email->message($message);
		
		$this->email->reply_to('soporte@astroypaycard.cl');
		$this->email->to('anthony.alvarez@vgperu.pe, anthony.alvarez@bitjoins.pe'); //SOPORTE

		$result = $this->email->send();

		var_dump($result);
		echo '<br />';
		echo $this->email->print_debugger();
		*/
		
	}

	public function conversor(){
	 /* conversor_divisas()
	 *
	 * Conversor de moneda usando la API de Google
	 */
		echo $this->currency('USD', 'CLP', 1);
	}

	public function return(){
		$post = $this->input->post();
		var_dump($post);
	}

	public function cancel(){
		$post = $this->input->post();
		var_dump($post);
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
		
		$this->email->to('soporte@astropaycard.cl', 'Soporte');
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


	public function tc(){

		$ur = "http://www.sunat.gob.pe/cl-at-ittipcam/tcS01Alias" ;
 
		$file = fopen($ur,"r");
		 
		$n=0 ; $dt = array(10); $acum=""; //variable de control de lineas
		 
		$mes=''; $tc = '0.00';
		while (!feof($file)) {     //captura de encabezados
		 
		  	$fila = fgets($file) ; //captura de linea
		  	$dato = str_replace('<br>', '', $fila);
			$dato = trim($dato);
			//echo '>>>> '.$dato.' <<<<< <br>';
		 	
		  	$dt[$n]=$fila ;
		 
			/*if($n==56)  { $mes=trim($fila); $mes=str_replace('<h3>', '', $mes); $mes=str_replace('</h3>', '', $mes);}
			if($n==137) { echo trim($mes).' Día '.$fila;}
			if($n==141) { echo 'Compra '.$fila;}
			if($n==145) { echo 'Venta '.$fila;}
			*/
			//echo $fila;
			if($dato == 'Notas:'){
				//echo '<<< '.$fila.' >>>>>>';
				break;
			}else{
				if(strlen($dato) > 0){
					$dato = $dato; //floatval($dato);
					if($dato > 0){
						$tc = $dato;	
					}
				}
				
			}

			$n++; 
		}
		
		if($tc > 0){
			$this->db->where('id',TC);
			$this->db->update('constantes',array('variable'=>$tc, 'fechaact' =>date('Y-m-d'), 'horaact' => date('H:i:s')));
		}
		echo $tc;	 
			fclose($file) ;

			//var_dump($dt);
	}

	
}
