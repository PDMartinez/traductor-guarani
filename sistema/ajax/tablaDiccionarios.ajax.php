<?php

require_once "../controladores/diccionarios.controlador.php";
require_once "../modelos/diccionarios.modelo.php";

class TablaDiccionarios{

	/*=============================================
	Tabla Guias
	=============================================*/ 

	public function mostrarTabla(){

		$item=null;
    	$valor=null;
        $var=null;
        $order="id_diccionario ASC";

		$diccionarios = ControladorDiccionarios::ctrMostrarDiccionario($item, $valor, $var, $order);

		// var_dump($diccionarios);
		// return;

		if(count($diccionarios)== 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 		$datosJson = '{

	 	"data": [ ';

	 	foreach ($diccionarios as $key => $value) {

	 			if($value["estado"]==1){
	 				$estado="<div class='btn-group'><button class='btn btn-success btn-sm btnActivar' idDiccionario='".$value["id_diccionario"]."' estadoDiccionario=0>Activo</button></div>";	
	 			}else{

	 				$estado="<div class='btn-group'><button class='btn btn-danger btn-sm btnActivar' idDiccionario='".$value["id_diccionario"]."' estadoDiccionario=1>Inactivo</button></div>";	
	 			}


	 			/*=============================================
	 	 		TRAEMOS LA IMAGEN
	  			=============================================*/ 
	  			$galeria = json_decode($value["foto"], true);
	  			
	  			if ($galeria!="" && $galeria!=[""] && $galeria!=NULL){

		  			
		  			//var_dump($galeria);
					foreach ($galeria as $indice => $valor) {
					
						$imagen = "<img src='".$valor."'width='60px'>";

					}

				}else{

					$galeria = json_decode("[]", true);
					$imagen = "<td><img src='vistas/img/diccionarios/default/sinImagen.png'class='img-thumbnail'width='40px'></td>";

					//var_dump($imagen);
		
				}

				// var_dump($valor);
		  		//return;
	
			/*=============================================
			ACCIONES
			=============================================*/

			$acciones = "<div class='btn-group'><button class='btn btn-warning btn-sm editarDiccionario' data-toggle='modal' data-target='#modalDiccionarios' idDiccionario='".$value["id_diccionario"]."' galeria='".implode(",", $galeria)."'><i class='fas fa-pencil-alt text-white'></i></button><button class='btn btn-danger btn-sm eliminarDiccionario' idDiccionario='".$value["id_diccionario"]."' galeria='".implode(",", $galeria)."'><i class='fas fa-trash-alt'></i></button></div>";	


			$datosJson.= '[


						"'.($key+1).'",
						"'.$value["guarani"].'",
						"'.$value["espanyol"].'",
						"'.$value["oracion"].'",
						"'.$imagen.'",
						"'.$value["fecha"].'",
						"'.$estado.'",
						"'.$acciones.'"
						
				],';

		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson.=  ']

		}';

		echo $datosJson;

	}

}

/*=============================================
Tabla Diccionarios
=============================================*/ 

$tabla = new TablaDiccionarios();
$tabla -> mostrarTabla();

