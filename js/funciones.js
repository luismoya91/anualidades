 var calcularAnualidad = function(){

 	$('#btn-calcular').on('click',function () {
 		let anualidades_array =  $('#anualidades_form').serializeArray();
 		
 		if (anualidades_array[0].value == '' && anualidades_array[1].value == '' && anualidades_array[5].value == '' && anualidades_array[6].value == '' && anualidades_array[7].value == '') {
 			swal('Alto!','Dese ingresar al menos 4 datos','error');
 			return;
 		}
 		$.ajax({
 			type: "POST", 
			url: "./modelo/anualidades.php",
			dataType: "json",
			data: { 
				info: anualidades_array
			},
 			success: function(result){
 				if (result.response.bool) {	
 					$('#resultado').show();
 					$('#resultado').append('<h2>El resultado del cálculo '+result.response.tipo+' es :</h2>');
 					$('#resultado').append('<h2>$'+new Intl.NumberFormat().format(result.response.msg.toFixed(2))+'</h1>');

 				}else{
 					swal('Error',result.response.bool,'error')
 					return;
 				}
 			}
 		});

 	});


 }
 $('#btn-limpiar').on('click',function(){
 	$('#anualidades_form').trigger("reset");
 	$('#resultado').html('');
 	$('#resultado').hide 
 })
 calcularAnualidad();