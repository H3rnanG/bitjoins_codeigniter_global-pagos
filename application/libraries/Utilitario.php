<?php
/*
 * Created on 09/04/2014
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php if ( ! defined('BASEPATH')) exit('No se permite acceso directo al script'); 
class Utilitario {
	protected $ci;

 function __construct(){
	$this->ci =& get_instance();
 }

 public function formatCelular($celular=''){
 	$nro = '';
 	if(strlen($celular)>0){

 		$nro = '+56'.substr($celular,-9);

 		/*$in = substr($celular, 0,3);
 		if($in == '+51'){
 			$nro = $celular;
 		}else{
 			$in = substr($celular, 0,2);
	 		if($in == '51'){
	 			$nro = '+'.$celular;
	 		}

	 		$in = substr($celular, 0,2);
	 		if($in == '51'){
	 			$nro = '+'.$celular;
	 		}
 		}
 		*/

 	} // fin if
 	return $nro;
 }

 public function getCodigo(){
 	$rand = rand(100000,999999);
	//$letter = chr(rand(65,90)).chr(rand(65,90));
	return $rand;
 }

 public function getVenta(){
 	$rand = rand(1000,9999);
	$letter = chr(rand(65,90)).chr(rand(65,90));
	$codventa = $letter.$rand;
	return $codventa;
 }

 public function getDifdate($dt1, $dt2, $frm = '%i'){
 	$datetime1 = date_create($dt1);
    $datetime2 = date_create($dt2);
    $interval = date_diff($datetime1, $datetime2);
    //var_dump($interval); die;
    $r = $interval->format($frm);
    return $r;
 }

 public function valida_campos($arrDatos = array(), $arrModelo = array()){
	$arrData = array();
	if($arrDatos){
		$arrCampos = $arrModelo['campos'];
		foreach ($arrDatos as $key => $value) {
			$rs = array_key_exists($key, $arrCampos);
			//echo $key.' - '.$value.' - '.$rs.' ---- ';
			if(array_key_exists($key, $arrCampos)){
				//echo $key.' - '.$value.' --- ';
				$opt = $arrCampos[$key];
				$longitud = $opt['length'];
				$dato = substr($value, 0, $longitud);
				$dato = trim($dato);
				$arrData[$key] = $dato;
			} // fin if 
		} // fin foreach
	} // fin if $arrDatos
	return $arrData;
}

public function getRealIP()
{

    if (isset($_SERVER["HTTP_CLIENT_IP"]))
    {
        return $_SERVER["HTTP_CLIENT_IP"];
    }
    elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
    {
        return $_SERVER["HTTP_X_FORWARDED_FOR"];
    }
    elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
    {
        return $_SERVER["HTTP_X_FORWARDED"];
    }
    elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
    {
        return $_SERVER["HTTP_FORWARDED_FOR"];
    }
    elseif (isset($_SERVER["HTTP_FORWARDED"]))
    {
        return $_SERVER["HTTP_FORWARDED"];
    }
    else
    {
        return $_SERVER["REMOTE_ADDR"];
    }

}

