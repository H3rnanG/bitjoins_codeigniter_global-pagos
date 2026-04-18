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

class Clientes extends CI_Controller {
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
	 var $arrayTipoDoc = array(1=>'RUT', 2=>'PASSAPORTE', 3=>'CI EXTRANJERIA');
	
	public function __construct(){
		parent::__construct();
		date_default_timezone_set('America/Santiago');

		$this->load->library('utilitario');
	} 

	private function login(){
		$idusu = $this->session->userdata('nro_rut');
		$logout = base_url('calculadora');

		if($idusu){
			$datos = array( 
							'idusu'=>$idusu
						  );
			$rs = array('status'=>true, 'datos'=>$datos, 'url'=>'', 'msj'=>'');
			//echo json_encode($rs);
		}else{
			$rs = array('status'=>false, 'datos'=>array(), 'url'=>$logout, 'msj'=>'Su sesión a expirado.');
			//echo json_encode($rs);
		}
		return $rs;
	}

	public function index(){

		$idusuario = $this->session->userdata('nro_rut'); 
		$arr_nav = array();

		$rsUsu = $this->login();	
		$swUsu = $rsUsu['status'];
		
		if($swUsu){
			$arr_header['usuario'] = $this->session->userdata('nro_rut');

			$this->load->model('transferencias/clientes_model','clientes');
			$this->load->model('transferencias/general_model','general');
			$this->load->model('transferencias/ubigeo_model','ubigeo');
			$carpeta = 'calculadora';
			
			$data['controlador'] = 'clientes';
			$data['titulo_pag'] = 'Clientes Transferencia Dinero';
			$data['tmp_header'] = $this->load->view($carpeta.'/header', $arr_header, TRUE);

			$idsupervisor = $this->session->userdata('idsupervisor');
			if($idsupervisor == 0){
				$data['tmp_nav'] = $this->load->view($carpeta.'/nav_sup', $arr_nav, TRUE);
			}else{
				$data['tmp_nav'] = $this->load->view($carpeta.'/nav', $arr_nav, TRUE);
			}

			$data['arrayTipoDoc'] = $this->arrayTipoDoc;

			$this->ubigeo->clear_where();
			$this->ubigeo->set_where(array('parent_ubigeo_id'=>'0'));
			$data['rsUbigeo'] = $this->ubigeo->get_cbo();

			$this->general->clear_where();
			$this->general->set_where(array('codtabla'=>TB_OCUP));
			$data['rsOcupacion'] = $this->general->get_cbo();

			$this->general->clear_where();
			$this->general->set_where(array('codtabla'=>TB_POEMP));
			$data['rsPosEmpleo'] = $this->general->get_cbo();

			$this->general->clear_where();
			$this->general->set_where(array('codtabla'=>TB_BENE));
			$data['rsBeneficiario'] = $this->general->get_cbo();

			$this->general->clear_where();
			$this->general->set_where(array('codtabla'=>TB_MOTTRA));
			$data['rsMotivTransac'] = $this->general->get_cbo();

			$this->general->clear_where();
			$this->general->set_where(array('codtabla'=>TB_ORIF));
			$data['rsOriFondos'] = $this->general->get_cbo();

			$this->load->view('transferencias/clientes_vista',$data);

		}else{
			$logout = $rsUsu['url'];
			header('Location: '.$logout);
		} // fin if swUsu
	}

