<!--
<div class="banner-interna">
	<img src="<?php //echo base_url('assets/images/banner/banner-registrarse.jpg') ?>" alt="Contacto Astropay" width="100%" >
</div>

 SECCIÓN -->

	<div class="container">

		<form name="frmdatos" id="frmdatos" method="post" action="<?php echo base_url('usuario/confirmaregistro') ?>" >
		<div class="msj"></div>
		<!-- Text input-->
		<br>
		<h2><u>Complete sus datos con información veraz para su perfil de usuario, completando los datos correctamente no tendra inconvenientes para comprar sus tarjetas:</u></h2><br>
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario ?>">
					<input type="hidden" name="token" id="token" value="<?php echo $token ?>">

					<label class="control-label">Dirección</label>  
				    <div class="inputGroupContainer">
					    <div class="input-group">
					        <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
					  		<input name="direccion" id="direccion" placeholder="Dirección" class="form-control"  type="text" tabindex="1"  maxlength="200" >
					    </div>
				  	</div>
				</div>
			</div>

			<div class="col-sm-3">
				<label class="control-label">Comuna - Región</label>  
				<input type="text" maxlength="150" name="distrito" id="distrito" class="form-control" tabindex="2" maxlength="150">
			</div>
			
			<div class="col-sm-3">
				<div class="form-group">
					<label class="control-label">Nacionalidad</label>  
				    <div class="inputGroupContainer">
					    <div class="input-group">
					        <span class="input-group-addon"><i class="fa fa-flag"></i></span>
					  		<input name="nacionalidad" id="nacionalidad" placeholder="Nacionalidad" class="form-control"  type="text" tabindex="6"  maxlength="50" >
					    </div>
				  	</div>
				</div>
			</div>

		</div>

		<div class="row">
			<div class="col-sm-4">
				<div class="form-group">
					<label class="control-label">Teléfono Fijo</label>  
				    <div class="inputGroupContainer">
					    <div class="input-group">
					        <span class="input-group-addon"><i class="fa fa-phone"></i></span>
					  		<input name="telefono" id="telefono" placeholder="Teléfono Fijo" class="form-control"  type="text" tabindex="3" maxlength="12" >
					    </div>
				  	</div>
				</div>
			</div>

			<div class="col-sm-4">
				<div class="form-group">
					<label class="control-label">Tipo Doc:</label>  
				    <select name="tipodoc" id="tipodoc" class="form-control" tabindex="4">
				    	<option value="1">CEDULA DE IDENTIDAD</option>
				    	<option value="2">PASSAPORTE</option>
				    	<option value="3">CEDULA DE IDENTIDAD EXTRANJEROS</option>
				    </select>
				</div>
			</div>

			<div class="col-sm-4">
				<div class="form-group">
					<label class="control-label">Nº Documento:</label>  
				    <div class="inputGroupContainer">
					    <div class="input-group">
					        <span class="input-group-addon"><i class="fa fa-list-alt"></i></span>
					  		<input name="documento" id="documento" placeholder="Nº Documento" class="form-control" type="text" tabindex="5"  maxlength="15">
					    </div>
				  	</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-3">
				<button type="submit" class="btn btn-danger" tabindex="7"><i class="fa fa-send"></i> CONFIRMAR DATOS</button>	
			</div>
			<div class="col-sm-6">
				<div class="checkbox">
				    <label>
				      <a href="#"  data-toggle="modal" data-target="#myModalTerminos" ><u>Debe leer y aceptar los terminos y condiciones del servicio.</u></a> &nbsp; <input type="checkbox" name="chktermino" id="chktermino" class="checkbox-lg" tabindex="8" > 
				    </label>

			  	</div>
			</div>
			<div class="col-sm-3 text-right">
				<a href="<?php echo base_url('comprar'); ?>" class="btn btn-inverse" >CONTINUAR <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>

		<br><br>

		<div id="myModalTerminos" class="modal fade" tabindex="-1" role="dialog">
		  <div class="modal-dialog modal-lg" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		      	<h4 class="modal-title">TERMINOS Y CONDICIONES</h4>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		      </div>
		      <div class="modal-body">
		        <textarea name="terminos" id="terminos" class="form-control" rows="18" readonly>ACUERDO
