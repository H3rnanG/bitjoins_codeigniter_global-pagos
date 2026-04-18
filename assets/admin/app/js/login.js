
$(document).ready(function(){
	function limpiar(frm){
		$('input:text', frm).each(function (i) {
			console.log('limpia')
			$(this).val("");
			if (frm = "#suscribete"){
				if($(this).val()== $(this).attr("title")){
					$(this).val("");
				}
			}
		});
		$('#txtmsg').val('');
	} 
	
});

MyApp = {
	Main : {
		init : function()
		{
			//MyApp.loadTitles.init();
		}
	},

	login : {
		init: function()
		{
			$("#sigin").submit(function( event ) {
				event.preventDefault();
				var campos = $(this).serialize(); 
				var urlDest = $(this).attr('action'); 

				//grecaptcha.ready(function() {
      				//grecaptcha.execute('6LeV480ZAAAAAH15AZpw7tRYqoKBxjabT5QwvEuk', {action: 'submit'}).then(function(token) {
						
					  	var result = submitAjax(urlDest,campos,'#errorForgot');

					  	//var target = $(this).data('target');
				        //$('.widget-box.visible').removeClass('visible');//hide others
				        //$('#forgot-box').addClass('visible');//show target

			  		//});
    			});
			//});

			$("#frmtoken").submit(function( event ) {
				event.preventDefault();
				var campos = $(this).serialize(); 
				var urlDest = $(this).attr('action'); 

				//grecaptcha.ready(function() {
      				//grecaptcha.execute('6LeV480ZAAAAAH15AZpw7tRYqoKBxjabT5QwvEuk', {action: 'submit'}).then(function(token) {
						
					  	var result = submitAjax(urlDest,campos,'#errorForgot');

			  		//});
    			//});
			});

			$(document).on('click', '.toolbar a[data-target]', function(e) {
		        e.preventDefault();
		        var target = $(this).data('target');
		        $('.widget-box.visible').removeClass('visible');//hide others
		        $(target).addClass('visible');//show target
	       	});
			

		}
	}
}

MyApp.Main.init();

$(window).resize(function(){});
$(window).trigger('resize');