	public function listar(){
		
		$rsUsu = $this->login();	
		$swUsu = $rsUsu['status'];
		
		if($swUsu){
			$this->load->model('transferencias/clientes_model','clientes');
			$filtro = $this->input->post('fil');
			$arrRpFiltro = array();
			if(strlen($filtro)>0){

				$arrFiltro = explode('|', $filtro);

				if($arrFiltro){
					$dt = $arrFiltro[0];
					if($dt){
						$arrRpFiltro['a.tipo_documento'] = $dt;
					}

					$dt = $arrFiltro[1];
					if($dt){
						$arrRpFiltro['a.fechareg'] = $dt;
					}
				} // fin filtro 

				//var_dump($arrRpFiltro);

				if($arrRpFiltro){
					$this->clientes->set_where($arrRpFiltro);
				} // fin if 

			} // fin if $filtro

			$list = $this->clientes->get_datatables();

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
		                        <a href="#" class="btn-editar" data-id="'.$obj->id.'" data-act="'.ACT_UPDATE.'" ><i class="ace-icon fa fa-list-alt"></i> Editar</a>
		                      </li>
		                    </ul>
		                  </div>';
	            $row[] = $no;
	            $row[] = '<a href="'.base_url('clientes/imprime_ficha/'.$obj->documento).'" target="_blank"><i class="fa fa-file-pdf-o fa-2x"></i></a>';
	            $row[] = $obj->documento; 
	            $row[] = $obj->nombres; 
	            $row[] = $obj->apellidos; 
	            $row[] = $obj->email; 
	            $row[] = $obj->genero; 
	            $row[] = $obj->fechareg; 
	            $data[] = $row;
	        }

			$output = array(
	                "draw" => $this->input->post('draw'),
	                "recordsTotal" => $this->clientes->count_all(),
	                "recordsFiltered" => $this->clientes->count_filtered(),
	                "data" => $data,
	        );

			echo json_encode($output);
		}else{
			$rsUsu['draw'] = 1;
			$rsUsu['recordsTotal'] = 0;
			$rsUsu['recordsFiltered'] = 0;
			$rsUsu['data'] = array();
			echo json_encode($rsUsu); 
		} // fin if swUsu
	}

	public function get(){
		header('Content-type: application/json; charset=utf-8');
		$rsUsu = $this->login();
		$swUsu = $rsUsu['status'];
		if($swUsu){
			$this->load->model('transferencias/clientes_model','clientes');
			$id = trim($this->input->post('id'));
			$filtro = array('a.id'=>$id);
			$this->clientes->set_where($filtro);
			$rs = $this->clientes->get_vista();
			$arrayResp = array('status' => true,'datos'=>$rs, 'msj'=>'');
			die(json_encode($arrayResp));
		}else{
			die(json_encode($rsUsu)); 
		} // fin if swUsu
	}

	public function action(){
		header('Content-type: application/json; charset=utf-8');
		
		$rsUsu = $this->login();	
		$swUsu = $rsUsu['status'];
		$arrayResp = array('status' => false, 'redirect'=>'','datos'=>array(), 'msj'=>'Datos vacios.');
		if($swUsu){
			$this->load->model('transferencias/clientes_model','clientes');
			$act = trim($this->input->post('act'));
			//die($act);
			if($act == ACT_INSERT || $act == ACT_UPDATE){
				$modelo = $this->clientes->modelo();
				$datos = $this->input->post();
				$arrDatos = array(); 
				$arrDatos = $this->utilitario->valida_campos($datos, $modelo);
				
				$fecha_emision = $arrDatos['fecha_emision'];
				$fecha_caducidad = $arrDatos['fecha_caducidad'];

				if(strlen($fecha_emision)==0){
					unset($arrDatos['fecha_emision']);
				}

				if(strlen($fecha_caducidad)==0){
					unset($arrDatos['fecha_caducidad']);
				}

				if($arrDatos){
					$arrDatos['calculadora_login_id'] = $this->session->userdata('idusuario');
					$this->clientes->insert($arrDatos, $act);
					$arrayResp = array('status' => true, 'redirect'=>base_url('clientes/'),'datos'=>$arrDatos, 'msj'=>'Los datos fueron registrados con exito.');
				}else{
					$arrayResp = array('status' => false, 'redirect'=>'','datos'=>array(), 'msj'=>'Datos vacios.');
				} // fin arrDatos
			}else if($act == ACT_DELETE){
				$id = trim($this->input->post('id'));
				$arrDatos = array('id'=>$id, 'estado'=>OFF);
				$this->clientes->insert($arrDatos, ACT_UPDATE);
				$nro = $this->clientes->delete();
				if($nro){
					$arrayResp = array('status' => true, 'redirect'=>'','datos'=>array(), 'msj'=>'Registro eliminado.');
				}else{
					$arrayResp = array('status' => false, 'redirect'=>'','datos'=>array(), 'msj'=>'No se pudo eliminar el registro.');
				}
				
			}
			die(json_encode($arrayResp));
		}else{
			die(json_encode($rsUsu)); 
		} // fin if swUsu
	}

	public function get_ubigeo_cbo(){
		header('Content-type: application/json; charset=utf-8');
		$this->load->model('transferencias/ubigeo_model','ubigeo');
		$parent_ubigeo_id = $this->input->post('id');
		$filtro = array('parent_ubigeo_id'=>$parent_ubigeo_id);
		$this->ubigeo->set_where($filtro);
		$rs = $this->ubigeo->get_cbo();

		if($rs){
			$arrayResp = array('status' => true, 'redirect'=>'','datos'=>$rs, 'msj'=>'Datos encontrados.');
		}else{
			$arrayResp = array('status' => false, 'redirect'=>'','datos'=>array(), 'msj'=>'No se encontraron datos.');
		}
		die(json_encode($arrayResp));
	}

	public function imprime_ficha(){
		$rsUsu = $this->login();

		$this->load->library('myhtml2pdf');
		$nrodoc = urldecode($this->uri->segment(3));
		$pathFont = dirname($_SERVER["SCRIPT_FILENAME"])."/assets/admin/app/fonts/cooper-hewitt/";
		//CooperHewitt-Book.otf
		$this->load->model('transferencias/clientes_model','clientes');
		//$id = trim($this->input->post('id'));
		$filtro = array('documento'=>$nrodoc);
		$this->clientes->set_where($filtro);
		$rs = $this->clientes->get_vista();

		$data = array();

		if($rs){
			$data['tipoDoc'] = $this->arrayTipoDoc;
			$data['arrGenero'] = array('M'=>'Masculino', 'F'=>'Femenino');
			$data['arrSw'] = array(0=>'Ninguno',1=>'SI',2=>'NO');
			$data['datos'] = $rs[0];

			$contenido = '<page format="A4" backimg="'.base_url('assets/admin/app/images/membrete.png').'" backtop="28mm" backbottom="22mm" backleft="20mm" backright="15mm" >'; // 
			$contenido.= $this->load->view('transferencias/print_ficha_cliente', $data, TRUE);	
			$contenido.='</page>';

			$html2pdf = new HTML2PDF('P','A4','es',true, 'UTF-8', 0);

			/*
			$html2pdf->addFont('cooperhewitt-book', '', 'cooperhewitt-book');
			$html2pdf->setDefaultFont('cooperhewitt-book');

			$html2pdf->addFont('segoeuisemibold', 'bold', 'segoeuisemibold');
			$html2pdf->addFont('segoeuibold','bold','segoeuibold');
			$html2pdf->setDefaultFont('segoeui');
			*/

			$html2pdf->pdf->SetAuthor('Global Pagos');
			$html2pdf->pdf->SetTitle('Ficha de Cliente');
	    	$html2pdf->WriteHTML($contenido);
	    	$html2pdf->Output('ficha_cliente.pdf');
		}
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
	    $path = UPLOAD.'/transferencia/';

	    $newfilename = rand(1,99999);
	    $nomarchivo = str_replace('.', '-', $archivo['name']);

	    if($archivo){
	    	$data = $this->uploader->upload($archivo, array(
		        'limit' => 1, //Maximum Limit of files. {null, Number}
		        'extensions' => array('jpg', 'jpeg', 'png', 'gif'), //Whitelist for file extension. {null, Array(ex: array('jpg', 'png'))}
		        'required' => false, //Minimum one file is required for upload {Boolean}
		        'uploadDir' => $path, //Upload directory {String}
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
	    		$archivo = base_url('assets/upload/transferencia/'.$arrDato['name']);
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

}