<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {

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
		die('ACCESO RESTRINGIDO');
	}

	public function masvendido(){
		header('Content-type: application/json; charset=utf-8');
		$this->load->model('producto_model','producto');
		$rsProducto = $this->producto->get_mas_vendidos();
		echo json_encode($rsProducto, JSON_FORCE_OBJECT | JSON_HEX_TAG | JSON_HEX_APOS);
	}

	public function getcolores(){
		header('Content-type: application/json; charset=utf-8');
		$this->load->model('Producto_model','producto');
		
		$prodID = $this->uri->segment(3);
		$rs = $this->producto->get_galeria($prodID, COLORES);
		echo json_encode($rs, JSON_FORCE_OBJECT | JSON_HEX_TAG | JSON_HEX_APOS);
	}

	public function getgaleria(){
		header('Content-type: application/json; charset=utf-8');
		$this->load->model('Producto_model','producto');

		$prodID = $this->uri->segment(3);
		$rs = $this->producto->get_galeria($prodID);
		echo json_encode($rs, JSON_FORCE_OBJECT | JSON_HEX_TAG | JSON_HEX_APOS);
	}

	public function getatributo(){
		header('Content-type: application/json; charset=utf-8');
		$this->load->model('Producto_model','producto');
		
		$id = $this->uri->segment(3);
		$rs = $this->producto->get_atributo($id);
		echo json_encode($rs, JSON_FORCE_OBJECT | JSON_HEX_TAG | JSON_HEX_APOS);
	}

	public function delcart(){
		header('Content-type: application/json; charset=utf-8');
		$prodID = $this->uri->segment(3);
		$seCarrito = $this->session->tempdata('pbk_carrito');
		//var_dump($seCarrito); die;

		if($seCarrito){
			if(array_key_exists('carrito', $seCarrito)){
				foreach ($seCarrito['carrito'] as $key => $fila) {
					//var_dump($fila);
					if($prodID == $fila['id']){
						$cantFila = $fila['cantidad'];
						$totalFila = $fila['total'];

						$cartItems = $seCarrito['items'];
						$cartTotal = $seCarrito['total'];

						$seCarrito['items'] = $cartItems - $cantFila;
						$seCarrito['total'] = $cartTotal - $totalFila;						

						unset($seCarrito['carrito'][$key]);
					}
				}
			}
		}

		$this->session->set_tempdata('pbk_carrito', $seCarrito, SE_CARRITO);
		echo json_encode($this->session->tempdata('pbk_carrito'), JSON_FORCE_OBJECT | JSON_HEX_TAG | JSON_HEX_APOS);
	}

	public function editcart(){
		header('Content-type: application/json; charset=utf-8');
		$this->load->model('producto_model','producto');
		$this->load->library('utilitario');

		$prodID = trim($this->input->post('id'));
		$prodCant = trim($this->input->post('cantidad'));

		$seCarrito = $this->session->tempdata('pbk_carrito');
		$carrito = array('carrito'=>array(),'items'=>'0','total'=>'0','msj'=>'','key'=>'');

		if(strlen($prodID) >0 && strlen($prodCant) >0)
		{

			$arrProd = $this->producto->get_vista($prodID);
			if(array_key_exists('precio', $arrProd)){
				$prodPrec = $arrProd['precio'];
			}else{
				$prodPrec = 0;
			}

			$prodTotal = $prodCant * $prodPrec;
			$swUpdate = false; $cant = 0; $subt = 0;

			if($seCarrito)
			{
				if(array_key_exists('carrito', $seCarrito))
				{

					$carrito = $seCarrito;
					$totalItems = $carrito['items'];

					if(count($carrito['carrito'])){
						foreach ($carrito['carrito'] as $k=>$prod) {
						
							if($prod['id'] == $prodID){
								
								$histProdCant = $carrito['carrito'][$k]['cantidad'];
								$histProdTot = $carrito['carrito'][$k]['total'];

								$carrito['carrito'][$k]['cantidad'] = $prodCant;
								$carrito['carrito'][$k]['precio'] = $prodPrec;
								$carrito['carrito'][$k]['total'] = number_format($prodTotal,2,'.','');

								$cant = ($totalItems - $histProdCant) + $prodCant;
								$subt = $cant * $prodPrec;
								$carrito['total'] = number_format(($carrito['total'] - $histProdTot) + $subt,2,'.','');
								$carrito['items'] = $cant;
								$carrito['msj'] = 'El Item fue actualizado.';

								$swUpdate = true;
								break;
							}
						}
					}
				}
			}
		} // fin if 

		$this->session->set_tempdata('pbk_carrito', $carrito, SE_CARRITO);
		echo json_encode($this->session->tempdata('pbk_carrito'), JSON_FORCE_OBJECT | JSON_HEX_TAG | JSON_HEX_APOS);
	}

	public function addcart(){
		header('Content-type: application/json; charset=utf-8');
		$this->load->model('producto_model','producto');
		$this->load->library('utilitario');
		//session_destroy(); die;

		/*
		$prodID = $this->input->post_get('prodid');
		$prodCant = $this->input->post_get('prodcant');
		*/

		$prodID = trim($this->input->post('id'));
		$prodCant = trim($this->input->post('cantidad'));
		$prodFoto = trim($this->input->post('foto'));

		$prodColor = $this->utilitario->urlkey(trim($this->input->post('color')));
		$prodTalla = $this->utilitario->urlkey(trim($this->input->post('talla')));
		$prodAtr = '';

		if(strlen($prodColor)>0){
			$prodAtr = $prodColor;
		}

		if(strlen($prodTalla)>0){
			if(strlen($prodAtr)>0){
				$prodAtr = $prodAtr.'---'.$prodTalla;
			}else{
				$prodAtr = $prodTalla;
			}
		}
		//die($prodID.' - '.$prodCant.' - '.$prodFoto);

		$seCarrito = $this->session->tempdata('pbk_carrito');
		$carrito = array('carrito'=>array(),'items'=>'0','total'=>'0','costo-envio'=>'0','msj'=>'','key'=>'');

		if(strlen($prodID) >0 && strlen($prodCant) >0){

			$arrProd = $this->producto->get_vista($prodID);
			if(array_key_exists('precio', $arrProd)){
				$prodPrec = $arrProd['precio'];
			}else{
				$prodPrec = 0;
			}

			$prodTotal = $prodCant * $prodPrec;
			

			$swUpdate = false; $cant = 0; $subt = 0;

			if($seCarrito){
				//die('carrito existe');
				if(array_key_exists('carrito', $seCarrito)){

					$carrito = $seCarrito;
					$totalItems = $carrito['items'];

					if(count($carrito['carrito'])){
						foreach ($carrito['carrito'] as $k=>$prod) {
						
							if($prod['id'] == $prodID && $prod['atributos'] == $prodAtr){
								
								//echo $k.' -> '.$prod['id']." == ".$prodID." **** ";
								$histProdCant = $carrito['carrito'][$k]['cantidad'];
								$histProdTot = $carrito['carrito'][$k]['total'];

								$carrito['carrito'][$k]['cantidad'] = $prodCant;
								$carrito['carrito'][$k]['precio'] = $prodPrec;
								$carrito['carrito'][$k]['total'] = number_format($prodTotal,2,'.','');
								//$carrito['carrito'][$k]['atributos'] = $prodAtr;

								$cant = ($totalItems - $histProdCant) + $prodCant;
								$subt = $cant * $prodPrec;
								$filaTotal = $carrito['total'] + $subt;
								$carrito['total'] = number_format($filaTotal,2,'.','');

								if($filaTotal > 500){
									$carrito['costo-envio'] = '0';
								}else{
									$carrito['costo-envio'] = '15.00';
								}
								$carrito['items'] = $cant;
								$carrito['msj'] = 'El Item fue actualizado.';

								$swUpdate = true;
								break;
							}
						}

						if($swUpdate === false){
							if(strlen($prodID) > 0){
								$prodFoto = trim($prodFoto);
								$foto = base_url('assets/upload/catalogo/'.$prodFoto);
								$arrItemProd = array('id'=>$prodID,
													 'sku'=>$arrProd['sku'],
													 'foto'=>$prodFoto,
													 'producto'=>$arrProd['nombre'],
													 'atributos'=>$prodAtr,
													 'precio'=>$prodPrec,
													 'cantidad'=>$prodCant,
													 'total'=>number_format($prodTotal,2,'.',''),
													 'imagen'=>$foto
													);

								$subt = $prodCant * $prodPrec;
								$filaTotal = $carrito['total'] + $subt;
								$carrito['total'] = number_format($filaTotal,2,'.','');

								if($filaTotal > 500){
									$carrito['costo-envio'] = '0';
								}else{
									$carrito['costo-envio'] = '15.00';
								}
								$carrito['items'] = $carrito['items'] + $prodCant;
								$carrito['msj'] = 'El Item fue agregado correctamente.';
								array_push($carrito['carrito'], $arrItemProd);
							}
						}

					}else{
						//echo $k.' ->>> '.$prodID.' ** ';
						if(strlen($prodID) > 0){
							$prodFoto = trim($prodFoto);
							$foto = base_url('assets/upload/catalogo/'.$prodFoto);
							$arrItemProd = array('id'=>$prodID,
												 'sku'=>$arrProd['sku'],
												 'foto'=>$prodFoto,
												 'producto'=>$arrProd['nombre'],
												 'atributos'=>$prodAtr,
												 'precio'=>$prodPrec,
												 'cantidad'=>$prodCant,
												 'total'=>number_format($prodTotal,2,'.',''),
												 'imagen'=>$foto
												);

							$subt = $prodCant * $prodPrec;
							$filaTotal = $carrito['total'] + $subt;
							$carrito['total'] = number_format($filaTotal,2,'.','');

							if($filaTotal > 500){
								$carrito['costo-envio'] = '0';
							}else{
								$carrito['costo-envio'] = '15.00';
							}
							
							$carrito['items'] = $carrito['items'] + $prodCant;
							$carrito['msj'] = 'El Item fue agregado correctamente.';
							array_push($carrito['carrito'], $arrItemProd);
						}
					} // fin if count
				} // if carrito
			}else{
				
				if(strlen($prodID) > 0){
					$prodFoto = trim($prodFoto);
					$foto = base_url('assets/upload/catalogo/'.$prodFoto);
					$arrItemProd = array('id'=>$prodID,
										 'sku'=>$arrProd['sku'],
										 'foto'=>$prodFoto,
										 'producto'=>$arrProd['nombre'],
										 'atributos'=>$prodAtr,
										 'precio'=>$prodPrec,
										 'cantidad'=>$prodCant,
										 'total'=>number_format($prodTotal,2,'.',''),
										 'imagen'=>$foto
										);
									
					$subt = $prodCant * $prodPrec;

					$filaTotal = $carrito['total'] + $subt;
					$carrito['total'] = number_format($filaTotal,2,'.','');

					if($filaTotal > 500){
						$carrito['costo-envio'] = '0';
					}else{
						$carrito['costo-envio'] = '15.00';
					}
					$carrito['items'] = $prodCant;
					$carrito['msj'] = 'El Item fue agregado correctamente.';
					array_push($carrito['carrito'], $arrItemProd);
				}
			} // fin seCarrito
		} // if prodID - prodCant

		$this->session->set_tempdata('pbk_carrito', $carrito, SE_CARRITO);

		echo json_encode($this->session->tempdata('pbk_carrito'), JSON_FORCE_OBJECT | JSON_HEX_TAG | JSON_HEX_APOS);

	}
	
}