public function currency($from, $to, $amount)
{
   //$content = file_get_contents('https://www.google.com/finance/converter?a='.$amount.'&from='.$from.'&to='.$to);
	$content = file_get_contents('https://finance.google.com/finance/converter?a='.$amount.'&from='.$from.'&to='.$to);
	
   $doc = new DOMDocument;
   @$doc->loadHTML($content);
   $xpath = new DOMXpath($doc);
   $result = $xpath->query('//*[@id="currency_converter_result"]/span')->item(0)->nodeValue;
   return str_replace(' '.$to, '', $result);
}

 public function urlkey($string){
 	
 	$string = urldecode($string);
 	$string = trim($string);
 	$string = str_replace(' ', '-', $string);
 	//$url = preg_replace('([^A-Za-z0-9])', '', $cadena);

 	$string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $string
    );
 
    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    );
 
    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string
    );
 
    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string
    );
 
    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    );
 
    $string = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $string
    );
 
    //Esta parte se encarga de eliminar cualquier caracter extraño
    // "\", ,  "/"     """, 
    $string = str_replace(
        array("¨", "º", "~","$", "`", '*',
             "#", "@", "|", "!", "%", "&",
             "·", "(", ")", "?", "'", "¡",
             "¿", "[", "^", "<code>", "]",
             "+", "}", "{", "¨", "´",'=',
             ">", "< ", ";", ",", ":", 
             ".", " ",'/', '"'),
        '',
        $string
    );

    $string = str_replace('_', '-', $string);
    $string = str_replace('\\', '-', $string);

 	return $string;
 }

 public function crearDir($dir){
        if (!file_exists($dir)) {
            error_reporting(E_ERROR);
            mkdir($dir,0777);
            chmod($dir, 0777);
            error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
        }
 }

 public function eliminarDir($carpeta){
      foreach(glob($carpeta . "/*") as $archivos_carpeta){
          //echo $archivos_carpeta;
         if (is_dir($archivos_carpeta)){
              $this->eliminarDir($archivos_carpeta);
         }else{
             unlink($archivos_carpeta);
         }
      }

      return rmdir($carpeta);
}

 public function get_dato_array($arr, $pos, $alternativa = ''){
	$dato = '';
	if (array_key_exists($pos, $arr)){
		$dato = trim($arr[$pos]); 
	}else{
		$dato = trim($alternativa);
	}
	return $dato;
}

