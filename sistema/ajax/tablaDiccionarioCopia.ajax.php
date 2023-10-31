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

		if(count($Guias)== 0){

 			$datosJson = '{"data": []}';

			echo $datosJson;

			return;

 		}

 		$datosJson = '{

	 	"data": [ ';

	 	foreach ($diccionarios as $key => $value) {

	 			if($value["ESTADO"]==1){
	 				$estado="<div class='btn-group'><button class='btn btn-success btn-sm btnActivar' idGuias='".$value["COD_GUIA"]."' estadoGuias=0>Activo</button></div>";	
	 			}else{

	 				$estado="<div class='btn-group'><button class='btn btn-danger btn-sm btnActivar' idGuias='".$value["COD_GUIA"]."' estadoGuias=1>Inactivo</button></div>";	
	 			}


	 			/*=============================================
	 	 		TRAEMOS LA IMAGEN
	  			=============================================*/ 
	  			$galeria = json_decode($value["PORTADA_IMAGEN"], true);
	  			
	  			if ($galeria!="" && $galeria!=[""] && $galeria!=NULL){

		  			
		  			//var_dump($galeria);
					foreach ($galeria as $indice => $valor) {
					
						$imagen = "<img src='".$valor."'width='40px'>";

					}

				}else{

					$galeria = json_decode("[]", true);
					$imagen = "<td><img src='vistas/img/usuarios/default/anonymous.png'class='img-thumbnail'width='40px'></td>";

					//var_dump($imagen);
		
				}

				/*=============================================
	 	 		TRAEMOS LA IMAGEN 360
	  			=============================================*/ 
	  			$galeria360 = json_decode($value["IMAGEN_360"], true);
	  			
	  			if ($galeria360!="" && $galeria360!=[""] && $galeria360!=NULL){

		  			
		  			// var_dump($galeria360);
		  			// return;
					foreach ($galeria360 as $indice => $valor) {
					
						$imagen360 = "<img src='".$valor."'width='40px'>";

					}

				}else{

					$galeria360 = json_decode("[]", true);
					$imagen360 = "<td><img src='vistas/img/usuarios/default/anonymous.png'class='img-thumbnail'width='40px'></td>";

					//var_dump($imagen);
		
				}

				// var_dump($valor);
		  // 		return;
	
			/*=============================================
			ACCIONES
			=============================================*/

			$acciones = "<div class='btn-group'><button class='btn btn-warning btn-sm editarGuias' data-toggle='modal' data-target='#ModalGuias' idGuias='".$value["COD_GUIA"]."' galeria='".implode(",", $galeria)."' galeria360='".implode(",", $galeria360)."'><i class='fas fa-pencil-alt text-white'></i></button><button class='btn btn-danger btn-sm eliminarGuias' idGuias='".$value["COD_GUIA"]."' galeria='".implode(",", $galeria)."' galeria360='".implode(",", $galeria360)."'><i class='fas fa-trash-alt'></i></button></div>";	


			$datosJson.= '[


						"'.($key+1).'",
						"'.$value["TITULO"].'",
						"'.$value["SUBTITULO"].'",
						"'.$ciudad["DESCRIPCION"].'",
						"'.$barrio["DESCRIPCION"].'",
						"'.$value["LATITUD"].'",
						"'.$value["LONGITUD"].'",
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

