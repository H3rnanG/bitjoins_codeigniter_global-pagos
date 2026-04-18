<?php 

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://astropaycard.cl/tarjeta/alerta_inventario");
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_exec($ch);
curl_close($ch);

?>