El presente texto (EN ADELANTE EL ACUERDO) tiene como finalidad hacer de su conocimiento  los términos y condiciones a los que se somete al adquirir una tarjeta virtual AstroPay Card.
El acuerdo regula la relación entre usted, ( EN ADELANTE EL USUARIO)  Loctel SPA ( EN ADELANTE EL INTERMEDIARIO) y el proveedor de servicios de pago, AstroPay Card ( EN ADELANTE: EL PROVEEDOR), para los fines de la prestación del servicio y uso AstroPay  Card. 
a.- Al registrarse en el servicio de pago en línea AstroPay card, el  usuario acepta cumplir con los términos del ACUERDO, y acepta que estos términos sean legales y que le son vinculantes.
b.- Para celebrar ser parte del acuerdo, es necesario actuar bajo el Principio de Veracidad, y toda declaración realizada por EL USUARIO se presume cierta.
c.- Para  configurar EL ACUERDO,  EL USUARIO debe tener como mínimo  18 años de edad y debe estar domiciliado en un país donde el registro y el uso del servicio como AstroPay card, no infrinja las leyes o regulaciones de ese país y su jurisdicción. 
d.- Al solicitar nuestros servicios y considerar configurar  EL ACUERDO, EL USUARIO se somete a las siguientes condiciones: 
El Usuario declara  lo siguiente:
a.	El Usuario declara que el origen de los fondos no es producto de actividades ilícitas y que el destino de la  tarjeta AstroPay card tampoco tiene relación con alguna actividad ilegal.

b.  EL USUARIO  manifiesta   que los datos proporcionados AL INTERMEDIARIO para realizar la compra de la tarjeta AstroPay card  y que constan en este Acuerdo , son fidedignos. 
 
c. Queda liberado el INTERMEDIARIO de toda responsabilidad por el mal uso de la tarjeta Astropay card.

d. El USUARIO declara conocer que la cuenta bancaria donde depositó sus fondos,  para adquirir la tarjeta Astropay card pertenece AL INTERMEDIARIO, y no al sitio web donde desea ingresar  la tarjeta Astropay card.
 
e. El INTERMEDIARIO recibe fondos en su cuenta bancaria del usuario exclusivamente para la compra y venta de las tarjetas Astropay card.

f. Una vez que el USUARIO ingrese la tarjeta al sitio web, los fondos de la Astropay card pasaran instantáneamente a dicha plataforma web.

g.El INTERMEDIARIO nunca solicitará las claves bancarias al usuario, para la compra de la Astropay card.

i. Para compras de tarjetas AstroPay card mayores a usd 3000, El INTERMEDIARIO, enviara vía correo electrónico, una declaración de fondos.
h. Esta declaración deberá  ser  firmada por el USUARIO, previo a la  transacción y posterior  venta de la tarjeta Astropay card
j. Asimismo, el USUARIO asume cualquier responsabilidad derivada de  reclamaciones sea falsas, y responsabilidad penal en caso de transacciones dudosas y peligrosas que efectúe.


PRECISIONES Y ESPECIFICACIONES ADICIONALES QUE CONTIENE EL ACUERDO:

EL ACUERDO se define además en los siguientes términos y condiciones para el uso por parte del USUARIO de un servicio de pago en línea (AstroPay card).
El servicio consiste en lo siguiente: 
Se le otorga al USUARIO el uso de una cuenta (la Cuenta AstroPay card) a través de la cual  puede comprar una Tarjeta  AstroPay card  (LA TARJETA),a fin  que pueda utilizarla posteriormente, para realizar transacciones de pago en línea con el PROVEDOR y con terceros.
EL INTERMEDIARIO proporcionará AL USUARIO los medios para realizar transacciones de pago en línea con la Tarjeta.
Debiendo considerar que EL INTERMEDIARIO no asume ningún tipo de responsabilidad de los sitios web donde el USUARIO ingrese la tarjeta, quien además es responsable exclusivo del uso que realice con las tarjetas AstroPay que adquiera a través de nuestra plataforma.
Por el  presente comunicado y al adquirir nuestro servicio, una vez depositados  los fondos solicitados a través de la tarjeta virtual, renuncia a cualquier reclamo hacia EL INTERMEDIARIO, al reconocer de antemano, que no tiene responsabilidad del uso de la tarjeta AstroPay card, en las diferentes plataformas virtuales disponibles. 

ACERCA DE LAS ESTIPULACIONES PREEXISTENTES:

1. Registro:

1.1 Para comprar una Tarjeta AstroPay card, EL USUARIO primero debe registrarse para el servicio y abrir una cuenta AstroPay que luego será considerada como  la asumida  por el USUARIO.

