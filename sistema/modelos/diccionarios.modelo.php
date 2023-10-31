<?php 

	require_once "conexion.php";

	class ModeloDiccionarios{
		
		/*============================================================
			MOSTRAR DICCIONARIO
 		==============================================================*/

		static public function mdlMostrarDiccionario($tabla, $item, $valor, $var, $order){

			if($valor != null && $var!=null){

				$stmt = Conexion::conectar()->prepare("SELECT id_diccionario, espanyol, guarani, date_format(fecha, '%d-%m-%Y %H:%i:%s') AS fecha, foto, estado, oracion FROM $tabla WHERE $item = :$item ORDER BY $order ");
	           			
				$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

				$stmt -> execute();
				
				return $stmt -> fetch();

			}else if($valor != null && $var==null){

				$stmt = Conexion::conectar()->prepare("SELECT id_diccionario, espanyol, guarani, date_format(fecha, '%d-%m-%Y %H:%i:%s') AS fecha, foto, estado, oracion FROM $tabla WHERE $item = :$item ORDER BY $order ");
	           			
				$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

				$stmt -> execute();
				
				return $stmt -> fetchAll();
			
			}else{

	 			$stmt=Conexion::conectar()->prepare("SELECT id_diccionario, espanyol, guarani, date_format(fecha, '%d-%m-%Y %H:%i:%s') AS fecha, foto, estado, oracion FROM $tabla ORDER BY $order");

	 			$stmt->execute();

	 			// var_dump($stmt);

	 			return $stmt-> fetchAll();
	 		}

	 		$stmt-> close();
			$stmt= null;
		}


		/*============================================================
			CREAR DICCIONARIO
 		==============================================================*/
		static public function mdlIngresarDiccionario($tabla, $datos){


			// CONSULTAR SI YA HAY UN REGISTRO CON EL MISMO NOMBRE

			$stmt = Conexion::conectar()->prepare("SELECT * FROM diccionario WHERE guarani = :guarani");

			$stmt->bindParam(":guarani", $datos["txtGuarani"], PDO::PARAM_STR);

			$stmt -> execute();

			$cuenta = $stmt->rowCount();

			// var_dump($datos);
			// return;

			if($cuenta <= 0){

				$connection = Conexion::conectar();

				$stmt = $connection->prepare("INSERT INTO $tabla(guarani, espanyol, oracion, estado) VALUES (:Guarani, :Espanyol, :Oracion, 1)");

				$stmt->bindParam(":Guarani", $datos["txtGuarani"], PDO::PARAM_STR);
				$stmt->bindParam(":Espanyol",$datos["txtEspanyol"],PDO::PARAM_STR);
				$stmt->bindParam(":Oracion",$datos["txtOracion"],PDO::PARAM_STR);
				// $stmt->bindParam(":idDiccionario",$datos["idDiccionario"],PDO::PARAM_INT);
				// $stmt->bindParam(":Usuario", $datos["txtUsuario"], PDO::PARAM_INT);

			 	// var_dump($stmt);

			   if ($stmt-> execute()){

			   		$id = $connection->lastInsertId();

					return "ok/".$id;

			   }else{

			   		return "\nPDO::errorInfo():\n";
    				print_r(Conexion::conectar()->errorInfo());
			   }
				
			}else{

				return "exist";

			}

		}

		/*=============================================
			EDITAR DICCIONARIO
		=============================================*/

		static public function mdlEditarDiccionario($tabla, $datos){

			// var_dump($datos);
			// return;

			// CONSULTAR SI YA HAY UN REGISTRO CON EL MISMO NOMBRE

			$stmt = Conexion::conectar()->prepare("SELECT * FROM diccionario WHERE guarani = :guarani AND id_diccionario != :idDiccionario");

			$stmt->bindParam(":guarani", $datos["txtGuarani"], PDO::PARAM_STR);
			$stmt->bindParam(":idDiccionario",$datos["idDiccionario"],PDO::PARAM_INT);

			$stmt -> execute();

			$cuenta = $stmt->rowCount();

			// var_dump($cuenta);
			// return;

			if($cuenta <= 0){

				$stmt=Conexion::conectar()->prepare("UPDATE $tabla SET guarani = :Guarani, espanyol = :Espanyol, oracion = :Oracion WHERE id_diccionario = :idDiccionario");

				$stmt->bindParam(":Guarani", $datos["txtGuarani"], PDO::PARAM_STR);
				$stmt->bindParam(":Espanyol",$datos["txtEspanyol"],PDO::PARAM_STR);
				$stmt->bindParam(":Oracion",$datos["txtOracion"],PDO::PARAM_STR);
				$stmt->bindParam(":idDiccionario",$datos["idDiccionario"],PDO::PARAM_INT);


				if($stmt -> execute()){

					return "ok";
				
				}else{

					echo "\nPDO::errorInfo():\n";
		    		print_r(Conexion::conectar()->errorInfo());

				}

				$stmt -> close();
				$stmt = null;

			}else{
				
				return "exist";

			}

		}

		/*=============================================
			ELIMINAR DICCIONARIO
		=============================================*/

		static public function mdlEliminarDiccionario($tabla, $item, $valor){

			// var_dump($tabla, $item, $valor);
			// return;

			$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE $item = :valor");
			$stmt -> bindParam(":valor", $valor, PDO::PARAM_STR);
			$stmt -> execute();

			if($stmt -> execute()){

				return "ok";
								
			}else{
								
				"\nPDO::errorInfo():\n";
				return ($stmt->errorInfo());
			}

		}


		/*=============================================
		ACTUALIZAR DICCIONARIO
		=============================================*/

		static public function mdlActualizarDiccionario($tabla, $item1, $valor1, $item2, $valor2){

			// var_dump($tabla, $item1, $valor1, $item2, $valor2);
			// return;

			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");

			$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
			$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

			if($stmt -> execute()){

				return "ok";
			
			}else{

				"\nPDO::errorInfo():\n";
				return ($stmt->errorInfo());

			}

			$stmt -> close();

			$stmt = null;

		}

		/*=============================================
		ACTUALIZAR varios
		=============================================*/

		static public function mdlActualizarVarios($tabla, $item1, $valor1, $item2, $valor2, $rutaVieja){

			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1=:$item1 WHERE $item2=:$item2");
			
			$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
			$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

			if($stmt -> execute()){

				if($rutaVieja != ""){

					unlink("../".$rutaVieja);

				}

				return "ok";
			
			}else{

				return "error";	

			}

			$stmt -> close();

			$stmt = null;

		}


	}
