<?php

require_once "../controladores/diccionarios.controlador.php";
require_once "../modelos/diccionarios.modelo.php";

class AjaxDiccionarios{

	/*=============================================
	GUARDAR DICCIONARIO
	=============================================*/	

	public function ajaxGuardarDiccionarios(){

		if(($this->idDiccionario) != ""){

			$datos = array("txtGuarani" => $this->txtGuarani,
							"txtEspanyol" => $this->txtEspanyol,
							"txtOracion" => $this->txtOracion,
							"idDiccionario" => $this->idDiccionario,
							"txtUsuario" => $this->txtUsuario);
			
			// var_dump($datos);
			// return;

			$respuesta = ControladorDiccionarios::ctrEditarDiccionario($datos);
				
			echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON

			die();

		}else{

			$datos = array("txtGuarani" => $this->txtGuarani,
							"txtEspanyol" => $this->txtEspanyol,
							"txtOracion" => $this->txtOracion,
							"idDiccionario" => $this->idDiccionario,
							"txtUsuario" => $this->txtUsuario);
				// var_dump($datos);
				// return;

				$respuesta = ControladorDiccionarios::ctrCrearDiccionario($datos);
				
				echo json_encode($respuesta,JSON_UNESCAPED_UNICODE); // convertimos en JSON

				die();

		}

	}


	/*=============================================
	EDITAR DICCIONARIOS
	=============================================*/	

	public function ajaxEditarDiccionario(){

		$item="id_diccionario";
    	$valor=$this->idDiccionario;
        $var=1;
        $order="id_diccionario ASC";

		$respuesta = ControladorDiccionarios::ctrMostrarDiccionario($item, $valor, $var, $order);

		echo json_encode($respuesta);//se imprime para que se pueda ver en el js
		// var_dump($respuesta);

	}

	/*=============================================
	Eliminar Guias
	=============================================*/	

	public function ajaxEliminarDiccionario(){
		

		$datos = array( "idEliminar" => $this->idEliminar,
						"galeria" => $this->galeria);

		// var_dump($datos);
		// return;

		$respuesta = ControladorDiccionarios::ctrBorrarDiccionario($datos);

		echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);

		die();
	}


	/*=============================================
	ACTIVAR GUIA
	=============================================*/	

	public function ajaxActivarDiccionario(){

		$tabla = "diccionario";

		$item1 = "estado";
		$valor1 = $this->activarDiccionario;

		$item2 = "id_diccionario";
		$valor2 = $this->activarId;

		$respuesta = ControladorDiccionarios::ctrActualizarDiccionario($tabla, $item1, $valor1, $item2, $valor2);

		echo json_encode($respuesta);

		die();

	}

	/*=============================================
	VALIDAR GUIA
	=============================================*/

	public function ajaxValidarGuia(){

		$item = "TITULO";
		$valor = $this->validarTitulo;
        $var=1;
        $order="COD_GUIA ASC";

		$respuesta = ControladorGuias::ctrMostrarGuia($item, $valor, $var, $order);

		echo json_encode($respuesta);

	}


}

///////////////////////////////////////////////////////////////////////

/*=============================================
	GUARDAR y EDITAR DICCIONARIOS
=============================================*/	

if(isset($_POST["txtGuarani"])){

	$Guardar = new AjaxDiccionarios();
	$Guardar -> txtGuarani = $_POST["txtGuarani"];
	$Guardar -> txtEspanyol = $_POST["txtEspanyol"];
	$Guardar -> txtOracion = $_POST["txtOracion"];
	$Guardar -> idDiccionario = $_POST["idDiccionario"];
	$Guardar -> txtUsuario = $_POST["txtUsuario"];
	
	$Guardar -> ajaxGuardarDiccionarios();

}

/*================================================
	EDITAR/MOSTRAR DICCIONARIO
==================================================*/
if(isset($_POST["idDiccionario"])){

	$editar = new AjaxDiccionarios();
	$editar -> idDiccionario = $_POST["idDiccionario"];
	$editar -> ajaxEditarDiccionario();

}

/*=============================================
	Eliminar Diccionario
=============================================*/	

if(isset($_POST["idEliminar"])){

	$eliminar = new AjaxDiccionarios();
	$eliminar -> idEliminar = $_POST["idEliminar"];
	$eliminar -> galeria = $_POST["galeria"];
	$eliminar -> ajaxEliminarDiccionario();

}

/*=============================================
	ACTIVAR DICCIONARIO
=============================================*/	

if(isset($_POST["activarDiccionario"])){

	$activarDiccionario = new AjaxDiccionarios();
	$activarDiccionario -> activarDiccionario = $_POST["activarDiccionario"];
	$activarDiccionario -> activarId = $_POST["activarId"];
	$activarDiccionario -> ajaxActivarDiccionario();

}

/*=============================================
 VALIDAR QUE NO SE REPITA EL NOMBRE
=============================================*/	

if(isset($_POST["validarTitulo"])){

	$validar = new AjaxGuias();
	$validar -> validarTitulo = $_POST["validarTitulo"];
	$validar -> ajaxValidarGuia();

}
