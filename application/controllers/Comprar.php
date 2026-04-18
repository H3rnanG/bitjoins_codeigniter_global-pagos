<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comprar extends CI_Controller {

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

    public function tcomp(){
    	
    	$data['apc_codventa'] = 'KP8975';
    	$seusu = $this->session->userdata('apc_usuario');

    	$head['pag_title'] = 'Compra - AstroPay Card';
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

    	$this->load->view('compra/confirmacion_tarjeta',$data);
    }

	public function index()
	{
		$this->load->model('tarjetas_model','tarjetas');
		$this->load->library('utilitario');

		$head['pag_title'] = 'Compra - AstroPay Card';
		$head['pag_description'] = 'AstroPay Card';
		$head['pag_keywords'] = '';

		$seUsuario = $this->session->userdata('apc_usuario');
		//var_dump($seUsuario); die;
		
		if($seUsuario){
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

			$tc = $this->utilitario->get_tc();
			$data['tc'] = $tc;
			$hora = date('G');

			$swTkn = $seusu['sw'];
			if($swTkn == TKN){
				$data['celular'] = $seUsuario['celular'];
				$this->load->view('compra/compra_token',$data);
			}else{
				if($hora >= 1 && $hora <= 7){
					$rsTarjetas = $this->tarjetas->get_inventario();
					$data['rsTarjetas'] = $rsTarjetas;
					$this->load->view('compra/compra_tarjetas',$data);
				}else{
					$this->load->view('compra/compra',$data);
				}
			}
			
		}else{
			header('Location: '.base_url('usuario/login'));
		}
	}

	public function get_tc(){
		header('Content-type: application/json; charset=utf-8');
		$seUsuario = $this->session->userdata('apc_usuario');
		$this->load->library('utilitario');

		try {
			if($seUsuario){
				$tc = $this->utilitario->get_tc();
				echo json_encode(array(
								'status'=> '1', 
								'msj'=> 'Datos satisfactorios.',
								'datos'=> $tc,
								'redirec'=> ''
							));
			}else{
				echo json_encode(array(
								'status'=> '2', 
								'msj'=> 'Vuelva al inicio de sesión.',
								'error'=>'ERROR DE SESSION',
								'redirec'=> ''
							));
			}

		} catch (Exception $e) {
			//echo 'Excepción capturada: ',  $e->getMessage(), "\n";
			//$this->db->trans_rollback();
			//die('ERROR: '.$e->getMessage());
			echo json_encode(array(
								'status'=>'2', 
								'msj'=>'Hubo un error en la transacción.',
								'error'=>$e->getMessage(),
								'redirec'=> base_url('comprar/error')
							));
		}

	}

	public function grbcompra(){
		header('Content-type: application/json; charset=utf-8');
		$this->load->model('Recargas_model','recargas');

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
		$seUsuario = $this->session->userdata('apc_usuario');
		$nroRec = $seUsuario['nrorec'];

		$post = $this->input->post();

		$this->session->set_userdata('apc_idrecarga','');
		$this->session->set_userdata('apc_codventa','');
		$this->session->set_userdata('apc_payment_id','');
		$this->session->set_userdata('apc_payment_it','0');
		$this->session->set_userdata('apc_monto',$post['monto_usd']);

		$datos = array('estado'=>'2','msj'=>'No se realizo ninguna operación.','error'=>'vacio','datos'=>'','redirec'=>base_url());

		try {
			
			if($seUsuario){

				$this->db->trans_begin();

				if(array_key_exists('keyform', $post)){
					$keyForm = STRKEY.$post['keyform'];
					$post['id'] = '';
					unset($post['keyform']);
					$post['usuario_id'] = $seUsuario['id'];

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
							
							$codVenta = $this->utilitario->getVenta(); //$letter.$rand;
							$post['nroope'] = $codVenta;
							$post['fechareg'] = DATE('Y-m-d H:i:s');

							$usu = $seUsuario['usuario'];
							$nmUsu = $seUsuario['nombres'];

							$metodopago = $post['metodopago'];
							$t_estado = P_PENDING;

							$mntDolares = $post['monto_usd'];
							if($mntDolares <= 25){
								$t_servcambio = COMISION_AP * $post['tipocambio'];
							}else{
								$t_servcambio = 0;
							}

							$payment_id = ''; $msj = '';
							$url_redirect = '';

							if($metodopago == MP_BANCHILE){
								$t_estado = P_CONFIRM;
								$lbl_emp = 'AstroPay';
								$t_comision = 0;
								$totalOperacion = $post['monto_clp'] + $t_comision + $t_servcambio;
								$url_redirect = base_url('usuario/completa');
								$msj = 'Sus datos fueron recibidos, se le enviara instrucciones a su correo para confirmar la compra.';
							}else{
								$lbl_emp = 'Khipu';
								$t_comision = COMISION_KP; 

								$c = new Khipu\Configuration();
								$c->setSecret(SECRETKEY);
								$c->setReceiverId(RECEIVERID);
								//$c->setDebug(true);
								$cl = new Khipu\ApiClient($c);
								$kh = new Khipu\Client\PaymentsApi($cl);

								$opts = array(
							    	//"expires_date" => $exp,
							    	"transaction_id" => $codVenta,
							    	"return_url" => base_url('comprar/return'),
							    	"cancel_url" => base_url('comprar/cancel'),
							    	"picture_url"=> base_url('/assets/images/logo-astropay-chile.png'),
        							//"notify_url" => base_url('comprar/notify'),
        							//"notify_api_version" => "1.3"
							    );
							    $monto_clp = $post['monto_clp'];
							    $monto_usd = $post['monto_usd'];
							    $totalOperacion = $post['monto_clp'] + COMISION_KP + $t_servcambio;
							    $resp = $kh->paymentsPost("Compra de tarjeta", MONEDA, $totalOperacion, $opts);
							    $r2 = $kh->paymentsIdGet($resp->getPaymentId());
							    $msj = 'Sus datos fueron registrados, debe confirmar la compra realizando el pago.';

							    $url_redirect = $r2['payment_url'];
							    $payment_id = trim($r2['payment_id']);

							    if(strlen($payment_id)){
							    	$post['payment_id'] = $payment_id;
							    	$post['payment_url'] = $url_redirect;
							    	$post['fechaconf'] = date('Y-m-d H:i:s');
							    	$this->session->set_userdata('apc_payment_id',$payment_id);
							    }else{
							    	$msj = 'Hubo un ERROR, no se pudo registrar la operación con KHIPU.';
							    }
							}
							
							$post['estado'] = $t_estado;
							
							$post['ip'] = $data_ip;
							$post['latlon'] = $data_latlon;
							$post['pais'] = $data_pais;
							$post['ciudad'] = $data_ciudad;

							$rs = $this->recargas->insert($post);
							$rsrec = $this->recargas->get_vista($codVenta);

							$post['empresa'] = $lbl_emp;
							$post['comision'] = $t_comision;
							$post['servcambio'] = $t_servcambio;
							$post['totaloperacion'] = $totalOperacion;

							if($t_estado == P_CONFIRM){
								$msg = 'El usuario '.$usu.' realizo una compra.';
								$this->email_infosoporte($nmUsu, $usu, $data_latlon, $data_pais, $data_ciudad, $data_ip, $msg);
								$this->turbo_email_compra($codVenta, $usu, MP_BANCHILE, 0, $nroRec);
							}else{
								$idrecarga = $rs['id'];
								$this->session->set_userdata('apc_idrecarga',$idrecarga);
								$this->session->set_userdata('apc_codventa',$codVenta);
							}

							$datos = array(
										'estado'=>$t_estado, 
										'msj'=>$msj,
										'error'=> '0',
										'redirec'=> $url_redirect,
										'datos'=>$post
									);	
						}
					}else{
						$datos = array(
										'estado'=>P_CANCEL, 
										'msj'=>'El token a caducado o no es el correcto, debe volver a realizar el registro <a href="'.base_url('comprar').'">CLICK AQUÍ</a>.',
										'error'=> 'Token errado',
										'redirec'=> base_url()
										);
					} // fin if keycart
				} // if key_exists keyform
				$this->db->trans_commit();
			} // fin if seUsuario

			echo json_encode($datos);

		} catch (Exception $e) {
			//echo 'Excepción capturada: ',  $e->getMessage(), "\n";
			$this->db->trans_rollback();
			//die('ERROR: '.$e->getMessage());
			echo json_encode(array(
								'status'=>'2', 
								'msj'=>'Hubo un error en la transacción.',
								'error'=>$e->getMessage(),
								'redirec'=> base_url('comprar/error')
							));
		}
	}

	

	public function return(){
		$this->load->model('Recargas_model','recargas');
		$this->load->model('Tarjetas_model','tarjetas');
		//$notification_token = $this->input->post_get('notification_token');
		//echo "TOKEN: "; die($notification_token);

		$this->load->library('utilitario');
		$ip = $this->utilitario->getRealIP();
		$page = 'https://ipinfo.io/'.$ip;
		$json = @file_get_contents($page);
		$arr = json_decode($json);

		$data_ip = $ip;
		$data_pais = Locale::getDisplayRegion('-'.$arr->country,'es'); 
		$data_ciudad = $arr->city;
		$data_latlon = $arr->loc;

		$head['pag_title'] = 'Compra Aprobación - AstroPay Card';
		$head['pag_description'] = 'AstroPay Card';
		$head['pag_keywords'] = '';

		$seUsuario = $this->session->userdata('apc_usuario');

		try {
			if($seUsuario){
				$usu = $seUsuario['usuario'];
				$nmUsu = $seUsuario['nombres'];
				$nroRec = $seUsuario['nrorec'];

				$apc_idrecarga = $this->session->userdata('apc_idrecarga');
				$apc_codventa = $this->session->userdata('apc_codventa');
				$apc_payment_id = $this->session->userdata('apc_payment_id');
				$apc_payment_it = $this->session->userdata('apc_payment_it');
				$apc_monto = $this->session->userdata('apc_monto');

				$apc_conf_sintarjeta = OFF;

				$this->load->view('web/head', $head);
				$seusu = $this->session->userdata('apc_usuario');
				if($seusu){
					$this->load->view('web/bienvenido', $seusu);
				}else{
					$this->load->view('web/nav');
				}
				$data['template_footer'] = $this->load->view('web/footer', '', TRUE);
				$data['apc_codventa'] = $apc_codventa;

				if(strlen($apc_idrecarga) > 0){

					$c = new Khipu\Configuration();
					$c->setSecret(SECRETKEY);
					$c->setReceiverId(RECEIVERID);
					//$c->setDebug(true);
					$cl = new Khipu\ApiClient($c);
					$kh = new Khipu\Client\PaymentsApi($cl);

					$response = $kh->paymentsIdGet($apc_payment_id);

					if ($response->getReceiverId() == RECEIVERID) {

						$this->db->trans_begin();

			            if ($response->getStatus() == 'done') {  // && $response->getAmount() == $amount
			                // marcar el pago como completo y entregar el bien o servicio
			                //$kh->paymentsIdConfirm($response->getPaymentId());

			                $rsRecarga = $this->recargas->get_vista($apc_codventa);

			                if($rsRecarga){
			                	$stRecarga = $rsRecarga['estado'];
			                	$stRelTarjeta = $rsRecarga['nrotarjeta'];

			                	if($stRelTarjeta > 0){
			                		$apc_conf_sintarjeta = OFF;
			                	}

			                	if($stRecarga == P_PENDING || $stRecarga == P_VALKHIPU){

			                		$dataRecarga = array('id' => $apc_idrecarga,
												 'estado' => P_CONFIRM,
												 'fechamail' => date('Y-m-d H:i:s')
														);
									$this->recargas->insert($dataRecarga);

									if($nroRec>0){
								
										$filtroTC = array('monto'=>$apc_monto, 'estado'=>ON);
										$this->tarjetas->set_where($filtroTC);
										$rsTCD = $this->tarjetas->get_tc_disponible();

										if($rsTCD){
											$tarjeta_id = $rsTCD[0]['id'];
											$datosRxT = array('recargas_id'=> $apc_idrecarga,
															  'recargas_tarjetas_id'=> $tarjeta_id
															 );
											$r = $this->recargas->insert_rxt($datosRxT);

											$datosTarj = array('id'=>$tarjeta_id,
															   'fechacomp'=> date('Y-m-d'),
															   'horacomp'=> date('H:i:s'),
															   'estado'=> OFF
															  );
											$this->tarjetas->insert($datosTarj);
											$this->turbo_email_compra($apc_codventa, $usu, MP_KHIPU, $nroRec, ON);
											$apc_conf_sintarjeta = ON;
										}else{
											$this->turbo_email_compra($apc_codventa, $usu, MP_KHIPU, 0, ON);
										}

										$this->session->set_userdata('apc_idrecarga','');
										$this->session->set_userdata('apc_codventa','');
										$this->session->set_userdata('apc_payment_id','');
										$this->session->set_userdata('apc_payment_it','0');
										$this->session->set_userdata('apc_monto','0');

									}else{
										if($apc_monto <= 100){

											$filtroTC = array('monto'=>$apc_monto, 'estado'=>ON);
											$this->tarjetas->set_where($filtroTC);
											$rsTCD = $this->tarjetas->get_tc_disponible();

											if($rsTCD){
												$tarjeta_id = $rsTCD[0]['id'];
												$datosRxT = array('recargas_id'=> $apc_idrecarga,
																  'recargas_tarjetas_id'=> $tarjeta_id
																 );
												$r = $this->recargas->insert_rxt($datosRxT);

												$datosTarj = array('id'=>$tarjeta_id,
																   'fechacomp'=> date('Y-m-d'),
																   'horacomp'=> date('H:i:s'),
																   'estado'=> OFF
																  );
												$this->tarjetas->insert($datosTarj);

												$this->turbo_email_compra($apc_codventa, $usu, MP_KHIPU, ON, ON);
												$apc_conf_sintarjeta = ON;
											}else{
												$this->turbo_email_compra($apc_codventa, $usu, MP_KHIPU, 0, ON);
											}

											$this->session->set_userdata('apc_idrecarga','');
											$this->session->set_userdata('apc_codventa','');
											$this->session->set_userdata('apc_payment_id','');
											$this->session->set_userdata('apc_payment_it','0');
											$this->session->set_userdata('apc_monto','0');

										}else{
											$apc_conf_sintarjeta = ON;
											$this->turbo_email_compra($apc_codventa, $usu, MP_KHIPU, 0, ON);
										}
									} 

			                	} // fin if $estado
			                } // fin if $rsRecarga

							$msg = 'El usuario '.$usu.' realizo una compra.';
							$this->email_infosoporte($nmUsu, $usu, $data_latlon, $data_pais, $data_ciudad, $data_ip, $msg);

							if($apc_conf_sintarjeta == OFF ){
								$this->load->view('compra/confirmacion',$data);
							}else{
								$this->load->view('compra/confirmacion_tarjeta',$data);
							} // fin if

						}else if($response->getStatus() == 'pending' || $response->getStatus() == 'verifying'){
							$apc_payment_it++;
							$this->session->set_userdata('apc_payment_it',$apc_payment_it);
							if($apc_payment_it>4){

								$dataRecarga = array('id' => $apc_idrecarga,
												 'estado' => P_VALKHIPU,
												 'horaconf' => date('H:i:s')
												);
								$this->recargas->insert($dataRecarga);

								$this->load->view('compra/stop_compra', $data);

							}else{
								$this->load->view('compra/verify_compra', $data);
							}

			            }else{
			            	
			            	$dataRecarga = array('id' => $apc_idrecarga,
												 //'estado' => P_CANCEL,
												 'horaconf' => date('H:i:s')
												);
							$this->recargas->insert($dataRecarga);
			            	$this->load->view('compra/error_compra', $data);
			            }

			            $this->db->trans_commit();

			        } else {
			            // receiver_id no coincide
			            //$payments->paymentsIdRefunds($response->getPaymentId());
			            $this->load->view('compra/error_compra', $data);
			        }
				}else{
					$this->load->view('compra/error_compra', $data);
				}
			}else{
				header('Location: '.base_url('usuario/login'));
			}
		} catch (Exception $e) {
			//echo 'Excepción capturada: ',  $e->getMessage(), "\n";
			$this->db->trans_rollback();
			//die('ERROR: '.$e->getMessage());
			$data['msjerror'] = $e->getMessage();

			$this->load->view('compra/error_compra', $data);

		}
	}

	public function notify(){
		$this->load->model('Recargas_model','recargas');

		$api_version = $this->input->post_get('api_version');
		$notification_token = $this->input->post_get('notification_token');

		if($api_version == '1.3'){
			$configuration = new Khipu\Configuration();
	        $configuration->setSecret(SECRETKEY);
	        $configuration->setReceiverId(RECEIVERID);
	        // $configuration->setDebug(true);

	        $client = new Khipu\ApiClient($configuration);
	        $payments = new Khipu\Client\PaymentsApi($client);

	        $response = $payments->paymentsGet($notification_token);
	        if ($response->getReceiverId() == RECEIVERID) {
	            if ($response->getStatus() == 'done') {  // && $response->getAmount() == $amount
	                // marcar el pago como completo y entregar el bien o servicio
	                $payments->paymentsIdConfirm($response->getPaymentId());

	                $this->recargas->set_where(array('payment_id'=>$response->getPaymentId()));
					$rsRecarga = $this->recargas->get_vista_paymentid();

					if($rsRecarga){
						$apc_idrecarga = $rsRecarga[0]['id'];
						$apc_codventa = $rsRecarga[0]['nroope'];
						$usu = $rsRecarga[0]['usuario'];

						$dataRecarga = array('id' => $apc_idrecarga,
									 'estado' => P_CONFIRM,
									 'fechamail' => date('Y-m-d H:i:s')
									);
						$this->recargas->insert($dataRecarga);

						$this->turbo_email_compra($apc_codventa, $usu, MP_KHIPU);

					} // fin if $rsRecarga
	            }
	        } else {
	            // receiver_id no coincide
	            $payments->paymentsIdRefunds($response->getPaymentId());
	        }

		} // fin api_version

	}

	public function cancel(){
		$this->load->library('utilitario');

		$head['pag_title'] = 'Cancelar Compra - AstroPay Card';
		$head['pag_description'] = 'AstroPay Card';
		$head['pag_keywords'] = '';

		$seUsuario = $this->session->userdata('apc_usuario');
		
		//if($seUsuario){
			$this->load->view('web/head', $head);
			$seusu = $this->session->userdata('apc_usuario');
			if($seusu){
				$this->load->view('web/bienvenido', $seusu);
			}else{
				$this->load->view('web/nav');
			}
			$data['template_footer'] = $this->load->view('web/footer', '', TRUE);

			$this->load->view('compra/error_compra',$data);
		//}else{
			//header('Location: '.base_url('usuario/login'));
		//}
	}

	public function error(){
		$this->load->library('utilitario');

		$head['pag_title'] = 'Error al Comprar - AstroPay Card';
		$head['pag_description'] = 'AstroPay Card';
		$head['pag_keywords'] = '';

		$seUsuario = $this->session->userdata('apc_usuario');
		
		//if($seUsuario){
			$this->load->view('web/head', $head);
			$seusu = $this->session->userdata('apc_usuario');
			if($seusu){
				$this->load->view('web/bienvenido', $seusu);
			}else{
				$this->load->view('web/nav');
			}
			$data['template_footer'] = $this->load->view('web/footer', '', TRUE);

			$this->load->view('compra/error_compra',$data);
		//}else{
			//header('Location: '.base_url('usuario/login'));
		//}
	}

	public function revisaoperacion(){
		set_time_limit(20000);
		header('Content-type: application/json; charset=utf-8');
		$this->load->model('Recargas_model','recargas');
		$this->load->model('Tarjetas_model','tarjetas');
		$this->load->library('utilitario');

		$rs = $this->recargas->get_pendientes();
		//var_dump($rs); die;

		if($rs){
			//echo count($rs); var_dump($rs);

			$c = new Khipu\Configuration();
			$c->setSecret(SECRETKEY);
			$c->setReceiverId(RECEIVERID);
			//$c->setDebug(true);
			$cl = new Khipu\ApiClient($c);
			$kh = new Khipu\Client\PaymentsApi($cl);

			foreach ($rs as $key => $f) {

				$this->db->reset_query();

				$usu = $f['usuario'];
				$nmUsu = $f['nombres'].' '.$f['apellidos'];
				$nroRec = $f['nrorec'];

				$apc_idrecarga = $f['id'];
				$apc_codventa = $f['nroope'];
				$apc_payment_id = $f['payment_id'];
				$apc_monto = $f['monto_usd']; 
				$apc_conf_sintarjeta = OFF;
				//$apc_payment_id = $f['payment_id'];
				$apc_time_reg = $f['timereg'];

				//var_dump($f);

				if($apc_payment_id){

					$response = $kh->paymentsIdGet($apc_payment_id);
					//var_dump($response); echo 'paymentsIdGet ---------------------------------- ';

					if($apc_time_reg >= 5){
						if ($response->getReceiverId() == RECEIVERID) {
							$this->db->trans_begin();
							// && $response->getAmount() == $amount
				            if ($response->getStatus() == 'done') {  
				                $dataRecarga = array('id' => $apc_idrecarga,
													 'estado' => P_CONFIRM,
													 'fechamail' => date('Y-m-d H:i:s'),
													 'envio' => 'S'
													);
								$this->recargas->insert($dataRecarga);

								if($nroRec>0){
									$this->tarjetas->clear_where();
									$filtroTC = array('monto'=>$apc_monto, 'estado'=>ON);
									$this->tarjetas->set_where($filtroTC);
									$rsTCD = $this->tarjetas->get_tc_disponible();

									if($rsTCD){
										$tarjeta_id = $rsTCD[0]['id'];
										$datosRxT = array('recargas_id'=> $apc_idrecarga,
														  'recargas_tarjetas_id'=> $tarjeta_id
														 );
										$r = $this->recargas->insert_rxt($datosRxT);

										$datosTarj = array('id'=>$tarjeta_id,
														   'fechacomp'=> date('Y-m-d'),
														   'horacomp'=> date('H:i:s'),
														   'estado'=> OFF
														  );
										$this->tarjetas->insert($datosTarj);
										$this->turbo_email_compra($apc_codventa, $usu, MP_KHIPU, $nroRec, ON);
										$apc_conf_sintarjeta = ON;
									}else{
										$this->turbo_email_compra($apc_codventa, $usu, MP_KHIPU, 0, ON);
									}

								}else{
									if($apc_monto <= 100){
										$this->tarjetas->clear_where();
										$filtroTC = array('monto'=>$apc_monto, 'estado'=>ON);
										$this->tarjetas->set_where($filtroTC);
										$rsTCD = $this->tarjetas->get_tc_disponible();

										if($rsTCD){
											$tarjeta_id = $rsTCD[0]['id'];
											$datosRxT = array('recargas_id'=> $apc_idrecarga,
															  'recargas_tarjetas_id'=> $tarjeta_id
															 );
											$r = $this->recargas->insert_rxt($datosRxT);

											$datosTarj = array('id'=>$tarjeta_id,
															   'fechacomp'=> date('Y-m-d'),
															   'horacomp'=> date('H:i:s'),
															   'estado'=> OFF
															  );
											$this->tarjetas->insert($datosTarj);

											$this->turbo_email_compra($apc_codventa, $usu, MP_KHIPU, ON, ON);
											$apc_conf_sintarjeta = ON;
										}else{
											$this->turbo_email_compra($apc_codventa, $usu, MP_KHIPU, 0, ON);
										} // fin if $rsTCD

									}else{
										$apc_conf_sintarjeta = ON;
										$this->turbo_email_compra($apc_codventa, $usu, MP_KHIPU, 0, ON);
									} // fin if $apc_monto
								} // fin if $nroRec>0

							}else if($response->getStatus() == 'pending' ){ // || $response->getStatus() == 'verifying'

								$nromin = $f['dif'];
								if($nromin > 50){
									
									$dataRecarga = array('id' => $apc_idrecarga,
													 'estado' => P_CANCEL, // P_CANCEL
													 'horaconf' => date('H:i:s')
													);
									$this->recargas->insert($dataRecarga);
								} // fin if $nromin
				            } // fin if $response->getStatus()
				            $this->db->trans_commit();
				        } // FIN IF $response->getReceiverId()
					} // fin if $apc_time_reg

				} // fin if $apc_payment_id

				
			} // fin foreach rs
		} // fin if rs
		echo json_encode($rs);
	}


	private function email_infosoporte($nombres='', $usuario='', $latlong='',$pais='', $ciudad='', $ip='', $msg=''){ //
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

		$this->email->from(SOPORTE, 'AstroPay Card CL');
		$this->email->subject('AstroPay Card - Información de Usuario');
		$this->email->message($message);
		$this->email->reply_to('soporte@astroypaycard.cl');
		$this->email->to(SOPORTE);
		//$this->email->bcc('anthony1585@gmail.com');
		
	    $swSend = 0;
        if($this->email->send()){
        	$swSend = 1;
        }
        return $swSend;
        //$this->load->view('compra/template-confirma',$data);
	}

	public function enviatarjeta(){

		$cod='FA8531'; 
		$usu = 'anthony1585@gmail.com'; 
		$metodopago = MP_KHIPU; 
		$nrorec = 1; 
		$swnew = 0;
		$this->email_compra($cod, $usu, $metodopago, $nrorec, $swnew);
	}

	private function email_compra($cod='', $usu = '', $metodopago = 2, $nrorec = 0, $swnew = 0){ //

		$this->load->model('Recargas_model','recargas');
		$this->load->model('Tarjetas_model','tarjetas');
		$this->load->library('utilitario');
		$this->load->library('email');

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

		if($metodopago == MP_BANCHILE){
			$message = $this->load->view('compra/template-confirma', $data, TRUE);
		}else{
			if($nrorec){
				if($tipoTarjeta == TPT_EXC){
					$message = $this->load->view('compra/template-confirma-kptc-leer', $data, TRUE);
				}else{
					$message = $this->load->view('compra/template-confirma-kptc', $data, TRUE);
				}
			}else{
				$message = $this->load->view('compra/template-confirma-kp', $data, TRUE);
			}
		}

		if($swnew == 0){
			$subject = 'NUEVO REGISTRO | Compra AstroPay card usd '.$monto_usd.' - Pedido (#'.$cod.')';
		}else{
			$subject = 'Compra AstroPay card usd '.$monto_usd.' - Pedido (#'.$cod.')';
		}
		$urlPdf = base_url('docs/astropay-chile.pdf');


		$this->email->from(SOPORTE, 'AstroPay card');
		$this->email->subject($subject);
		$this->email->message($message);
		
		$this->email->reply_to(SOPORTE); // SOPORTE - 'loctelonline@gmail.com'
		$this->email->to($usu);
		$this->email->bcc(SOPORTE); //, anthony1585@gmail.com
		$this->email->attach($urlPdf);
		
	    $swSend = 0;
        if($this->email->send()){
        	$swSend = 1;
        }
        return $swSend;
        //$this->load->view('compra/template-confirma',$data);
	}


	private function turbo_email_compra($cod='', $usu = '', $metodopago = 2, $nrorec = 0, $swnew = 0){ //

		$this->load->model('Recargas_model','recargas');
		$this->load->model('Tarjetas_model','tarjetas');
		$this->load->library('utilitario');
		$this->load->library('email');
		$this->load->library('turboemail');

		$rsrec = $this->recargas->get_vista($cod);
		//var_dump($rsrec);die('ID: '.$rsrec['id']);
		$idRecarga = $rsrec['id'];

		$this->tarjetas->clear_where();
		$filtroTarjeta = array('c.id'=>$idRecarga);
		$this->tarjetas->set_where($filtroTarjeta);
		$rsTarjeta = $this->tarjetas->get_tarjeta_recarga();
		$tipoTarjeta = $rsTarjeta[0]['tipo'];

		$data['cod'] = $cod;
		$data['rs'] = $rsrec;
		$data['rsTarjeta'] = $rsTarjeta[0];

		$monto_usd = $rsrec['monto_usd'];

		if($metodopago == MP_BANCHILE){
			$message = $this->load->view('compra/template-confirma', $data, TRUE);
		}else{
			if($nrorec){
				if($tipoTarjeta == TPT_EXC){
					$message = $this->load->view('compra/template-confirma-kptc-leer', $data, TRUE);
				}else{
					$message = $this->load->view('compra/template-confirma-kptc', $data, TRUE);
				}
			}else{
				$message = $this->load->view('compra/template-confirma-kp', $data, TRUE);
			}
		}

		if($swnew == 0){
			$subject = 'NUEVO REGISTRO | Compra AstroPay card usd '.$monto_usd.' - Pedido (#'.$cod.')';
		}else{
			$subject = 'Compra AstroPay card usd '.$monto_usd.' - Pedido (#'.$cod.')';
		}
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
		
        return $swSend;
        //$this->load->view('compra/template-confirma',$data);
	}

	public function tcpe(){
		$this->load->model('constantes_model','constantes');
		$tc = $this->uri->segment(3);

		$data = array(
						'id' => TC,
						'variable' => $tc,
						'fechaact' => date('Y-m-d'),
						'horaact' => date('H:i:s')
					);
		$this->constantes->insert($data);

	}
	
}
