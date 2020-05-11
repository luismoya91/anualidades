<?php
class anualidades
{
    public $response;

    public function __construct(){

		$this->response = new stdClass();
	
		$this->response->bool = false;
		$this->response->msg ="respuesta no asignada";

	

	}

	public function obtenerValorFuturo($valor_cuota,$tasa_interes,$cantidad_cuotas){ 
		$valor_futuro = 0;
		
		$temp = $valor_cuota*((pow((1+$tasa_interes),$cantidad_cuotas)-1)/$tasa_interes);

		$valor_futuro = $temp;
		return $valor_futuro;

	}
	public function obtenerValorAnualidadVI($valor_inicial,$tasa_interes,$cantidad_cuotas){ 
		$valor_anualidad = 0;
		
		$temp = ($valor_inicial*$tasa_interes)/(1-pow((1+$tasa_interes),-$cantidad_cuotas));

		$valor_anualidad = $temp;
		return $valor_anualidad;

	}

	public function obtenerValorInicial($valor_cuota,$tasa_interes,$cantidad_cuotas){ 
		
		$valor_inicial = 0;
		
		$temp = $valor_cuota*(1-pow((1+$tasa_interes),-$cantidad_cuotas))/($tasa_interes);

		$valor_inicial = $temp;
		return $valor_inicial;

	}

	public function obtenerValorAnualidadVF($valor_futuro,$tasa_interes,$cantidad_cuotas){ 
		$valor_anualidad = 0;
		
		$temp = ($valor_futuro*$tasa_interes)/(pow((1+$tasa_interes),$cantidad_cuotas)-1);

		$valor_anualidad = $temp;
		return $valor_anualidad;

	}

	public function convertirTasaInteres($valor_tasa,$tipo_1,$tipo_2,$tipo_3){
		$aux = 0;
		$tasa_final = 0;
		switch ($tipo_2) {
			case 'm':
				$aux = 12;
				break;
			case 'b':
				$aux = 6;
				break;
			case 't':
				$aux = 4;
				break;
			case 's':
				$aux = 2;
				break;
			case 'a':
				$aux = 1;
				break;
			
			default:
				# code...
				break;
		}
		if ($tipo_1 == "c") {
			$tasa_final = ($valor_tasa/$aux)/100;
		}else{
			$tasa_final = $valor_tasa/100;
		}
		return $tasa_final;
	}

}


$anualidades = new anualidades();
if (isset($_POST)) {

	$tasa_interes = $anualidades->convertirTasaInteres($_POST['info'][1]['value'],$_POST['info'][2]['value'],$_POST['info'][3]['value'],$_POST['info'][4]['value']);

	if ($_POST['info'][0]['value'] == "") {
		if ($_POST['info'][7]['value']!="") {
			$res = $anualidades->obtenerValorAnualidadVI($_POST['info'][7]['value'],$tasa_interes,$_POST['info'][5]['value']);
			$anualidades->response->tipo = "anualidad con valor inicial";
		}else if ($_POST['info'][6]['value']!="") {
			$res = $anualidades->obtenerValorAnualidadVF($_POST['info'][6]['value'],$tasa_interes,$_POST['info'][5]['value']);
			$anualidades->response->tipo = "anualidad con valor final";	
		}

	}else if ($_POST['info'][6]['value'] == "") {
		$res = $anualidades->obtenerValorFuturo($_POST['info'][0]['value'],$tasa_interes,$_POST['info'][5]['value']);
		$anualidades->response->tipo = "valor futuro";
	}else if($_POST['info'][7]['value'] == ""){
		$res = $anualidades->obtenerValorInicial($_POST['info'][0]['value'],$tasa_interes,$_POST['info'][5]['value']);
		$anualidades->response->tipo = "valor Inicial";
	}

	$anualidades->response->bool = true;
	$anualidades->response->msg = $res;
	 echo json_encode($anualidades);
}else{
	$anualidades->response->msg = "error";
	$anualidades->response->bool = false;
	echo json_encode($anualidades);
}



?>