1.2 A cada USUARIO se le permite tener solo una cuenta de AstroPay card a la vez, a menos que el PROVEEDOR  o INTERMEDIARIO,  le dé un permiso por escrito para hacerlo. 
EL INTERMEDIARIO   se reserva el derecho de tomar medidas para prevenir o rectificar dicha ocurrencia, incluido el cierre de la cuenta.

1.3 Para registrarse en una cuenta de AstroPay card, EL  USUARIO debe enviar AL INTERMEDIARIO  información personal (en adelante, "Información Personal") que posteriormente puede ser verificada cuando sea necesario. EL USUARIO garantiza que la información proporcionada lo identifica y  será considerada como  verdadera, precisa y completa.

1.4 EL INTERMEDIARIO tendrá derecho a solicitar un comprobante de identidad, comprobante de residencia y comprobante de autorización para utilizar servicios de pago de terceros, incluidas, entre otras, las tarjetas de crédito y débito y las cuentas bancarias que EL USUARIO  desee utilizar para transferir fondos al comprar una tarjeta AstroPay

1.5 El USARIO  se compromete a mantener y actualizar permanente e inmediatamente la información personal siempre que la información personal del solicitante cambie.

1.6 EL INTERMEDIARIO  se reserva el derecho de rechazar cualquier registro y negarse a abrir una cuenta de AstroPay card sin razón y sin explicación.

1.7  Si se descubre que la información proporcionada por EL USUARIO es falsa, inexacta, no está actualizada o está incompleta, sin limitar otros recursos, el Intermediario  se reserva el derecho de cerrar la Cuenta  y rescindir el ACUERDO.

 2. Datos del Cliente

2.1 A los fines de las normas de protección de datos, el controlador de datos será el INTERMEDIARIO  y el  PROVEEDOR.  Nunca se solicitará a los clientes  sus claves bancarias, ni ninguna otra señal que implique tener control sobre los fondos del cliente.

2.2 La información relacionada con EL USUARIO (en adelante, "Información del Usuario") se puede mantener en una base de datos y ser utilizada por el INTERMEDIARIO  y PROVEEDOR para los fines establecidos en esta cláusula. 
La información que  indique EL USUARIO incluye cualquier información que el INTERMEDIARIO tenga, ahora o en cualquier momento en el futuro y que provenga de, o se relacione con: 
i) Registro y uso del servicio AstroPay card; 
ii) Terceros, como agencias de referencia de crédito y partes asociadas con el USUARIO; 
iii) Los pagos realizados por EL USUARIO a través del servicio AstroPay card, incluido el nombre del PROVEEDOR y la naturaleza general de los bienes y servicios pagados; 
iv) Verificación de la identidad, residencia o autorización del  USUARIO para utilizar servicios de pago de terceros para transferir fondos a la Cuenta AstroPay card.

2.3 EL INTERMEDIARIO puede usar, analizar y evaluar la Información EL USUARIO  para mantener y desarrollar una relación comercial con el PROVEEDOR. Esto incluirá los siguientes propósitos: 
i) Operar y administrar los servicios que provee el Proveedor; 
ii) Evaluación de riesgos financieros, cheques de lavado de dinero, informes de cumplimiento y regulatorios y prevención de fraudes;
iii) Identificar productos y servicios que puedan interesar al USUARIO; y 
iv) Conocer los negocios existentes y desarrollar productos y servicios nuevos e innovadores.
2.4 EL PROVEEDOR ni el INTERMEDIARIO  divulgarán Información del USUARIO a terceros, excepto: 
i) Cuando se obtenga el consentimiento del USUARIO; 
ii) Cuando EL INTERMEDIARIO  esté obligado o autorizado a hacerlo por ley; 
iii) A cualquier persona que proporcione un servicio AL INTERMEDIARIO  que haya aceptado mantener la Información del USUARIO estrictamente confidencial;
iv) A cualquier persona que proporcione beneficios o servicios al INTERMEDIARIO  en virtud o en relación con este Acuerdo; o 
v) A las agencias de verificación de identidad, lavado de dinero y prevención de fraude.

3. Acceso autorizado y uso adecuado

3.1 Para acceder a AstroPay card, EL USUARIO deberá especificar una contraseña (la 'Contraseña') en el registro. EL USUARIO se compromete a no revelar o revelar la Contraseña AL PROVEEDOR,ni AL INTERMEDIARIO  a ningún tercero, ni a almacenar la Contraseña en un lugar donde pueda ser descubierta, o de ninguna manera proporcionar acceso a la Cuenta de AstroPay card o sus instalaciones a terceros sin la autorización de terceros. El INTERMEDIARIO por escrito.