public function getDiaSemana($fecha) {
	//echo $fecha.' --- ';
	if(strlen($fecha)){
		$dias = array('Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
		$strFecha = date('N', strtotime($fecha));
		//echo $strFecha.' <<< ';
		$fecha = $dias[$strFecha];
	}
	return $fecha;
}

 public function genNavegacion($arrNav = array()){
 	$html = '';
 	if(count($arrNav)){
		foreach ($arrNav as $key => $fila) {
			$nombre = $fila['nombre']; 
			$submenu = $fila['submenu'];
			$parent = $fila['nivel'];
			$clsIco = $fila['ico'];
			$link = $fila['url'];

			//if($parent == 0){
				$html.='<li>';

				if(count($submenu) > 0){

					$html.= '<a href="'.base_url($link).'" class="dropdown-toggle"><i class="menu-icon fa '.$clsIco.'"></i>
					<span class="menu-text"> '.$nombre.' </span><b class="arrow fa fa-angle-down"></b></a>';
					$html.='<b class="arrow"></b>';

					$html.= '<ul class="submenu">';
					foreach ($submenu as $key => $sub) {
						$nombre = $sub['nombre']; 
						$submenu = $sub['submenu'];
						$parent = $sub['nivel'];
						$clsIco = $sub['ico'];
						$link = $sub['url'];
						if(count($submenu)){

							$html.= '<li><a href="'.base_url($link).'" class="dropdown-toggle"><i class="menu-icon fa fa-caret-right"></i>
							<span class="menu-text"> '.$nombre.' </span><b class="arrow fa fa-angle-down"></b></a>';
							$html.='<b class="arrow"></b>';

							$html.= '<ul class="submenu">';
							$html.=$this->genNavegacion($submenu);
							$html.= '</ul></li>';
							
						}else{
							$html.= '<li><a href="'.base_url($link).'"><i class="menu-icon fa '.$clsIco.'"></i>'.$nombre.'</a><b class="arrow"></b></li>';
						}
					}
					$html.= '</ul>';

				}else{

					$html.= '<a href="'.base_url($link).'"><i class="menu-icon fa '.$clsIco.'"></i>'.$nombre.'</a>
					<b class="arrow"></b>';
				}

				$html.='</li>';
			/*}else{

			}*/
		}
	}
 	return $html;
 }

 public function getFechaVencimiento($sumaDias=1){
	$strFecha = strtotime(date('Y-m-d'));
	$nuevafecha = strtotime ( '+'.$sumaDias.' day' , $strFecha) ;
	$nuevafecha = date ( 'Y-m-j' , $nuevafecha );
	//$inicio = date('w',$strFecha);
	//$strFecha = date( 'Y-m-d', $inicio + ($sumaDias*86400));
	return $nuevafecha;
 }

 public function getMes($mes){
 	$array_meses = array('01'=>'Enero','02'=>'Febrero','03'=>'Marzo','04'=>'Abril','05'=>'Mayo','06'=>'Junio','07'=>'Julio',
 						'08'=>'Agosto','09'=>'Septiembre','10'=>'Octubre','11'=>'Noviembre','12'=>'Diciembre');

 	$fecha_format = $array_meses[strval($mes)];

 	return $fecha_format;
 }

 public function getAnios(){
 	$anioActual = date('Y');
	$anioAnterior = date('Y', strtotime('-1 year'));
	$arrAnios = array($anioAnterior,$anioActual);
	return $arrAnios;
 }

 public function getRangoMeses($mPasados, $mSiguientes){
 	$arrMeses = array();

 	for ($i=$mPasados; $i >= 1; $i--) { 
 		$mes = date('m',strtotime("-".$i." month"));
		$arrMeses[strval($mes)] = $this->getMes(date('m',strtotime("-".$i." month")));
	}

	$mes = date('m');
	$arrMeses[strval($mes)] = $this->getMes(date('m'));

	for ($i=1; $i <= $mSiguientes; $i++) {
		$mes = date('m',strtotime("+".$i." month"));
		$arrMeses[strval($mes)] = $this->getMes(date('m',strtotime("+".$i." month")));
	}

	return $arrMeses;
 }

 public function getFormatFecha($fecha)
 {
 	$arrFecha = explode('-',$fecha);
 	$array_meses = array('01'=>'Enero','02'=>'Febrero','03'=>'Marzo','04'=>'Abril','05'=>'Mayo','06'=>'Junio','07'=>'Julio',
 						'08'=>'Agosto','09'=>'Septiembre','10'=>'Octubre','11'=>'Noviembre','12'=>'Diciembre');
 	
 	$fecha_format = $arrFecha[2].' '.$array_meses[strval($arrFecha[1])].' de '.$arrFecha[0]; 
 	return $fecha_format;
 }

 public function getFormatRangoFecha($fecha=''){

 	$arrayFechas = array();
 	if(strlen($fecha)>0)
	{
		$arrFecha = explode(" - ", $fecha);
		//var_dump($arrFecha);die;
		$fec1 = $this->getInvertirFecha(trim($arrFecha[0]));
		$fec2 = $this->getInvertirFecha(trim($arrFecha[1]));
		$arrayFechas = array(0 => $fec1, 1=>$fec2);
	}
	return $arrayFechas;
 }

 public function getInvertirFecha($fecha){
 	$cadena = '';
 	
 	if(strlen($fecha)>0)
 	{
 		$arrFecha = explode('-',$fecha);
 		$cadena = $arrFecha[2].'-'.$arrFecha[1].'-'.$arrFecha[0];
 	}
 	return $cadena;
 	
 }

 public function getInvertirFechaFormat2($fecha){
 	$cadena = '';
 	
 	if(strlen($fecha)>0)
 	{
 		$arrFecha = explode('-',$fecha);
 		$cadena = $arrFecha[2].'-'.$arrFecha[1].'-'.$arrFecha[0];
 	}
 	return $cadena;
 	
 }

 public function getAliasTablas($campo){
 	$nomCampo = '';

 	$alias = explode(':', $campo);
 	$campo = $alias[1];
 	$alias = $alias[0]; 
 	
 	$arrayTablas = array('oc' => 'orden_compra',
 						 'linart' => 'linea_articulo',
 						 'prov' => 'proveedor',
 						 'art' => 'articulos',
 						 'tipserv' => 'tipo_servicios',
 						 'estofer'=>'estados_oferta'
 						);

 	$rsSW = array_key_exists($alias, $arrayTablas);
 	if($rsSW === true){
 		$nomCampo = $arrayTablas[$alias].'.'.$campo;
 	}
 	return $nomCampo;
 }

 public function getFiltros($arrPost){

 	$filtros = array();
 	//var_dump($arrPost);die;
 	if(count($arrPost)>0){
 		foreach ($arrPost as $key => $value) {
 			$strPos = strripos($key,':');

 			if($strPos === false){
 				$nomCampo = $key;
 			}else{
 				$nomCampo = $this->getAliasTablas($key);
 			}

 			if(is_array($value)){
 				foreach ($value as $k => $dato) {
 					$arrCampo[$k] = $dato;
 				}
 				$filtros[$nomCampo] = $arrCampo;
 			}else if(strlen($value)>0){
 				$filtros[$nomCampo] = $value;	
 			}
 		}
 	}
 	
 	return $filtros;
 }

 public function limpiaCadena($cadena){

 	$order   = array("\r\n", "\n", "\r"); //"[\n|\r|\n\r|\t|\0|\x0B]"
	$replace = '';
 	$cadena = str_replace($order, $replace, $cadena);
 	return $cadena;
 }

 public function getCampos($arrPost){

 	$filtros = array();
 	if(count($arrPost)>0){
 		foreach ($arrPost as $key => $value) {
 			$strPos = strripos($key,':');

 			if($strPos === false){
 				$nomCampo = $key;
 			}else{
 				$nomCampo = $this->getAliasTablas($key);
 			}

 			/*
 			if(is_array($value)){

 			}else if(strlen($value)>0){
 					
 			}
 			*/
 			$filtros[$nomCampo] = $this->limpiaCadena($value);
 			//$filtros[$nomCampo] = $value;
 			
 		}
 	}
 	
 	return $filtros;

 }

public function get_tc(){
	$this->ci->db->from('constantes');
	$this->ci->db->where('id',TC);
	$query = $this->ci->db->get(); 
	$rs = $query->result();
	$tc = 3;

	if($rs){
		$tc = $rs[0]->variable;
	}

	$this->ci->db->from('constantes');
	$this->ci->db->where('id',UTILIDAD);
	$query = $this->ci->db->get(); 
	$rs = $query->result();
	$uti = 0.1;
	if($rs){
		$uti = $rs[0]->variable;
	}
	$tc = $tc + $uti;
	return $tc;

}

public function get_tipocambio(){
	$this->ci->db->from('constantes');
	$this->ci->db->where('id',TC);
	$query = $this->ci->db->get(); 
	$rs = $query->result();
	$tc = 3;

	if($rs){
		$tc = $rs[0]->variable;
	}
	return $tc;
}

public function get_factorfdx(){
	$this->ci->db->from('constantes');
	$this->ci->db->where('id',FDXFACTOR);
	$query = $this->ci->db->get(); 
	$rs = $query->result();
	$uti = 0.1;
	if($rs){
		$uti = $rs[0]->variable;
	}

	if($uti > 0){
		$uti = $uti / 100;	
	}
	return $uti;
}

public function validacion($arrDatos = array(),$modelo = array(),$id=''){

	$arrayData = array('error' => false, 'campos'=>'');

	if(count($arrDatos)>0){

		$tabla = $modelo['tabla'];
		$campos = $modelo['campos'];

	    foreach ($arrDatos as $key => $value) {

	        if(array_key_exists($key,$campos)===true){
	            
	            $strValidacion = $campos[$key];

	            if(strlen($strValidacion)>0){
	            	$arrayVal = explode('|',$strValidacion);

	            	foreach ($arrayVal as $opc) {
	            		switch ($opc){

	            			case 'required':
	            				if(strlen($value) == 0){
	            					$mensaje = 'Este campo es esta vacio, es necesario llenarlo.';
	            					$arrayData['error'] = true;
	            					$arrayData['campos'][$key] = $mensaje;
	            				}
	            				break;

	            			case 'unique':
	            				if(strlen($value)>0){
	            					if(strlen($id)>0){
	            						$this->ci->db->where_not_in('id', array($id));
	            					}
	            					$this->ci->db->where($key,$value);
		            				$resultado = $this->ci->db->count_all_results($tabla);
		            				//die($this->db->last_query());

		            				if($resultado > 0){
		            					$mensaje = 'No se pudo registrar el dato ingresado debido a que ya existe.';
		            					$arrayData['error'] = true;
		            					$arrayData['campos'][$key] = $mensaje;
		            				}
		            				break;
	            				}
	            		}
	            	}
	            } // fin 
	        } // fin if array key exists
	    } // fin foreach 
	}
	return $arrayData;
}


}
 /* Fin del archivo */