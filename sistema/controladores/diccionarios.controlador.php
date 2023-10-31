<?php 

	class ControladorDiccionarios{

		/*=============================================
			MOSTRAR DICCIONARIOS
		=============================================*/

		static public function ctrMostrarDiccionario($item, $valor, $var, $order){

			$tabla = "diccionario";

			$respuesta = ModeloDiccionarios::mdlMostrarDiccionario($tabla, $item, $valor, $var, $order);

			return $respuesta;

		}


		/*============================================================
			CREAR DICCIONARIO
 		==============================================================*/
		static public function ctrCrearDiccionario($datos){

			if(isset($datos["txtGuarani"])){
				// var_dump($datos);
				// return;
				//validamos los datos nuevamente
				if(preg_match('/^[a-zA-ZñÑáÁéÉíÍóÓúÚÃẼĨÑÕŨỸãẽĩõũỹ., ]+$/', $datos["txtGuarani"]) && 
				   preg_match('/^[a-zA-ZñÑáÁéÉíÍóÓúÚ., ]+$/', $datos["txtEspanyol"])){

				    $tabla="diccionario";


				    $datos = array("txtGuarani" => $datos["txtGuarani"],
							"txtEspanyol"=>$datos["txtEspanyol"],
							"txtOracion"=>$datos["txtOracion"],
						    "idDiccionario" =>$datos["idDiccionario"],
							"txtUsuario"=>$datos["txtUsuario"]);
								    
				    $respuesta=ModeloDiccionarios::mdlIngresarDiccionario($tabla, $datos);

				    
					//SEPARAMOS EL ULTIMO ID GUARDADO
				    $COD_DICCIONARIO;
					$nombres = explode("/", $respuesta);
					$respuesta = $nombres[0];
					$COD_DICCIONARIO = $nombres[1];

					// var_dump($COD_DICCIONARIO);
					// return;

				    
				    if ($respuesta =='ok'){

						$arrResponse=array('status'=>true,'msg'=> 'Datos Guardado Correctamente','COD_DICCIONARIO'=>$COD_DICCIONARIO);

					}else if($respuesta =='exist'){

						$arrResponse=array('status'=>false,'msg'=> '¡Atención! El dato ya existe.');

					}else{

						$arrResponse=array('status'=>false,'msg'=> 'No es posible almacenar los datos.');
					}

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON

					die(); //para parar la aplicacion

				}else{

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en ninguno de los campos!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON

					die();
				}
				
			}

		}


		/*============================================================
			EDITAR DICCIONARIO
 		==============================================================*/
 		static public function ctrEditarDiccionario($datos){

			if(isset($datos["txtGuarani"])){

				// var_dump($datos);
				// return;

				//validamos los datos nuevamente
				if(preg_match('/^[a-zA-ZñÑáÁéÉíÍóÓúÚÃẼĨÑÕŨỸãẽĩõũỹ., ]+$/', $datos["txtGuarani"]) && 
				   preg_match('/^[a-zA-ZñÑáÁéÉíÍóÓúÚ., ]+$/', $datos["txtEspanyol"])){

				    $tabla="diccionario";


				    $datos = array("txtGuarani" => $datos["txtGuarani"],
							"txtEspanyol"=>$datos["txtEspanyol"],
							"txtOracion"=>$datos["txtOracion"],
						    "idDiccionario" =>$datos["idDiccionario"],
							"txtUsuario"=>$datos["txtUsuario"]);

				    $respuesta=ModeloDiccionarios::mdlEditarDiccionario($tabla, $datos);
				    
				    if ($respuesta=='ok'){

						$arrResponse=array('status'=>true,'msg'=> 'Datos Actualizado correctamente','COD_DICCIONARIO'=>0);

					}else if($respuesta =='exist'){

						$arrResponse=array('status'=>false,'msg'=> '¡Atención! El dato ya existe. Verifique intérvalo de montos');

					}else{

						$arrResponse=array('status'=>false,'msg'=> 'No es posible Actualizar los datos.');

					}

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON

					die();

				}else{

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en ninguno de los campos!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON

					die();
				}
				
			}

		}

		/*============================================================
			BORRAR DICCIONARIOS
 		==============================================================*/

		static public function ctrBorrarDiccionario($datos){

			$tabla ="diccionario";
			$valor = $datos["idEliminar"];
			$item = "id_diccionario";

			// var_dump($datos);
			// return;
				
			$respuesta = ModeloDiccionarios::mdlEliminarDiccionario($tabla, $item, $valor);
				
			if ($respuesta=='ok'){

				// Eliminamos fotos de la galería
				if($datos["galeria"]!=""){

					unlink("../".$datos["galeria"]);

				}

				$arrResponse=array('status'=>true,'msg'=> 'Datos Eliminado Correctamente');

			}else if($respuesta[0]==23000){

				$arrResponse=array('status'=>false,'msg'=> 'No es posible Eliminar el dato, el mismo está siendo usado.');

			}else{

				$arrResponse=array('status'=>false,'msg'=> $respuesta[2]);
			}

			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
			die();
			
		}

		/*============================================================
			ACTUALIZAR DICCIONARIO
 		==============================================================*/
 		static public function ctrActualizarDiccionario($tabla, $item1, $valor1, $item2, $valor2){

				// var_dump($datos);
				// return;

				//validamos los datos nuevamente
				    
				    $respuesta=ModeloDiccionarios::mdlActualizarDiccionario($tabla, $item1, $valor1, $item2, $valor2);
				    
				    if ($respuesta=='ok'){

						$arrResponse=array('status'=>true,'msg'=> 'Datos Actualizado correctamente');

					}else{

						$arrResponse=array('status'=>false,'msg'=> 'No es posible Actualizar los datos.');

					}

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON

					die();
				

		}


	}
