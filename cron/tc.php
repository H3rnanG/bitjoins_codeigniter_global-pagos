<?php 
// Crear un nuevo recurso cURL

include('simple_html_dom.php');
//die('bien');
//$html = new simple_html_dom();
$page = 'https://www.valor-dolar.cl/';

//$html = file_get_html( $page ); //file_get_html('valor-dolar.cl/');
$html = new simple_html_dom();
$html->load_file($page);
//var_dump($html); echo '------>>>> ';
//$valor = $html->find('div.valor-big'); //->plaintext;

foreach($html->find('div.valor-big') as $e)
    $valor = $e->innertext; // innertext;  //plaintext
//var_dump($valor);
//var_dump($e->children());
//echo('******** '.$valor);
$valor = str_replace("Dólar", "", $valor);
$valor = str_replace("Pesos", "", $valor);
$valor = str_replace("$", "", $valor);
$valor = str_replace("CLP", "", $valor);
$valor = str_replace("chilenos", "", $valor);
$valor = str_replace(" ", "", $valor);
$data = explode("=", $valor);
//var_dump($data); die;
//echo '<br> >>>> '.$valor.' <<<<'; 
$tc = $data[1];
$dolar = $tc; //number_format($tc, 3);
$dolar = str_replace(',', '.', $dolar);

//die('TC Actual = '.$dolar);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.astropaycard.cl/comprar/tcpe/".$dolar);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_exec($ch);
curl_close($ch);

die('TC Actual: '.$dolar);
?>