3.2 EL USUARIO se compromete a especificar una contraseña que no sea fácilmente derivable de la información pública sobre EL USUARIO, y reconoce y acepta que cualquier persona que se identifique ingresando los detalles de inicio de sesión y la contraseña asignada al USUARIO será asumida por el INTERMEDIARIO como EL USUARIO y, por tanto, el legítimo titular de la cuenta AstroPay card.

3.3 EL USUARIO se compromete a comunicarse con el INTERMEDIARIO inmediatamente después de darse cuenta de que un tercero conoce o ha descubierto la contraseña del usuario.

3.4 Si el INTERMEDIARIO recibe alguna indicación de que la seguridad de la Cuenta AstroPay card se haya visto comprometida o haya sido utilizada para cometer fraude o cualquier otra actividad ilegal, el INTERMEDIARIO puede suspender el acceso a la cuenta de AstroPay card sin previo aviso. Dicha indicación puede incluir, sin limitación, inicio de sesión o patrones de transacción sospechosos, registros de múltiples cuentas sospechosas, la ocurrencia de un "contracargo  por el emisor de la tarjeta" (donde se utiliza una tarjeta de pago para transferir fondos a la cuenta) y fallas de inicio de sesión múltiples.

3.5 El USUARIO reconoce y acepta que la Cuenta AstroPay card se pondrá a su disposición para su uso exclusivo. El USUARIO no hará uso de la Cuenta AstroPay card o de las facilidades proporcionadas en virtud del acceso del USUARIO a la Cuenta AstroPay card para ofrecer o proporcionar servicios a terceros o revender los servicios disponibles para el USUARIO en virtud del acceso del Usuario a La Cuenta AstroPay card.
4. Comisiones, intereses y bonificaciones de cuentas de AstroPay card

4.1 El PROVEEDOR y/ o INTERMEDIARIO tendrá el derecho de cobrar una tarifa de administración, y también tendrá el derecho, a su entera discreción, de renunciar a dichas tarifas. Antes de que se apliquen las tarifas de administración, el PROVEEDOR y/o INTERMEDIARIO informará al USUARIO de la cantidad y la fecha a partir de la cual se aplicarán las tarifas; El USUARIO tendrá 30 días a partir de la fecha de la notificación para cerrar la cuenta. El hecho de no cerrar la cuenta después de que se haya dado la debida notificación se considerará como aceptación de las tarifas por parte del USUARIO, y este el otorga su consentimiento al PROVEEDOR para que cargue las tarifas de administración que correspondan en tal caso.

4.2 Cuando el USUARIO disputa una transacción con otra parte, el PROVEEDOR no entrará en la disputa de ninguna otra manera que no sea para confirmar que el pago se realizó de acuerdo con las instrucciones que el USUARIO le dio al PROVEEDOR.

4.3 Algunos usuarios pueden ser elegibles para participar en programas de bonificación. Dichos programas de bonificación, en cuanto a sus condiciones, monto y emisión, estarán sujetos a la discreción del PROVEEDOR y no serán transferibles ni reembolsables. Cualquier bono ofrecido por el PROVEEDOR está limitado a uno por Usuario.
5. Fondos para comprar una tarjeta AstroPay card

5.1 El INTERMEDIARIO proporcionará al USUARIO uno o más medios para transferir fondos y comprar una Tarjeta AstroPay card. El puede cambiar los medios de Pago disponibles para el USUARIO de vez en cuando. Donde sea que esté en su poder para hacerlo, el PROVEEDOR o EL INTERMEDIARIO notificará con anticipación antes de retirar cualquier método de Pago.

5.2 El INTERMEDIARIO acepta que es posible que los fondos no estén inmediatamente disponibles para gastar después del inicio de una transferencia de fondos al AstroPay card. El USUARIO entiende y acepta que la transferencia de fondos estará sujeta a los retrasos relevantes de la red bancaria y financiera.

5.3 EL USUARIO acepta y autoriza al INTERMEDIARIO a contratar a terceras empresas en su nombre cuando sea necesario para hacer posible la carga de fondos para comprar una Tarjeta AstroPay card. Asimismo, EL USUARIO acepta y autoriza la deducción de cualquier tarifa, cargo o diferencia de cambio cobrada por esas compañías y, cuando corresponda, autoriza que estas tarifas y gastos se deduzcan al comprar la Tarjeta AstroPay card.

5.4 EL INTERMEDIARIO se reserva el derecho de negarse a registrarse o aceptar métodos de transferencia de fondos sin razón y sin explicación.

