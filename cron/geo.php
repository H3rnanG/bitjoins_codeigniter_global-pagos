<?php 

header('Content-type: application/json; charset=utf-8');

include('simple_html_dom.php');
//die('bien');
//$html = new simple_html_dom();
$page = 'https://ipinfo.io/179.6.197.15';

//$html = file_get_html( $page ); //file_get_html('valor-dolar.cl/');
$html = new simple_html_dom();
$html->load_file($page);

//json_decode($html); die;

die($html); echo '------>>>> ';
//$valor = $html->find('div.valor-big'); //->plaintext;

foreach($html->find('a.flag') as $e)
    $valor = $e->innertext; // innertext;  //plaintext


die('PAIS: '.$valor);
?>