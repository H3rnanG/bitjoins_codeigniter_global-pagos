
<style type="text/css">
	table{
	  /*font-family: cooperhewitt-book;*/
	  font-size: 12px;
	  color: #2D2D2D;
	  margin: 30px auto 0px auto;
	}
	
	.col{
		/*border: 1px solid black;*/
		width: 145px;
	}

	.col_dbl{
		width: 300px;
	}

	.col1{
		padding: 5px;
		line-height: 15px;
		height: 15px;
		vertical-align: top;
	}

	.titulo{
		background-color: #004aad;
		color: #FFFFFF;
		height: 20px;
		line-height: 20px;
		text-align: center;
		font-size: 16px;
		font-weight: bold;	
	}

	.tbfirma{
		margin: 40px 0px 0px 0px;
	}

	.celdafirma{
		border-top: 1px solid #000000;
		text-align: center;
	}

	
</style>

<page_header>

</page_header>

<table class="tbl">
	<tr>
		<td class="titulo" colspan="4">DOCUMENTO DE IDENTIFICACIÓN</td>
	</tr>
	<tr>
		<td class="col col1"><strong>Tipo Doc:</strong><br><?php echo $tipoDoc[$datos['tipo_documento']]; ?></td>
		<td class="col col1"><strong>N° Documento:</strong><br><?php echo $datos['documento'] ?></td>
		<td class="col col1"><strong>Fecha Emisión:</strong><br><?php echo $datos['fecha_emision_f'] ?></td>
		<td class="col col1"><strong>Fecha Caducidad:</strong><br><?php echo $datos['fecha_caducidad_f'] ?></td>
	</tr>
	<tr>
		<td><br></td>
	</tr>
	<tr>
		<td class="titulo" colspan="4">DATOS PERSONALES</td>
	</tr>
	<tr>
		<td class="col1" colspan="2"><strong>Nombres:</strong><br><?php echo $datos['nombre'].' '.$datos['nombre2'] ?></td>
		<td class="col1"><strong>Apellidos:</strong><br><?php echo $datos['apellido_paterno'].' '.$datos['apellido_materno'] ?></td>
	</tr>
	<tr>
		<td class="col1"><strong>Fecha Nacimiento:</strong><br><?php echo $datos['fecha_nacimiento_f']; ?></td>
		<td class="col1"><strong>País Nacimiento:</strong><br><?php echo $datos['pais_nacimiento']; ?></td>
		<td class="col1"><strong>Nacionalidad:</strong><br><?php echo $datos['nacionalidad']; ?></td>
		<td class="col1"></td>
	</tr>
	<tr>
		<td class="col1" colspan="2"><strong>E-mail:</strong><br><?php echo $datos['email']; ?></td>
		<td class="col1" colspan="2"><strong>Género:</strong><br><?php echo $arrGenero[$datos['genero']]; ?></td>
	</tr>
	<tr>
		<td class="col1" colspan="4"><strong>Comentarios:</strong><br><?php echo $datos['comentarios']; ?></td>
	</tr>
	<tr>
		<td><br></td>
	</tr>
	<tr>
		<td class="titulo" colspan="4">DIRECCIÓN</td>
	</tr>
	<tr>
		<td class="col1 col_dbl" colspan="2"><strong>Dirección:</strong><br><?php echo $datos['direccion1']; ?></td>
		<td class="col1 col_dbl" colspan="2"><strong>Dirección 2:</strong><br><?php echo $datos['direccion2']; ?></td>
	</tr>
	<tr>
		<td class="col1"><strong>País:</strong><br><?php echo $datos['pais']; ?></td>
		<td class="col1"><strong>Estado:</strong><br><?php echo $datos['estado_ch']; ?></td>
		<td class="col1"><strong>Ciudad:</strong><br><?php echo $datos['ciudad']; ?></td>
		<td class="col1"><strong>Código postal:</strong><br><?php echo $datos['codigo_postal']; ?></td>
	</tr>
	<tr>
		<td class="col1"><strong>Código teléfono 1:</strong><br><?php echo $datos['cod_telefono1']; ?></td>
		<td class="col1"><strong>Número telefono 1:</strong><br><?php echo $datos['num_telefono_1']; ?></td>
		<td class="col1"><strong>Código teléfono 2:</strong><br><?php echo $datos['cod_telefono2']; ?></td>
		<td class="col1"><strong>Número telefono 2:</strong><br><?php echo $datos['num_telefono_2']; ?></td>
	</tr>
	<tr>
		<td><br></td>
	</tr>
	<tr>
		<td class="titulo" colspan="4">ENVÍO EN NOMBRE DE UNA TERCERA PERSONA</td>
	</tr>
	<tr>
		<td class="col1 col_dbl" colspan="2"><strong>¿Envía el dinero en nombre de una tercera persona?</strong><br><?php echo $arrSw[$datos['sw_tercera_persona']]; ?></td>
		<td class="col1 col_dbl" colspan="2"><strong>¿Transacción sospechosa o inusual?</strong><br><?php echo $arrSw[$datos['sw_trans_sospechosa']]; ?></td>
	</tr>
	<tr>
		<td class="col1" colspan="2"><strong>¿Es una persona expuesta políticamente?</strong><br><?php echo $arrSw[$datos['sw_perexp_politicamente']]; ?></td>
		<td colspan="2"></td>
	</tr>
	<tr>
		<td><br></td>
	</tr>
	<tr>
		<td class="titulo" colspan="4">INFORMACIÓN ADICIONAL</td>
	</tr>
	<tr>
		<td class="col1 col_dbl" colspan="2"><strong>Ocupación:</strong><br><?php echo $datos['ocupacion']; ?></td>
		<td class="col1 col_dbl" colspan="2"><strong>Nivel de posición de empleo:</strong><br><?php echo $datos['posicion_empleo']; ?></td>
	</tr>
	<tr>
		<td class="col1 col_dbl" colspan="2"><strong>Relación con el beneficiario:</strong><br><?php echo $datos['relacion_beneficiario']; ?></td>
		<td class="col1 col_dbl" colspan="2"><strong>Motivo de la transacción:</strong><br><?php echo $datos['motivo_transaccion']; ?></td>
	</tr>
	<tr>
		<td><br></td>
	</tr>
	<tr>
		<td class="titulo" colspan="4">DATOS DE LOS RECURSOS</td>
	</tr>
	<tr>
		<td class="col1 col_dbl" colspan="2"><strong>El agente verificó los datos del cliente y la credencial proporcionada</strong><br><?php echo $arrSw[$datos['sw_datos_verificados']]; ?></td>
		<td class="col1"><strong>Origen de los fondos:</strong><br> <?php echo $datos['origen_fondos']; ?></td>
		<td class="col1"><strong>Fecha Registro:</strong><br> <?php echo $datos['fechareg_f']; ?></td>
	</tr>
</table>

<table class="tbfirma">
	<tr>
		<td class="col1 celdafirma">
			FIRMA DEL CLIENTE
		</td>
	</tr>
</table>