5.5 EL INTERMEDIARIO se reserva el derecho de establecer límites que limiten la cantidad máxima que el USUARIO puede gastar en la compra de Tarjetas AstroPay card en un día o cualquier otro período de tiempo.

6.1 EL INTERMEDIARIO deberá ofrecer al USUARIO los medios para obtener Tarjetas virtuales (Tarjetas AstroPay card). Cada tarjeta AstroPay card es emitida por Astropay LLP, Reino Unido.

6.2 EL USUARIO reconoce y acepta que cada Tarjeta AstroPay card se proporciona AL USUARIO con el único propósito de permitirle que realice pagos de buena fe a los comerciantes de AstroPay card, y la facilidad para realizar dichos pagos no debe interpretarse en ningún caso como un crédito otorgado por el INTERMEDIARIO para el USUARIO.

6.3 EL USUARIO puede, en cualquier momento, comprar una Tarjeta AstroPay card hasta los límites que EL INTERMEDIARIO pueda especificar. El  INTERMEDIARIO  deberá aclarar cualquier cargo relevante AL USUARIO antes de que se comprometa con la solicitud para obtener una Tarjeta AstroPay card. El INTERMEDIARIO, una vez que EL USUARIO confirme la aceptación de los cargos, pondrá a disposición del USUARIO la Tarjeta AstroPay card con el monto cargado especificado. La cantidad cargada más los cargos aplicables se tomarán cuando el USUARIO cargue los fondos para comprar una tarjeta AstroPay card. Al solicitar una Tarjeta AstroPay card. 
EL USUARIO otorga su consentimiento AL PROVEEDOR e INTERMEDIARIO  para almacenar estos fondos y también aceptará cumplir y estar sujeto a los términos aplicables a las Tarjetas AstroPay card  según lo establecido en este ACUERDO.

6.4 Cada tarjeta AstroPay card está asociada con una fecha de caducidad. EL USUARIO no intentará realizar una transacción de pago ni utilizar la Tarjeta AstroPay card más allá de su Fecha de Vencimiento.

6.5 Después de la Fecha de Vencimiento, EL PROVEEDOR retendrá todos los fondos disponibles en una Tarjeta AstroPay card, sin reembolso para EL USUARIO.

6.6 Es posible que se apliquen cargos a las transacciones realizadas con las tarjetas AstroPay card. Cuando se apliquen dichos cargos, el PROVEEDOR deberá indicar estos cargos claramente AL USUARIO y solicitar el consentimiento del USUARIO antes de que EL USUARIO realice la transacción.

7. Devolución de fondos de la Tarjeta Astropay card.

7.1 EL USUARIO no puede solicitar una devolución de los fondos retenidos en una Tarjeta AstroPay card. El fondo disponible en la Tarjeta AstroPay card solo se puede utilizar para realizar pagos en línea en los comercios de AstroPay card.
7.1 EL INTERMEDIARIO  no tiene responsabilidad alguna  respecto a la devolución de fondos, porque el USUARIO  es  el único responsable del uso que  haga con La Tarjeta Astropay card.

8. Suspensión y cierre de cuenta.

8.1 EL  PROVEEDOR se reserva el derecho de suspender AstroPay card por trabajos de reparación, mantenimiento y / o actualización. A menos que EL INTERMEDIARIO no pueda hacerlo por razones de seguridad u otras más allá de su control razonable, el  Intermediario le dará al USUARIO un aviso razonable de dicha suspensión.

8.2 EL INTERMEDIARIO se reserva el derecho de suspender el acceso del USUARIO a AstroPay card hasta que EL INTERMEDIARIO considere que la reincorporación sea apropiada en cualquier caso en que el INTERMEDIARIO tenga derecho a rescindir este ACUERDO o sospeche que puede haber motivos para rescindirlo.

8.3 Cuando el acceso a AstroPay card se haya suspendido debido a una presunta violación de la seguridad, EL USUARIO puede comunicarse con el INTERMEDIARIO para restablecer el acceso, siempre que las credenciales de autorización y / o la confirmación de identidad se presenten a satisfacción del Intermediario y que los intervinientes  estén satisfechos que existen medidas idóneas para evitar el acceso no autorizado a la Cuenta AstroPay card.

8.4 EL  PROVEEDOR puede cerrar la Cuenta AstroPay card en cualquier momento comunicándose con el Intermediario y cumpliendo con las instrucciones para el cierre de la cuenta.

8.5 El cierre no cancelará ninguna transacción que EL USUARIO haya autorizado previamente.

