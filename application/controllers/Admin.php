<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.2.4 or newer
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Academic Free License version 3.0
 *
 * This source file is subject to the Academic Free License (AFL 3.0) that is
 * bundled with this package in the files license_afl.txt / license_afl.rst.
 * It is also available through the world wide web at this URL:
 * http://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@ellislab.com so we can send you a copy immediately.
 *
 * @package		CodeIgniter
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
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
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 
	 var $idusuario = '';
	 var $arrayEstado = array(1=>'Activo',2=>'Desactivo');
	 var $arrayTipoDoc = array(1=>'DNI', 2=>'PASSAPORTE', 3=>'CARNET DE EXTRANJERIA');
	
	public function __construct(){
		parent::__construct();
		date_default_timezone_set('America/Santiago');
		$this->load->library('utilitario');
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

	public function index(){

		$this->login();		

		$idusuario = $this->session->userdata('idusuario'); //usuario
		$tipousuario = $this->session->userdata('tipousu');
		$persona = trim($this->input->post('persona'));
		$distrito = trim($this->input->post('distrito'));

		$carpeta = 'admin';
		$arr_header['usuario'] = $this->session->userdata('nombre');
		$arr_nav = array();

		$data['tmp_header'] = $this->load->view($carpeta.'/header', $arr_header, TRUE);
		$data['tmp_nav'] = $this->load->view($carpeta.'/nav', $arr_nav, TRUE);

		$this->load->view($carpeta.'/dashboard',$data);
		
	}

	/**************************CONFIG****************************/
	public function config(){
		$this->login();

		$this->load->model('constantes_model','constantes');

		$carpeta = 'admin';
		$arr_header['usuario'] = $this->session->userdata('nombre');
		$arr_nav = array();

		$data['tmp_header'] = $this->load->view($carpeta.'/header', $arr_header, TRUE);
		$data['tmp_nav'] = $this->load->view($carpeta.'/nav', $arr_nav, TRUE);

		$data['rs'] = $this->constantes->vista(false);

		$this->load->view($carpeta.'/constantes_vista',$data);

	}

	public function grabar_config(){
		$this->login();

		$this->load->model('constantes_model','constantes');

		$id = $this->input->post('id');
		$constante = $this->input->post('constante');
		$variable = $this->input->post('variable');

		$redirect = base_url('admin/config');

		if($id){
			foreach ($id as $key => $value) {
				$data = array(
								'id' => $value,
								'constante' => $constante[$key],
								'variable' => $variable[$key],
								'fechaact' => date('Y-m-d'),
								'horaact' => date('H:i:s')
							);
				$this->constantes->insert($data);
			}
		}
		
		header('Location: '.$redirect);
	}
	/**************************FIN CONFIG****************************/

	/**************************TARJETAS****************************/

	public function tarjetas(){
		$this->login();

		$this->load->model('tarjetas_model','tarjetas');

		$this->load->library('form_validation');
		//$this->load->helper('url');

		$carpeta = 'admin';
		$arr_header['usuario'] = $this->session->userdata('nombre');
		$arr_nav = array();

		$data['tmp_header'] = $this->load->view($carpeta.'/header', $arr_header, TRUE);
		$data['tmp_nav'] = $this->load->view($carpeta.'/nav', $arr_nav, TRUE);

		$this->load->view($carpeta.'/tarjetas_vista',$data);
	}

	public function ajax_vista_tarjetas(){

		$this->login();		
		$this->load->model('tarjetas_model','tarjetas');

		$filtro = $this->input->post('fil');
		$arrRpFiltro = array();
		if(strlen($filtro)>0){

			$arrFiltro = explode('|', $filtro);

			if($arrFiltro){
				$dt = $arrFiltro[0];
				if($dt){
					$arrRpFiltro['a.monto'] = $dt;
				}

				$dt = $arrFiltro[1];
				if($dt){
					$arrRpFiltro['a.estado'] = $dt;
				}
			} // fin filtro 

			if($arrRpFiltro){
				$this->tarjetas->set_where($arrRpFiltro);
			} // fin if 

		} // fin if $filtro
		//var_dump($arrRpFiltro); die;

		$list = $this->tarjetas->get_datatables();

		$data = array();
        $no = $this->input->post('start'); 
        foreach ($list as $obj) {
            $no++;
            $row = array();

            $estado = '<i class="ace-icon fa fa-circle green"></i>';
            if($obj->estado == OFF){
            	$estado = '<i class="ace-icon fa fa-circle red"></i>';
            }

            $row[] = '<div class="btn-group">
	                    <button data-toggle="dropdown" class="btn btn-primary btn-sm dropdown-toggle" aria-expanded="false">
	                      <i class="fa fa-cog"></i>
	                      <span class="ace-icon fa fa-caret-down icon-on-right"></span>
	                    </button>
	                    <ul class="dropdown-menu dropdown-info">
	                      <li>
	                        <a href="#" class="btn-detalle-tarjeta" data-id="'.$obj->id.'"  data-act="'.base_url('admin/').'"><i class="ace-icon fa fa-list-alt"></i> Editar</a>
	                      </li>
	                      <li>
	                        <a href="#" class="btn-enviar-tarjeta" data-id="'.$obj->id.'" data-tp="'.$obj->tipo.'" data-st="'.$obj->estado.'" data-act="'.base_url('tarjeta/enviar').'"><i class="ace-icon fa fa-share"></i> Enviar Tarjeta</a>
	                      </li>
	                      <li>
	                        <a href="#" class="btn-eliminar" data-id="'.$obj->id.'" data-act="'.base_url('admin/delete_tarjetas').'"><i class="ace-icon fa fa-trash-o"></i> Eliminar</a>
	                      </li>
	                    </ul>
	                  </div>';
	        
            $row[] = $no;
            $row[] = $estado;

            $tipo = $obj->tipo;
            if($tipo == TPT_IMG){
            	$row[] = '<a data-fancybox="gallery" href="'.base_url('assets/upload/temptc/'.$obj->foto).'"><i class="fa fa-credit-card fa-2x"></i></a>';
            }else{
            	$row[] = '<a data-fancybox data-type="iframe" href="'.base_url('tarjeta/valida/'.$obj->id).'"><i class="fa fa-credit-card fa-2x"></i></a>';
            }

            $row[] = $obj->digitos;
            $row[] = 'Tarjeta de '.$obj->monto; // 
            $row[] = $obj->fechareg_f; // 
            $row[] = $obj->horareg; // 

            $row[] = $obj->usuario; // 
            $row[] = $obj->nroope; // 

            $row[] = $obj->fechacomp_f; // 
            $row[] = $obj->horacomp; // 
            
            $data[] = $row;
        }


		$output = array(
                "draw" => $this->input->post('draw'),
                "recordsTotal" => $this->tarjetas->count_all(),
                "recordsFiltered" => $this->tarjetas->count_filtered(),
                "data" => $data,
        );

		echo json_encode($output);
	}

	public function get_tarjetas(){
		header('Content-type: application/json; charset=utf-8');
		$this->login();
		$this->load->model('tarjetas_model','tarjetas');

		//$id = $this->uri->segment(3);
		$id = trim($this->input->post('id'));
		$rs = $this->tarjetas->get_vista($id);
		echo json_encode($rs);
	}

	public function delete_tarjetas(){
		header('Content-type: application/json; charset=utf-8');
		$this->login();
		$id = trim($this->input->post('id'));
		
		$this->db->where('recargas_tarjetas_id', $id); 
		$this->db->delete('recargas_x_tarjetas');

		$this->db->reset_query();
		$this->db->where('id', $id); 
		$this->db->delete('recargas_tarjetas');

		$arrayResp = array('status' => true,'mensaje'=>'Los datos del usuario fueron eliminados.','redirect'=>'');
		die(json_encode($arrayResp));
	}

	public function grabar_tarjetas(){
		header('Content-type: application/json; charset=utf-8');

		$this->load->model('tarjetas_model','tarjetas');
		$this->login();
		$arrDatos = array(); $arrDatosUser = array();
		$id = trim($this->input->post('id'));
		$arrDatos['id'] = $id;

		$arrDatos['foto'] = trim($this->input->post('foto'));
		$arrDatos['monto'] = trim($this->input->post('monto'));
		$arrDatos['digitos'] = trim($this->input->post('digitos'));

		$fechareg = trim($this->input->post('fechareg'));
		$arrDatos['fechareg'] = strlen($fechareg)>0?$fechareg:date('Y-m-d');

		$horareg = trim($this->input->post('horareg'));
		$arrDatos['horareg'] = strlen($horareg)>0?$horareg:date('H:i:s');

		$fechacomp = trim($this->input->post('fechacomp'));
		if(strlen($fechacomp)){
			$arrDatos['fechacomp'] = $fechacomp;
		}
	
		$horacomp = trim($this->input->post('horacomp'));
		if(strlen($horacomp)>0){
			$arrDatos['horacomp'] = $horacomp;
		}

		$redirect = base_url('admin/tarjetas');

		if(count($arrDatos)==0){
			$arrayResp = array('status' => false,'redirect'=>'','datos'=>$arrDatos,'mensaje'=>'Verifique los datos de ingresados.');
		}else{
			//var_dump($arrDatos);
			$this->tarjetas->insert($arrDatos);
			$arrayResp = array('status' => true, 'redirect'=>$redirect,'datos'=>$arrDatos, 'mensaje'=>'Los datos fueron registrados con exito.');
		}
		
		die(json_encode($arrayResp));
	}

	public function uploadtc()
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

	    $pathtapc = UPLOAD.'temptc/';

	    $newfilename = rand(1,99999);
	    $nomarchivo = str_replace('.', '-', $archivo['name']);

	    if($archivo){
	    	$data = $this->uploader->upload($archivo, array(
		        'limit' => 1, //Maximum Limit of files. {null, Number}
		        'extensions' => array('jpg', 'jpeg', 'png', 'gif'), //Whitelist for file extension. {null, Array(ex: array('jpg', 'png'))}
		        'required' => false, //Minimum one file is required for upload {Boolean}
		        'uploadDir' => $pathtapc, //Upload directory {String}
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
	    		$archivo = base_url('assets/upload/temptc/'.$arrDato['name']);
	    		$nomarch = $arrDato['name'];

	    		$filename = UPLOAD.'/temptc/'.$nomarch;

	    		$imagen = getimagesize($filename);    //Sacamos la información
				$ancho = $imagen[0];              //Ancho
				$alto = $imagen[1];               //Alto
				/*echo "<br>Ancho: $ancho";
				echo "<br>Alto: $alto";
				die();*/

				if($alto == 2220){  // 2220
					$srcX = 40;
					$srcY = 250;
					$alto = 640;
					$width = 1000;
				}else if($alto == 1280){  // 1280
					$srcX = 30;
					$srcY = 190;
					$alto = 420;
					$width = 670;
				}else if($alto == 1920){  // 1920
					$srcX = 45;
					$srcY = 270;
					$alto = 640;
					$width = 1000;
				}
				//die($srcX.' - '.$srcY.' | '.$alto);

				$img = imagecreatetruecolor($width,$alto);
				$org_img = imagecreatefromjpeg($filename);
				$ims = getimagesize($filename);
				imagecopy($img,$org_img, 0, 0, $srcX, $srcY, $width, $alto);
				imagejpeg($img,$filename,90);
				imagedestroy($img);

				/*
	    		$img = imagecreatetruecolor('1000','640');
				$org_img = imagecreatefromjpeg($filename);
				$ims = getimagesize($filename);
				imagecopy($img,$org_img, 0, 0, 40, 250, 1000, 640);
				imagejpeg($img,$filename,90);
				imagedestroy($img);
				*/
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


	/**************************FIN TARJETAS****************************/


	/**************************USUARIOS****************************/

	public function usuarios(){
		$this->login();

		$this->load->model('usuario_model','usuario');

		$carpeta = 'admin';
		$arr_header['usuario'] = $this->session->userdata('nombre');
		$arr_nav = array();

		$data['tmp_header'] = $this->load->view($carpeta.'/header', $arr_header, TRUE);
		$data['tmp_nav'] = $this->load->view($carpeta.'/nav', $arr_nav, TRUE);

		$this->load->view($carpeta.'/usuarios_vista',$data);
	}

	public function ajax_vista_usuarios(){

		$this->login();		
		$this->load->model('usuario_model','usuario');

		$list = $this->usuario->get_datatables();

		$data = array();
        $no = $this->input->post('start'); //$_POST['start'];
        foreach ($list as $obj) {
            $no++;
            $row = array();

            $tipo = $this->arrayTipoDoc[$obj->tipodoc];

            $estado = '<i class="ace-icon fa fa-circle green"></i>';
            if($obj->sw == OFF){
            	$estado = '<i class="ace-icon fa fa-circle red"></i>';
            }

            $row[] = '<div class="btn-group">
	                    <button data-toggle="dropdown" class="btn btn-primary btn-sm dropdown-toggle" aria-expanded="false">
	                      <i class="fa fa-cog"></i>
	                      <span class="ace-icon fa fa-caret-down icon-on-right"></span>
	                    </button>
	                    <ul class="dropdown-menu dropdown-info">
	                      <li>
	                        <a href="#" class="btn-pass" data-id="'.$obj->password.'" data-usu="'.$obj->usuario.'" ><i class="ace-icon fa fa-unlock"></i> Recuperar Pass</a>
	                      </li>
	                      <li>
	                        <a href="#" class="btn-eliminar" data-id="'.$obj->id.'" data-usu="'.$obj->usuario.'" data-act="'.base_url('admin/delete_usuarios').'"><i class="ace-icon fa fa-close"></i> Resetear</a>
	                      </li>
	                    </ul>
	                  </div>';
	        
            $row[] = $no;
            $row[] = $estado;
            $row[] = '<a data-fancybox="gallery" href="'.base_url('assets/upload/'.$obj->dni1).'"><i class="fa fa-picture-o fa-2x"></i></a>';
            $row[] = '<a data-fancybox="gallery" href="'.base_url('assets/upload/'.$obj->dni2).'"><i class="fa fa-picture-o fa-2x"></i></a>';
            $row[] = '<a href="#" class="btn-detalle-usu" data-id="'.$obj->id.'" >'.$obj->usuario.'</a>'; //0
            $row[] = $obj->nombres.' '.$obj->apellidos; // 
            $row[] = $obj->nrowsp;
            $row[] = $obj->celular; // 
            $row[] = $obj->telefono; // 
            $row[] = $obj->nacionalidad; // 
            $row[] = $tipo.': '.$obj->documento; // 

            $row[] = $obj->fechareg; // 
            $row[] = $obj->fechoraconf; // 
            $row[] = $obj->distrito; // 
            $row[] = $obj->direccion; // 
            
            //$row[] = '<img src="'.base_url('assets/upload/catalogo/'.$obj->foto).'" alt="'.$obj->nombre.'" width="60" >'; // 
            
            $data[] = $row;
        }


		$output = array(
                "draw" => $this->input->post('draw'),
                "recordsTotal" => $this->usuario->count_all(),
                "recordsFiltered" => $this->usuario->count_filtered(),
                "data" => $data,
        );

		echo json_encode($output);
	}

	public function get_usuarios(){
		header('Content-type: application/json; charset=utf-8');
		$this->login();
		$this->load->model('usuario_model','usuario');

		//$id = $this->uri->segment(3);
		$id = trim($this->input->post('id'));
		$rs = $this->usuario->get_vista($id);
		echo json_encode($rs);

	}

	public function delete_usuarios(){
		header('Content-type: application/json; charset=utf-8');
		$this->login();
		$id = trim($this->input->post('id'));
		
		$this->db->where('usuario_id', $id); 
		$this->db->delete('recargas');

		$this->db->reset_query();
		$this->db->where('usuario_id', $id); 
		$this->db->delete('usuario_log');

		$this->db->reset_query();
		$this->db->where('id', $id); 
		$this->db->delete('usuario');
		$arrayResp = array('status' => true,'mensaje'=>'Los datos del usuario fueron eliminados.','redirect'=>'');
		die(json_encode($arrayResp));
	}

	public function grabar_usuarios(){
		header('Content-type: application/json; charset=utf-8');

		$this->load->model('usuario_model','usuario');
		$this->login();
		$id = trim($this->input->post('id'));

		$arrDatos = array(); $arrDatosUser = array();
		$arrDatos['id'] = $id;
		$arrDatos['billetera'] = trim($this->input->post('billetera'));
		$arrDatos['dni1'] = trim($this->input->post('dni1'));
		$arrDatos['dni2'] = trim($this->input->post('dni2'));
		$arrDatos['reciboservicio'] = trim($this->input->post('reciboservicio'));

		$redirect = base_url('admin/usuarios');

		if(count($arrDatos)==0){
			$arrayResp = array('status' => false,'datos'=>$arrDatos,'mensaje'=>'Verifique los datos de ingresados.');
		}else{
			$this->usuario->insert($arrDatos);
			$arrayResp = array('status' => true, 'redirect'=>$redirect,'datos'=>$arrDatos, 'mensaje'=>'Los datos fueron registrados con exito.');
		}
		
		//var_dump(); die;
		die(json_encode($arrayResp));
	}


	/**************************DESTINOS****************************/

	public function pais(){
		$this->login();

		$this->load->model('calculadora/pais_model','pais');

		$carpeta = 'admin';
		$arr_header['usuario'] = $this->session->userdata('nombre');
		$arr_nav = array();

		$data['tmp_header'] = $this->load->view($carpeta.'/header', $arr_header, TRUE);
		$data['tmp_nav'] = $this->load->view($carpeta.'/nav', $arr_nav, TRUE);

		$this->load->view($carpeta.'/pais_vista',$data);
	}

	public function ajax_vista_pais(){

		$this->login();
		$this->load->model('calculadora/pais_model','pais');

		$list = $this->pais->get_datatables();

		$data = array();
        $no = $this->input->post('start'); //$_POST['start'];
        foreach ($list as $obj) {
            $no++;
            $row = array();

            $estado = '<i class="ace-icon fa fa-circle green"></i>';
            if($obj->estado == OFF){
            	$estado = '<i class="ace-icon fa fa-circle red"></i>';
            }

            $row[] = '<div class="btn-group">
	                    <button data-toggle="dropdown" class="btn btn-primary btn-sm dropdown-toggle" aria-expanded="false">
	                      <i class="fa fa-cog"></i>
	                      <span class="ace-icon fa fa-caret-down icon-on-right"></span>
	                    </button>
	                    <ul class="dropdown-menu dropdown-info">
	                      <li>
	                        <a href="#" class="btn-editar" data-id="'.$obj->id.'"  data-act="'.base_url('admin/delete_pais').'"><i class="ace-icon fa fa-list-alt"></i> Editar</a>
	                      </li>
	                      <!--<li>
	                        <a href="#" class="btn-eliminar" data-id="'.$obj->id.'" data-act="'.base_url('admin/delete_pais').'"><i class="ace-icon fa fa-close"></i> Eliminar</a>
	                      </li>-->
	                    </ul>
	                  </div>';
	        
            $row[] = $no;
            $row[] = $estado;
            $row[] = $obj->nombre; 
            $row[] = $obj->zona_fdx_ie;
            $row[] = $obj->zona_dhl_ie; 
            $data[] = $row;
        }

		$output = array(
                "draw" => $this->input->post('draw'),
                "recordsTotal" => $this->pais->count_all(),
                "recordsFiltered" => $this->pais->count_filtered(),
                "data" => $data,
        );

		echo json_encode($output);
	}

	public function get_pais(){
		header('Content-type: application/json; charset=utf-8');
		$this->login();
		$this->load->model('calculadora/pais_model','pais');

		//$id = $this->uri->segment(3);
		$id = trim($this->input->post('id'));

		$filtro = array('id'=>$id);
		$this->pais->set_where($filtro);
		$rs = $this->pais->get_vista();
		echo json_encode($rs);

	}

	public function delete_pais(){
		header('Content-type: application/json; charset=utf-8');
		$this->login();
		$id = trim($this->input->post('id'));
		$this->db->where('id', $id); $this->db->delete('calculadora_pais');
		$arrayResp = array('status' => true,'mensaje'=>'Los datos del usuario fueron eliminados.','redirect'=>'');
		die(json_encode($arrayResp));
	}

	public function grabar_pais(){
		header('Content-type: application/json; charset=utf-8');
		$this->load->model('calculadora/pais_model','pais');
		$this->login();
		$id = trim($this->input->post('id'));

		$arrDatos = array(); $arrDatosUser = array();
		$arrDatos['id'] = $id;
		$arrDatos['nombre'] = strtoupper(trim($this->input->post('nombre')));
		$arrDatos['zona_fdx_ie'] = trim($this->input->post('zona_fdx_ie'));
		$arrDatos['zona_dhl_ie'] = trim($this->input->post('zona_dhl_ie'));
		

		$redirect = base_url('admin/pais');

		if(count($arrDatos)==0){
			$arrayResp = array('status' => false,'datos'=>$arrDatos,'mensaje'=>'Verifique los datos de ingresados.');
		}else{
			$this->pais->insert($arrDatos);
			$arrayResp = array('status' => true, 'redirect'=>$redirect,'datos'=>$arrDatos, 'mensaje'=>'Los datos fueron registrados con exito.');
		}
		
		//var_dump(); die;
		die(json_encode($arrayResp));
	}

	/**************************USUARIOS****************************/



	/********************** VENTAS WU *********************************/

	public function ventaswu(){
		$this->login();
		$this->load->model('calculadora/login_model','usuario');
		$this->load->model('calculadora/tienda_model','tienda');

		$carpeta = 'admin';
		$arr_header['usuario'] = $this->session->userdata('nombre');
		$arr_nav = array();

		$data['tmp_header'] = $this->load->view($carpeta.'/header', $arr_header, TRUE);
		$data['tmp_nav'] = $this->load->view($carpeta.'/nav', $arr_nav, TRUE);

		$data['rs_tiendas'] = $this->tienda->get_cbo();
		$data['rs_usuarios'] = $this->usuario->get_cbo();

		$this->load->view($carpeta.'/ventaswu_vista',$data);
	}

	public function ajax_vista_ventaswu(){

		$this->login();
		$this->load->model('calculadora/transferencias_model','transferencias');

		$filtro = $this->input->post('fil');
		$arrPost = explode('|', $filtro);
		//var_dump($arrPost); 

		$fitrar = array();
		if(array_key_exists(0, $arrPost)){
			$dato = $arrPost[0];
			if($dato){ $fitrar['calculadora_login_id'] = $dato; }
		}

		if(array_key_exists(1, $arrPost)){
			$dato = $arrPost[1];
			if($dato){ $fitrar['tran.pais'] = $dato; }
		}

		if(array_key_exists(2, $arrPost)){
			//array_push($fitrar, array('fecha'=>$arrPost[2]));
			$dato = $arrPost[2];
			if($dato){ $fitrar['tran.fecha'] = $dato; }
		}
		//var_dump($fitrar); die;

		$this->transferencias->set_where($fitrar);
		$list = $this->transferencias->get_datatables();

		$data = array();
        $no = $this->input->post('start'); //$_POST['start'];
        foreach ($list as $obj) {
            $no++;
            $row = array();

            //$tipo = $this->arrayTipoDoc[$obj->tipodoc];

            
            $row[] = '<div class="btn-group">
	                    <button data-toggle="dropdown" class="btn btn-primary btn-sm dropdown-toggle" aria-expanded="false">
	                      <i class="fa fa-cog"></i>
	                      <span class="ace-icon fa fa-caret-down icon-on-right"></span>
	                    </button>
	                    <ul class="dropdown-menu dropdown-info">
	                      <li>
	                        <a href="#" class="btn-detalle-venta" data-id="'.$obj->id.'" data-act="'.base_url('admin/get_ventaswu').'"><i class="ace-icon fa fa-list-alt"></i> Detalle</a>
	                      </li>
	                      <li>
	                        <a href="#" class="btn-eliminar-tra" data-id="'.$obj->id.'" data-act="'.base_url('admin/delete_ventaswu').'"><i class="ace-icon fa fa-close"></i> Eliminar</a>
	                      </li>
	                    </ul>
	                  </div>';
	        
            $row[] = $no;
            $pais = $obj->pais==OTROS?'OTROS':'COLOMBIA';
            $row[] = $pais; // 
            $row[] = $obj->tienda; 
            $row[] = $obj->usuario; //0
            $row[] = $obj->edt_mnt;
            $row[] = $obj->ing_crg;
            $row[] = $obj->ing_tiva;
            $row[] = $obj->edt_sbt; // 
            $row[] = $obj->edt_tot; // 
            $row[] = $obj->edt_tc; // 
            $row[] = $obj->edt_appago; // 

            $utilidad = $obj->utilidad;
            /*if($obj->pais == OTROS){
            	$edt_mnt = floatval($obj->edt_mnt);
	            $ing_mnt = floatval($obj->ing_mnt);
	            $utilidad =  $edt_mnt - $ing_mnt;
            }else if($obj->pais == COLOMBIA){
            	$tcori = floatval($obj->ing_tc);
            	$tcact = floatval($obj->ing_tcact);
            	$mnt_appago = floatval($obj->edt_appago);

            	$mnt_ori = $mnt_appago/$tcori;
            	$mnt_act = $mnt_appago/$tcact;
            	$utilidad = $mnt_act - $mnt_ori;
            }*/

            $row[] = round($utilidad, 2); 
            $row[] = $obj->fecha_f; // 
            $row[] = $obj->hora; // 
            $row[] = $obj->nroboleta; 
            $formato = $obj->adjunto==1?'Formato1':'Formato2';
            $row[] = $formato; // 
            $row[] = '<a href="'.base_url('assets/upload/pdf/'.$obj->adjunto).'" target="_blank" ><i class="ace-icon fa fa-file-pdf-o fa-2x"></i></a>'; // 
            $row[] = '<a href="#" class="btn-pdf" data-mnt="'.$obj->edt_mnt.'" data-sbt="'.$obj->edt_sbt.'" data-tc="'.$obj->edt_tc.'" data-appago="'.$obj->edt_appago.'" data-adjunto="'.$obj->adjunto.'" data-formato="'.$obj->formato.'" data-print="'.$obj->print.'" ><i class="ace-icon fa fa-file-pdf-o fa-2x"></i> </a>'; // 
            $data[] = $row;
        }

		$output = array(
                "draw" => $this->input->post('draw'),
                "recordsTotal" => $this->transferencias->count_all(),
                "recordsFiltered" => $this->transferencias->count_filtered(),
                "data" => $data,
        );

		echo json_encode($output);
	}

	public function get_ventaswu(){
		header('Content-type: application/json; charset=utf-8');
		$this->load->model('calculadora/transferencias_model','transferencias');
		$this->login();
		$carpeta = 'calculadora';
		$id = $this->input->post('id');

		$filtro = array('id'=>$id);
		$this->transferencias->set_where($filtro);
		$rs = $this->transferencias->get_vista();

		die(json_encode($rs));
	}

	public function ticketwestern(){
		$this->login();
		$this->load->model('calculadora/transferencias_model','transferencias');
		$monto = $this->input->post('edt_mnt');
		$data['mnt_total'] = str_replace(',', '', $monto);
		
		$edt_sbt = $this->input->post('edt_sbt');
		$data['edt_sbt'] = str_replace(',', '', $edt_sbt);

		$edt_tc = $this->input->post('edt_tc');
		$data['edt_tc'] = str_replace(',', '', $edt_tc);

		$edt_appago = $this->input->post('edt_appago');
		$data['edt_appago'] = str_replace(',', '', $edt_appago);

		$edt_formato = $this->input->post('edt_formato');
		$data['edt_formato'] = $edt_formato;

		$formato = $this->input->post('adjunto');
		$data['formato'] = $formato;

		$print = $this->input->post('edt_print');
		$data['print'] = $print;

		$carpeta = 'calculadora';
		if($edt_formato == 2){
			$this->load->view($carpeta.'/ticket_pdf_2', $data);
		}else{
			$this->load->view($carpeta.'/ticket_pdf', $data);
		}
	}

	public function delete_ventaswu(){
		header('Content-type: application/json; charset=utf-8');
		$this->login();
		$id = trim($this->input->post('id'));
		$this->db->where('id', $id); 
		$this->db->delete('calculadora_transferencias');
		$arrayResp = array('status' => true,'mensaje'=>'Los datos del usuario fueron eliminados.','redirect'=>'');
		die(json_encode($arrayResp));
	}

	public function ajax_vista_ventas_tienda(){

		$this->login();
		$this->load->model('calculadora/tienda_model','tienda');

		$filtro = $this->input->post('fil');
		$arrPost = explode('|', $filtro);
		$fitrar = array();

		if(array_key_exists(0, $arrPost)){
			$dato = $arrPost[0];
			if($dato){ $fitrar['id'] = $dato; }
		}

		$fecha = '';
		if(array_key_exists(1, $arrPost)){
			$fecha = $arrPost[1];
		}

		$this->tienda->set_where($fitrar);
		$list = $this->tienda->get_datatables_venta($fecha);

		$data = array();
        $no = $this->input->post('start'); 
        foreach ($list as $obj) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $obj->nombre; 
            $row[] = number_format($obj->ot_total_venta); 
            $row[] = number_format($obj->ot_utilidad); 
            $row[] = number_format($obj->co_total_venta); 
            $row[] = number_format($obj->co_utilidad); 

            $totalVta = floatval($obj->ot_total_venta) + floatval($obj->co_total_venta);
            $totalUti = floatval($obj->ot_utilidad) + floatval($obj->co_utilidad);
            $row[] = number_format($totalVta);
            $row[] = number_format($totalUti); 
            $data[] = $row;
        }

		$output = array(
                "draw" => $this->input->post('draw'),
                "recordsTotal" => $this->tienda->count_all(),
                "recordsFiltered" => $this->tienda->count_all(),
                "data" => $data,
        );

		echo json_encode($output);
	}

	public function ajax_vista_ventas_usuario(){

		$this->login();
		$this->load->model('calculadora/login_model','usuario');

		$filtro = $this->input->post('fil');
		$arrPost = explode('|', $filtro);
		$fitrar = array();

		if(array_key_exists(0, $arrPost)){
			$dato = $arrPost[0];
			if($dato){ $fitrar['log.id'] = $dato; }
		}

		if(array_key_exists(1, $arrPost)){
			$dato = $arrPost[1];
			if($dato){ $fitrar['calculadora_tienda_id'] = $dato; }
		}

		$fecha = '';
		if(array_key_exists(2, $arrPost)){
			$fecha = $arrPost[2];
		}

		$this->usuario->set_where($fitrar);

		$list = $this->usuario->get_datatables_venta($fecha);

		$data = array();
        $no = $this->input->post('start'); 
        foreach ($list as $obj) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $obj->login.' - '.$obj->usuario; 
            $row[] = $obj->tienda; 
            $row[] = number_format($obj->ot_total_venta); 
            $row[] = number_format($obj->ot_utilidad); 
            $row[] = number_format($obj->co_total_venta); 
            $row[] = number_format($obj->co_utilidad); 

            $totalVta = floatval($obj->ot_total_venta) + floatval($obj->co_total_venta);
            $totalUti = floatval($obj->ot_utilidad) + floatval($obj->co_utilidad);
            $row[] = number_format($totalVta);
            $row[] = number_format($totalUti); 
            $data[] = $row;

            $data[] = $row;
        }

		$output = array(
                "draw" => $this->input->post('draw'),
                "recordsTotal" => $this->usuario->count_all(),
                "recordsFiltered" => $this->usuario->count_all(),
                "data" => $data,
        );

		echo json_encode($output);
	}

	/*
	public function get_ventaswu(){
		header('Content-type: application/json; charset=utf-8');
		$this->login();
		$this->load->model('calculadora/login_model','cajero');

		//$id = $this->uri->segment(3);
		$id = trim($this->input->post('id'));
		$rs = $this->cajero->get_vista($id);
		echo json_encode($rs);

	}
	*/

	/********************** CAJEROS WU *********************************/

	public function cajero(){
		$this->login();

		$this->load->model('calculadora/login_model','cajero');
		$this->load->model('calculadora/tienda_model','tienda');

		$carpeta = 'admin';
		$arr_header['usuario'] = $this->session->userdata('nombre');
		$arr_nav = array();

		$data['tmp_header'] = $this->load->view($carpeta.'/header', $arr_header, TRUE);
		$data['tmp_nav'] = $this->load->view($carpeta.'/nav', $arr_nav, TRUE);


		$data['rs_usuarios'] = $this->cajero->get_cbo();
		$data['rs_tienda'] = $this->tienda->get_cbo();
		$this->load->view($carpeta.'/cajeros_vista',$data);
	}

	public function ajax_vista_cajero(){

		$this->login();
		$this->load->model('calculadora/login_model','cajero');

		$list = $this->cajero->get_datatables();

		$data = array();
        $no = $this->input->post('start'); //$_POST['start'];
        foreach ($list as $obj) {
            $no++;
            $row = array();

            //$tipo = $this->arrayTipoDoc[$obj->tipodoc];

            $estado = '<i class="ace-icon fa fa-circle green"></i>';
            if($obj->estado == OFF){
            	$estado = '<i class="ace-icon fa fa-circle red"></i>';
            }

            $row[] = '<div class="btn-group">
	                    <button data-toggle="dropdown" class="btn btn-primary btn-sm dropdown-toggle" aria-expanded="false">
	                      <i class="fa fa-cog"></i>
	                      <span class="ace-icon fa fa-caret-down icon-on-right"></span>
	                    </button>
	                    <ul class="dropdown-menu dropdown-info">
	                      <li>
	                        <a href="#" class="btn-editar" data-id="'.$obj->id.'" ><i class="ace-icon fa fa-list-alt"></i> Editar</a>
	                      </li>
	                    </ul>
	                  </div>';
	        
            $row[] = $no;
            $row[] = $estado;
            $row[] = $obj->usuario; //0
            $row[] = $obj->nombres; // 
            $row[] = $obj->user_email; // 
            $row[] = $obj->comision_cargo.'%';
            $row[] = $obj->tc_dscto.'%'; // 
            $row[] = $obj->tienda; // 
            $row[] = $obj->supervisor; //==0?'Supervisor':$obj->supervisor;
            $formato = $obj->formato==1?'Formato1':'Formato2';
            $row[] = $formato; // 
            $row[] = $obj->fechareg_f; // 

            $row[] = $obj->ip; // 
            $row[] = $obj->ubigeo; // 
            $row[] = $obj->latlon; // 
            
            //$row[] = '<img src="'.base_url('assets/upload/catalogo/'.$obj->foto).'" alt="'.$obj->nombre.'" width="60" >'; // 
            
            $data[] = $row;
        }


		$output = array(
                "draw" => $this->input->post('draw'),
                "recordsTotal" => $this->cajero->count_all(),
                "recordsFiltered" => $this->cajero->count_filtered(),
                "data" => $data,
        );

		echo json_encode($output);
	}

	public function get_cajero(){
		header('Content-type: application/json; charset=utf-8');
		$this->login();
		$this->load->model('calculadora/login_model','cajero');

		//$id = $this->uri->segment(3);
		$id = trim($this->input->post('id'));

		$filtro = array('log.id'=>$id);
		$this->cajero->set_where($filtro);
		$rs = $this->cajero->get_vista();
		echo json_encode($rs);

	}

	public function delete_cajero(){
		header('Content-type: application/json; charset=utf-8');
		$this->login();
		$id = trim($this->input->post('id'));
		$this->db->where('id', $id); 
		//$this->db->delete('calculadora_login');
		$arrayResp = array('status' => true,'mensaje'=>'Los datos del usuario fueron eliminados.','redirect'=>'');
		die(json_encode($arrayResp));
	}

	public function grabar_cajero(){
		header('Content-type: application/json; charset=utf-8');

		$this->load->model('calculadora/login_model','cajero');
		$this->login();
		$id = trim($this->input->post('id'));

		$arrDatos = array(); $arrDatosUser = array();
		$arrDatos['id'] = $id;
		$arrDatos['usuario'] = trim($this->input->post('usuario'));
		$arrDatos['password'] = trim($this->input->post('password'));
		$arrDatos['nombres'] = trim($this->input->post('nombres'));
		$arrDatos['user_email'] = trim($this->input->post('user_email'));
		$arrDatos['calculadora_tienda_id'] = trim($this->input->post('tienda'));
		$arrDatos['comision_cargo'] = trim($this->input->post('comision_cargo'));
		$arrDatos['tc_dscto'] = trim($this->input->post('tc_dscto'));
		$arrDatos['formato'] = trim($this->input->post('formato'));
		$arrDatos['estado'] = trim($this->input->post('estado'));
		$arrDatos['login_parent'] = trim($this->input->post('login_parent'));

		if(strlen($id)==0){
			$arrDatos['fechareg'] = date('Y-m-d');
		}

		$redirect = base_url('admin/cajero');

		if(count($arrDatos)==0){
			$arrayResp = array('status' => false,'datos'=>$arrDatos,'mensaje'=>'Verifique los datos de ingresados.');
		}else{
			$this->cajero->insert($arrDatos);
			$arrayResp = array('status' => true, 'redirect'=>$redirect,'datos'=>$arrDatos, 'mensaje'=>'Los datos fueron registrados con exito.');
		}
		
		//var_dump(); die;
		die(json_encode($arrayResp));
	}


	/************************** TIENDA **************************+**/

	public function tienda(){
		$this->login();
		$this->load->model('calculadora/tienda_model','tienda');

		$carpeta = 'admin';
		$arr_header['usuario'] = $this->session->userdata('nombre');
		$arr_nav = array();

		$data['tmp_header'] = $this->load->view($carpeta.'/header', $arr_header, TRUE);
		$data['tmp_nav'] = $this->load->view($carpeta.'/nav', $arr_nav, TRUE);

		$this->load->view($carpeta.'/tienda_vista',$data);
	}

	public function ajax_vista_tienda(){

		$this->login();
		$this->load->model('calculadora/tienda_model','tienda');

		$list = $this->tienda->get_datatables();

		$data = array();
        $no = $this->input->post('start'); //$_POST['start'];
        foreach ($list as $obj) {
            $no++;
            $row = array();

            //$tipo = $this->arrayTipoDoc[$obj->tipodoc];

            $estado = '<i class="ace-icon fa fa-circle green"></i>';
            if($obj->estado == OFF){
            	$estado = '<i class="ace-icon fa fa-circle red"></i>';
            }

            $row[] = '<div class="btn-group">
	                    <button data-toggle="dropdown" class="btn btn-primary btn-sm dropdown-toggle" aria-expanded="false">
	                      <i class="fa fa-cog"></i>
	                      <span class="ace-icon fa fa-caret-down icon-on-right"></span>
	                    </button>
	                    <ul class="dropdown-menu dropdown-info">
	                      <li>
	                        <a href="#" class="btn-editar" data-id="'.$obj->id.'" ><i class="ace-icon fa fa-list-alt"></i> Editar</a>
	                      </li>
	                    </ul>
	                  </div>';
	        
            $row[] = $no;
            $row[] = $estado;
            $row[] = $obj->nombre; // 
            $row[] = $obj->direccion; //0
            
            
            $data[] = $row;
        }


		$output = array(
                "draw" => $this->input->post('draw'),
                "recordsTotal" => $this->tienda->count_all(),
                "recordsFiltered" => $this->tienda->count_filtered(),
                "data" => $data,
        );

		echo json_encode($output);
	}

	public function get_tienda(){
		header('Content-type: application/json; charset=utf-8');
		$this->login();
		$this->load->model('calculadora/tienda_model','tienda');

		//$id = $this->uri->segment(3);
		$id = trim($this->input->post('id'));

		$filtro = array('id'=>$id);
		$this->tienda->set_where($filtro);
		$rs = $this->tienda->get_vista();
		echo json_encode($rs);

	}

	public function delete_tienda(){
		header('Content-type: application/json; charset=utf-8');
		$this->login();
		$id = trim($this->input->post('id'));
		$this->db->where('id', $id); 
		//$this->db->delete('calculadora_tienda');
		$arrayResp = array('status' => true,'mensaje'=>'Los datos del usuario fueron eliminados.','redirect'=>'');
		die(json_encode($arrayResp));
	}

	public function grabar_tienda(){
		header('Content-type: application/json; charset=utf-8');
		$this->load->model('calculadora/tienda_model','tienda');
		$this->login();
		$id = trim($this->input->post('id'));

		$arrDatos = array(); $arrDatosUser = array();
		$arrDatos['id'] = $id;
		$arrDatos['nombre'] = trim($this->input->post('nombre'));
		$arrDatos['direccion'] = trim($this->input->post('direccion'));

		$redirect = base_url('admin/tienda');

		if(count($arrDatos)==0){
			$arrayResp = array('status' => false,'datos'=>$arrDatos,'mensaje'=>'Verifique los datos de ingresados.');
		}else{
			$this->tienda->insert($arrDatos);
			$arrayResp = array('status' => true, 'redirect'=>$redirect,'datos'=>$arrDatos, 'mensaje'=>'Los datos fueron registrados con exito.');
		}
		
		//var_dump(); die;
		die(json_encode($arrayResp));
	}


	/**************************TARIFARIO****************************/

	public function tarifario(){
		$this->login();

		$this->load->model('calculadora/agencia_peso_model','tarifario');

		$carpeta = 'admin';
		$arr_header['usuario'] = $this->session->userdata('nombre');
		$arr_nav = array();

		$data['tmp_header'] = $this->load->view($carpeta.'/header', $arr_header, TRUE);
		$data['tmp_nav'] = $this->load->view($carpeta.'/nav', $arr_nav, TRUE);

		$this->load->view($carpeta.'/tarifario_vista',$data);
	}

	public function ajax_vista_tarifario(){

		$this->login();
		$this->load->model('calculadora/agencia_peso_model','tarifario');
		$list = $this->tarifario->get_datatables();

		$arrTipo = array(1=>'Paquete',2=>'Sobre');

		$data = array();
        $no = $this->input->post('start'); //$_POST['start'];
        foreach ($list as $obj) {
            $no++;
            $row = array();

            $row[] = '<div class="btn-group">
	                    <button data-toggle="dropdown" class="btn btn-primary btn-sm dropdown-toggle" aria-expanded="false">
	                      <i class="fa fa-cog"></i>
	                      <span class="ace-icon fa fa-caret-down icon-on-right"></span>
	                    </button>
	                    <ul class="dropdown-menu dropdown-info">
	                      <li>
	                        <a href="#" class="btn-editar" data-id="'.$obj->id.'"><i class="ace-icon fa fa-list-alt"></i> Editar</a>
	                      </li>
	                      <!--<li>
	                        <a href="#" class="btn-eliminar" data-id="'.$obj->id.'" data-act="'.base_url('admin/delete_tarifario').'"><i class="ace-icon fa fa-close"></i> Eliminar</a>
	                      </li>-->
	                    </ul>
	                  </div>';
	        
            $row[] = $no;
            $row[] = $obj->agencia; 
            $row[] = $arrTipo[$obj->tipo]; 
            $row[] = $obj->peso;
            $row[] = $obj->zona1; 
            $row[] = $obj->zona2; 
            $row[] = $obj->zona3; 
            $row[] = $obj->zona4; 
            $row[] = $obj->zona5; 
            $row[] = $obj->zona6; 
            $data[] = $row;
        }

		$output = array(
                "draw" => $this->input->post('draw'),
                "recordsTotal" => $this->tarifario->count_all(),
                "recordsFiltered" => $this->tarifario->count_filtered(),
                "data" => $data,
        );

		echo json_encode($output);
	}

	public function get_tarifario(){
		header('Content-type: application/json; charset=utf-8');
		$this->login();
		$this->load->model('calculadora/agencia_peso_model','tarifario');

		$id = trim($this->input->post('id'));

		$filtro = array('id'=>$id);
		$this->tarifario->set_where($filtro);
		$rs = $this->tarifario->get_vista();
		echo json_encode($rs);

	}

	public function delete_tarifario(){
		header('Content-type: application/json; charset=utf-8');
		$this->login();
		$id = trim($this->input->post('id'));
		$this->db->where('id', $id); $this->db->delete('calculadora_agencia_peso');
		$arrayResp = array('status' => true,'mensaje'=>'Los datos del usuario fueron eliminados.','redirect'=>'');
		die(json_encode($arrayResp));
	}

	public function grabar_tarifario(){
		header('Content-type: application/json; charset=utf-8');
		$this->load->model('calculadora/agencia_peso_model','tarifario');
		$this->login();
		$id = trim($this->input->post('id'));

		$arrDatos = array(); $arrDatosUser = array();
		$arrDatos['id'] = $id;
		$arrDatos['calculadora_agencia_id'] = trim($this->input->post('calculadora_agencia_id'));
		$arrDatos['tipo'] = trim($this->input->post('tipo'));
		$arrDatos['peso'] = trim($this->input->post('peso'));
		$arrDatos['zona1'] = trim($this->input->post('zona1'));
		$arrDatos['zona2'] = trim($this->input->post('zona2'));
		$arrDatos['zona3'] = trim($this->input->post('zona3'));
		$arrDatos['zona4'] = trim($this->input->post('zona4'));
		$arrDatos['zona5'] = trim($this->input->post('zona5'));
		$arrDatos['zona6'] = trim($this->input->post('zona6'));
		$arrDatos['estado'] = 1;

		$redirect = base_url('admin/tarifario');
		if(count($arrDatos)==0){
			$arrayResp = array('status' => false,'datos'=>$arrDatos,'mensaje'=>'Verifique los datos de ingresados.');
		}else{
			$this->tarifario->insert($arrDatos);
			$arrayResp = array('status' => true, 'redirect'=>$redirect,'datos'=>$arrDatos, 'mensaje'=>'Los datos fueron registrados con exito.');
		}
		
		//var_dump(); die;
		die(json_encode($arrayResp));
	}



}