<?php 
 require_once "conexion.php";
/**
 * 
 */
class ModeloVarios
{
			const METHOD="AES-256-CBC";
			const SECRET_KEY='$marcos@2020';
			const SECRET_IV='101712';
	/*============================================================
		MODELO PERFIL PARA RESGISTRAR DATOS
 	==============================================================*/
 	// static function mdlMostrarVario($tabla,$item,$valor,$order)
 	// {
 		
 	// 	if($item != null)
 	// 	{

		// 	$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $order ");
  //           // $nuevo=Conexion::decryption($valor);
			
		// 	$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

		// 	$stmt -> execute();
			
		// 	return $stmt -> fetch();

		// }else
 	// 	{
 	// 		$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY $order ");
 	// 		$stmt->execute();
 	// 		return $stmt-> fetchAll();
 	// 	}
 	// 	$stmt-> close();
		// $stmt= null;
 	// }


 	/*============================================================
		MODELO PERFIL PARA RESGISTRAR DATOS
 	==============================================================*/
 	// static function mdlMostrarCantidad($tabla,$item,$valor,$order)
 	// {
 		
 	// 		$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY $order ");
 	// 		$stmt->execute();
 	// 		return $stmt-> fetch();
 		
 	// }


	/*=============================================
	BORRAR
	=============================================*/

	// static public function mdlEliminarVario($tabla,$item, $datos){

	// 	$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE $item = :id");

	// 		$stmt -> bindParam(":id",$datos, PDO::PARAM_STR);
		
	// 		if($stmt -> execute()){

	// 			return "ok";
			
	// 		}else{
			
	// 			 "\nPDO::errorInfo():\n";
 //   				return ($stmt->errorInfo());

	// 		}


	// }

	/*=============================================
	ACTUALIZAR VARIOS
	=============================================*/

	static public function mdlActualizarVario($tabla, $item1, $valor1, $item2, $valor2)
	{

	$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1=:$item1 WHERE $item2=:$item2");
		
		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

		if($stmt -> execute())
		{
			return "ok";
		
		}else

		{
			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}
	
}