8.6 Si la Cuenta sin transacción se ha realizado en la Cuenta AstroPay card durante 12 meses, se considerará que la Cuenta ha sido abandonada. EL INTERMEDIARIO se reserva el derecho de cerrar las Cuentas AstroPaycard abandonadas sin informar AL USUARIO en cualquier momento.

8.7 EL INTERMEDIARIO se reserva el derecho de suspender o cancelar el acceso DEL USUARIO a AstroPay card donde el Usuario no utiliza AstroPay card dentro de un período de 90 días consecutivos. EL USUARIO puede solicitar el restablecimiento del acceso poniéndose en contacto con el Servicio al cliente de AstroPay card. EL USUARIO acepta que, a menos que el Intermediario mantenga la Cuenta de forma irrazonable en un estado suspendido a raíz de la solicitud de restablecimiento del USUARIO, la incapacidad del USUARIO para realizar transacciones en la Cuenta debido a la suspensión no afectará a si se considera que una Cuenta ha sido Abandonado según lo estipulado en la cláusula 8.6.

9. LA COMUNICACIÓN

9.1 EL INTERMEDIARIO puede, a su entera discreción, notificar al USUARIO con un aviso conforme a este Acuerdo 
i) Por correo prepago; 
ii) Por correo electrónico a la dirección de correo electrónico registrada; 
iii) A través de avisos que aparecen AL USUARIO cuando accede al servicio AstroPay card.

9.2 EL USUARIO otorga al INTERMEDIARIO  el derecho de enviar correos electrónicos relacionados con AstroPay card a la dirección de correo electrónico registrada del USUARIO.

9.3 EL USUARIO se compromete a notificar al INTERMEDIARIO  de cualquier cambio en la dirección de correo electrónico registrada del USUARIO.

9.4 EL USUARIO se compromete a acceder al servicio AstroPay card al menos una vez por mes calendario con el fin de estar informado del estado de la Cuenta AstroPay card y de cualquier notificación e información relacionada con el servicio AstroPay card sobre la cual EL INTERMEDIARIO  desea que se informe al Usuario. 
EL USUARIO también se compromete a verificar y leer cualquier mensaje de correo electrónico relacionado con la Cuenta AstroPay card enviada por el INTERMEDIARIO  y/o  Proveedor a la dirección de correo electrónico registrada del USUARIO.

9.5 Los avisos servidos por el USUARIO en virtud de este Acuerdo se pueden hacer por escrito al INTERMEDIARIO en la dirección definida anteriormente.

10. Contenido del usuario

10.1 EL INTERMEDIARIO  puede invitar al USUARIO a enviar contenido dentro de las áreas designadas de los sitios web operados por el PROVEEDOR (Áreas de Contenido del Usuario) que incluyen, sin limitación, tableros de anuncios en línea, foros de discusión y áreas de comentarios. Si el USUARIO elige enviar dicho contenido a dichas Áreas de Contenido de USUARIO, le otorgará al Proveedor una licencia perpetua, irrevocable y totalmente pagada para editar dichos mensajes y usarlos según lo considere adecuado EL PROVEEDOR.

10.2 EL USUARIO se asegurará de que el envío y la visualización de cualquier contenido de cualquier Área de Contenido del USUARIO no sea ilegal, lo que incluye, sin limitación, no viola los derechos de autor, causa ofensa criminal o difamación.

10.3 EL INTERMEDIARIO se reserva el derecho de monitorear las Áreas de Contenido del USUARIO y eliminar cualquier contenido que desee eliminar.

11. Cargos

11.1 EL USUARIO acepta y se compromete a pagar los cargos (los Cargos) que surgen del uso de la Cuenta AstroPay card.

11.2 Si los cargos cambian, EL INTERMEDIARIO /PROVEEDOR notificará AL USUARIO, quien puede solicitarnos que cerremos la cuenta, en cuyo caso los cargos actualizados no se aplicarán desde la fecha de recepción de las instrucciones del usuario hasta el momento en que la cuenta se haya cerrado.

11.3 El uso continuado de AstroPay card por parte del USUARIO luego de la notificación de los cambios en los Cargos aplicables se considerará como aceptación de los cambios por parte del USUARIO.

12. Cumplimiento, responsabilidad e indemnización.

12.1 EL USUARIO se compromete a cumplir con las leyes y regulaciones que se aplican al usar AstroPay card.
2 EL INTERMEDIARIO se reserva el derecho en cualquier momento de bloquear o inhibir el acceso a AstroPay card o rechazar los pagos de los mismos cuando EL INTERMEDIARIO considere que dicho acceso o pagos infringirían o podrían infringir cualquier requisito legal o reglamentario al que estén sujetos el PROVEEDOR o AstroPay card.

12.3 EL USUARIO solo usará la Tarjeta AstroPay card/ AstroPay con fines lícitos y no utilizará AstroPay card para recibir o transmitir material que sea obsceno, ofensivo, difamatorio, que infrinja la confianza o que infrinja cualquier derecho de propiedad intelectual.

12.4 Excepto en la medida en que la pérdida o daño sea causado directamente por la negligencia DEL INTERMEDIARIO/PROVEEDOR o directamente por el incumplimiento de este ACUERDO no será responsable ante EL USUARIO por cualquier pérdida o Daños que el usuario pueda sufrir como resultado de su uso de AstroPay card. 
12.5 EL INTERMEDIARIO no será responsable de ninguna pérdida directa o indirecta de ganancias, fondos de comercio, negocios o ahorros anticipados, ni de pérdidas o daños indirectos o consecuentes.

12.6 EL INTERMEDIARIO no será responsable de ninguna pérdida que resulte de servicios de terceros fuera de su control razonable (incluidos, entre otros, los servicios de teléfono y navegador), si dichos Servicios son utilizados por EL USUARIO para acceder a AstroPay card o utilizados por el  INTERMEDIARIO/ PROVEEDOR en Para cumplir con las instrucciones del usuario.

12.7 EL INTERMEDIARIO no será responsable por el retraso en el cumplimiento o el incumplimiento del cumplimiento de sus obligaciones en virtud del presente ACUERDO si el retraso o el fallo se debe a eventos o circunstancias fuera del control razonable del INTERMEDIARIO. Dicha demora o falla no constituirá un incumplimiento de este ACUERDO.

12.8 Teniendo en cuenta los procedimientos de seguridad relacionados con la apertura de la Cuenta AstroPay y el registro de fuentes de recarga, el USUARIO no tendrá derecho a renunciar a que  el INTERMEDIARIO sea el originador de pagos y eventos en la Cuenta AstroPay card, a menos que EL INTERMEDIARIO haya dado aviso por escrito al PROVEEDOR de que la seguridad de la cuenta ha sido comprometida.

12.9 EL USUARIO acepta la responsabilidad ante EL INTERMEDIARIO por cualquier pérdida que EL  INTERMEDIARIO sufra como resultado de cualquier incumplimiento de este ACUERDO por parte del USUARIO.

12.10 El INTERMEDIARIO y/o  PROVEEDOR no será responsable de ninguna reclamación a menos que haya sido causada por negligencia, incumplimiento intencional . En particular, EL PROVEEDOR y/o INTERMEDIARIO no será responsable bajo ninguna circunstancia, , por daños o pérdidas, incluidos, entre otros, los daños directos o indirectos,  especiales, incidentales o punitivos que se consideren o supuestamente resulten de o sean causados por los siguientes escenarios: pagos realizados a destinos no deseados o pagos realizados en cantidades incorrectas debido a la entrada de información incorrecta por parte del USUARIO; cualquier error u omisión en el contenido del sitio web; el uso indebido del contenido del sitio web o la incapacidad de cualquier persona para usar el sitio;retrasos, pérdidas, errores u omisiones que resulten del fallo de cualquier telecomunicación o de cualquier otro sistema de transmisión de datos y del fallo del sistema informático central o de cualquier parte del mismo; Cualquier resultado de cualquier acto de gobierno o autoridad, cualquier acto de fortuito o fuerza mayor.

12.11 El servicio del INTERMEDIARIO se limita a proporcionar AL USUARIO una facilidad de pago y no garantiza la calidad, seguridad o legalidad de la transacción que EL USUARIO está realizando. EL INTERMEDIARIO no tiene ninguna responsabilidad por los bienes o servicios por los cuales EL USUARIO paga utilizando el servicio del Intermediario y no será responsable de ningún cargo, impuesto u otras obligaciones en relación con dichos bienes o servicios.

12.12 EL USUARIO acepta liberar, indemnizar y eximir de responsabilidad al INTERMEDIARIO de cualquier reclamación presentada contra EL INTERMEDIARIO por un tercero con respecto a todas las pérdidas, acciones, procedimientos, reclamaciones, daños, gastos o responsabilidades que se hayan sufrido y en cualquier caso en que se haya incurrido como resultado del USUARIO. incumplimiento de este Acuerdo.
  

13. Términos generales

13.1 EL INTERMEDIARIO puede hacer cambios en los términos del negocio, o en la forma en que se registra y utiliza la Información DEL USUARIO. 
EL USUARIO entiende y acepta que al mantener abierta la cuenta AstroPay card del Usuario durante al menos 40 días después de haber recibido la notificación de un cambio, EL USUARIO dará su consentimiento.

13.2 EL INTERMEDIARIO se reserva el derecho en todo momento de variar las condiciones de este ACUERDO, pero hará todo lo posible para dar AL USUARIO un aviso de al menos 30 días antes de que surta efecto cualquiera de dichos cambios.

13.3 EL INTERMEDIARIO  se reserva el derecho de cambiar las instalaciones disponibles en AstroPay card. A menos que EL PROVEEDOR no pueda hacerlo por razones de seguridad u otras más allá de su control razonable, EL PROVEEDOR le dará AL USUARIO un aviso razonable de tal (s) cambio (s).

13.4 EL USUARIO puede rescindir este ACUERDO y, por lo tanto, dejar de usar AstroPay card en cualquier momento.

13.5 EL INTERMEDIARIO puede rescindir este ACUERDO mediante una notificación por escrito al USUARIO con al menos 30 días de antelación. Sin embargo, EL INTERMEDIARIO puede rescindir este ACUERDO con un aviso más breve o inmediato:
 i) Si el USUARIO incumple este ACUERDO; o 
ii) En caso de fraude / mal uso de AstroPay; o 
iii) En el caso de que el USUARIO se declare en bancarrota o se dicte una orden judicial sobre el USUARIO, lo que implica que el usuario es insolvente; o
 iv) Si el INTERMEDIARIO se niega a registrar una fuente de recarga; o
 v) Es razonablemente necesario para proteger al  y / o al USUARIO.
13.6 EL INTERMEDIARIO deberá hacer esfuerzos razonables para garantizar que todas las transacciones se procesen de manera oportuna. Sin embargo, una serie de factores, varios de los cuales están fuera del control del INTERMEDIARIO, como el tiempo de procesamiento en el sistema bancario o el servicio de correo, contribuirán a la hora en que se realicen las transacciones. EL INTERMEDIARIO no hace declaraciones sobre la cantidad de tiempo necesario para completar una transacción, ni será responsable por cualquier daño real o consecuente que surja de cualquier reclamo de demora.

13.7 Todos los diseños de sitios web, texto y gráficos, así como su diseño y disposición, y todos los derechos de propiedad intelectual en el mismo son propiedad del Intermediario. Queda estrictamente prohibido cualquier uso de los materiales del sitio web, su reproducción, modificación, distribución o publicación sin previo consentimiento expreso por escrito.

13.8 Ningún acto, omisión o demora por parte del INTERMEDIARIO será una renuncia a los derechos o recursos del PROVEEDOR en virtud de este Acuerdo, a menos que EL PROVEEDOR acuerde lo contrario por escrito.

13.9 Este ACUERDO, junto con los documentos a los que se hace referencia, contiene el acuerdo completo entre EL USUARIO Y EL INTERMEDIARIO relacionado con AstroPay.|

13.10 Si cualquier condición del ACUERDO se considera inválida, las condiciones restantes de este ACUERDO continuarán siendo válidas en la máxima medida permitida por la ley  local.

13.11 Los términos y condiciones de este ACUERDO se interpretarán de acuerdo con la ley peruana y/o chilena,  y estarán sujetos a la jurisdicción exclusiva de los tribunales chilenos o peruanos según corresponda.

13.12 EL INTERMEDIARIO  y EL USUARIO son las únicas partes que pueden confiar en o hacer cumplir este ACUERDO y, por esta chilena o peruana, donde se celebre el ACUERDO.
Efectivo a partir de Noviembre del 2018
AstroPay card

		        </textarea>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		        <button type="button" class="btn btn-success btn-terminos">Acepto los Terminos</button>
		      </div>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		</form>
    </div><!-- /.container -->


<!-- FIN SECCIÓN -->


	<?php echo $template_footer; ?>

	<script src="https://code.jquery.com/jquery-3.2.1.min.js" ></script>


	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

	<script src="<?php echo base_url('assets/js/jquery.validate.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/bootbox.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/function.js'); ?>?v=<?php echo rand(0,9999999); ?>"></script>

	<script>
		MyApp.confirmaregistro.init();
	</script>

<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '662604004208715');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=662604004208715&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-172858986-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-172858986-1');
</script>


	</body>
</html>
