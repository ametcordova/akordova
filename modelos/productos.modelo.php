<?php
require_once dirname( __DIR__ ).'/config/conexion.php';

class ModeloProductos{

	/*=============================================
	REGISTRO DE PRODUCTO
	=============================================*/
	static public function mdlIngresarProducto($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_categoria, id_familia, id_medida, codigo, codigointerno, descripcion, stock, minimo, unidadxcaja, hectolitros, precio_compra, margen, precio_venta, leyenda, ubicacion, totaliza, granel, datos_promocion, ultusuario) VALUES (:id_categoria, :id_familia, :id_medida, :codigo, :codigointerno, :descripcion, :stock, :minimo, :unidadxcaja, :hectolitros, :precio_compra, :margen, :precio_venta, :leyenda, :ubicacion, :totaliza, :granel, :datos_promocion, :ultusuario)");

		$stmt->bindParam(":id_categoria", $datos["id_categoria"], PDO::PARAM_INT);
		$stmt->bindParam(":id_familia", $datos["id_familia"], PDO::PARAM_INT);
		$stmt->bindParam(":id_medida", $datos["id_medida"], PDO::PARAM_INT);
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt->bindParam(":codigointerno", $datos["codigointerno"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		//$stmt->bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);
		$stmt->bindParam(":stock", $datos["stock"], PDO::PARAM_STR);
		$stmt->bindParam(":minimo", $datos["minimo"], PDO::PARAM_INT);
		$stmt->bindParam(":unidadxcaja", $datos["unidadxcaja"], PDO::PARAM_INT);
		$stmt->bindParam(":hectolitros", $datos["hectolitros"], PDO::PARAM_STR);
		$stmt->bindParam(":precio_compra", $datos["precio_compra"], PDO::PARAM_STR);
		$stmt->bindParam(":margen", $datos["margen"], PDO::PARAM_STR);
		$stmt->bindParam(":precio_venta", $datos["precio_venta"], PDO::PARAM_STR);
		$stmt->bindParam(":leyenda", $datos["leyenda"], PDO::PARAM_STR);
		$stmt->bindParam(":ubicacion", $datos["ubicacion"], PDO::PARAM_STR);
		$stmt->bindParam(":totaliza", $datos["totaliza"], PDO::PARAM_STR);
		$stmt->bindParam(":granel", $datos["granel"], PDO::PARAM_INT);
		$stmt->bindParam(":datos_promocion", $datos["datos_promocion"], PDO::PARAM_STR);
		$stmt->bindParam(":ultusuario", $datos["ultusuario"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		//$stmt->close();
		$stmt = null;

	}

	/*=============================================
	EDITAR PRODUCTO
	=============================================*/
	static public function mdlEditarProducto($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET id_categoria = :id_categoria, id_familia= :id_familia, id_medida = :id_medida, codigointerno = :codigointerno, descripcion = :descripcion, stock = :stock, minimo = :minimo, unidadxcaja=:unidadxcaja, hectolitros =:hectolitros, precio_compra = :precio_compra, margen= :margen, precio_venta = :precio_venta, leyenda= :leyenda, ubicacion=:ubicacion, totaliza=:totaliza, granel=:granel, datos_promocion =:datos_promocion, ultusuario = :ultusuario WHERE id = :id");

		$stmt->bindParam(":id_categoria", $datos["id_categoria"], PDO::PARAM_INT);
		$stmt->bindParam(":id_familia", $datos["id_familia"], PDO::PARAM_INT);
		$stmt->bindParam(":id_medida", $datos["id_medida"], PDO::PARAM_STR);
		//$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt->bindParam(":codigointerno", $datos["codigointerno"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		//$stmt->bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);
		$stmt->bindParam(":stock", $datos["stock"], PDO::PARAM_STR);
		$stmt->bindParam(":minimo", $datos["minimo"], PDO::PARAM_INT);
		$stmt->bindParam(":unidadxcaja", $datos["unidadxcaja"], PDO::PARAM_INT);
		$stmt->bindParam(":hectolitros", $datos["hectolitros"], PDO::PARAM_STR);
		$stmt->bindParam(":precio_compra", $datos["precio_compra"], PDO::PARAM_STR);
		$stmt->bindParam(":margen", $datos["margen"], PDO::PARAM_STR);
		$stmt->bindParam(":precio_venta", $datos["precio_venta"], PDO::PARAM_STR);
		$stmt->bindParam(":leyenda", $datos["leyenda"], PDO::PARAM_STR);
		$stmt->bindParam(":ubicacion", $datos["ubicacion"], PDO::PARAM_STR);
		$stmt->bindParam(":totaliza", $datos["totaliza"], PDO::PARAM_STR);
		$stmt->bindParam(":granel", $datos["granel"], PDO::PARAM_INT);
		$stmt->bindParam(":datos_promocion", $datos["datos_promocion"], PDO::PARAM_STR);
		$stmt->bindParam(":ultusuario", $datos["ultusuario"], PDO::PARAM_INT);
		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		//$stmt->close();
		$stmt = null;

	}

	/*=============================================
	BORRAR PRODUCTO
	=============================================*/

	static public function mdlEliminarProducto($tabla, $datos){
        $estado=0;
		//$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado=:estado WHERE id = :id");

		$stmt -> bindParam(":estado", $estado, PDO::PARAM_INT);
		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		//$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	ACTUALIZAR PRODUCTO
	=============================================*/

	static public function mdlActualizarProducto($tabla, $item1, $valor1, $valor){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE id = :id");

		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":id", $valor, PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		//$stmt -> close();

		$stmt = null;

	}

/*=============================================
	MOSTRAR PRODUCTOS  
=============================================*/

	static public function mdlMostrarProductos($tabla, $item, $valor, $orden, $estado){
			
		
		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND estado=$estado ORDER BY $orden ASC");

			$stmt -> bindParam(":$item", $valor, PDO::PARAM_STR);
			//$stmt -> bindParam(":$estado", $estado, PDO::PARAM_INT);

			$stmt -> execute();

			return $stmt -> fetch();
			//$stmt -> close();
			$stmt = null;
	
		}else{

			$stmt = Conexion::conectar()->prepare("SELECT prod.id, prod.imagen, prod.codigo, prod.codigointerno, LTRIM(prod.descripcion) AS descripcion, prod.stock, prod.minimo, prod.precio_compra, prod.precio_venta, prod.ventas, prod.datos_promocion, fam.id AS famid, fam.familia, cat.categoria, med.medida FROM $tabla prod
			INNER JOIN familias fam ON fam.id=prod.id_familia
			INNER JOIN categorias cat ON cat.id=prod.id_categoria
			INNER JOIN medidas med ON med.id=prod.id_medida
			WHERE prod.estado=$estado ORDER BY prod.$orden DESC");
            
            //$stmt -> bindParam(":$estado", $estado, PDO::PARAM_INT);
            
			$stmt -> execute();

			return $stmt -> fetchAll();
			//$stmt -> close();
			$stmt = null;

		}


	}

/*=============================================
	LISTAR PRODUCTOS  
=============================================*/

static public function mdlListaProductos($tabla, $item, $valor, $orden, $estado){
try{       			
	$stmt = Conexion::conectar()->prepare("SELECT id, codigointerno, LTRIM(descripcion) AS descripcion FROM $tabla 
	WHERE estado=$estado ORDER BY $orden DESC");
	
	$stmt -> execute();

	return $stmt -> fetchAll();		

	$stmt -> close();

	$stmt = null;
} catch (Exception $e) {
	echo "Failed: " . $e->getMessage();
}

}

/*=============================================
	modelo MOSTRAR PRODUCTOS Y EXIST
=============================================*/

static public function mdlMostrarProdExist($tabla1, $tabla2, $item, $idproducto){
		$estado=1;
        
			$stmt = Conexion::conectar()->prepare("SELECT prod.*, alm.cant FROM $tabla1 prod 
													INNER JOIN $tabla2 alm ON alm.id_producto=prod.id
													WHERE prod.id = $idproducto AND prod.estado=1");

			$stmt -> execute();

			return $stmt -> fetch();
}	

/*=============================================
	VALIDA QUE CODIGO INTERNO NO SE REPITA
=============================================*/	    
static Public function mdlVerificaCodigo($tabla, $item, $valor){
     
	   $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item=:$item");
	   
	   $stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);
	   
	   $stmt->execute();
	   
	   return $stmt->fetch();
	   
	   $stmt->close();
	   
	   $stmt=null;
   }

/*==========================================================================*/	
	
/*=============================================
	MOSTRAR SUMA VENTAS
=============================================*/	

	static public function mdlMostrarSumaVentas($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT SUM(ventas) as total FROM $tabla WHERE estado=1");

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;
	}


/*=============================================
	MOSTRAR PRODUCTOS  MENOS VENDIDOS
=============================================*/

	static public function mdlMostrarProductosMenosVta($tabla, $item, $valor, $orden){
        $estado=1;
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE estado=$estado GROUP by $orden ORDER BY $orden ASC LIMIT 10");

			$stmt -> execute();

			return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;

	}	
	
	
	
	
}  //FIN DE LA CLASE 


	/*
consulta para la salida checa exits	
SELECT prod.*, alm.cant FROM productos prod 
INNER JOIN principal alm ON alm.id_producto=prod.id
WHERE prod.id = 144 AND prod.estado=1	
	
	reporte de ventas diarias
	SELECT p.id, p.`id_familia`,fa.familia,p.`id_categoria`,ca.categoria, p.`codigointerno`,p.`descripcion` FROM `productos` p
	INNER JOIN familias fa ON p.id_familia=fa.id
	INNER JOIN categorias ca ON p.id_categoria=ca.id

	el bueno 
	SELECT p.`id`,p.`descripcion`,sum(sal.cantidad) AS cant, sum(sal.cantidad*sal.precio_venta) as venta FROM `productos` p, hist_salidas sal where p.id=sal.id_producto group by p.id

	SELECT p.`id`,p.id_familia,fa.familia,p.id_categoria,cat.categoria,p.`descripcion`,sum(sal.cantidad) AS cant, sum(sal.cantidad*sal.precio_venta) as venta FROM `productos` p 
	INNER JOIN hist_salidas sal ON p.id=sal.id_producto
	LEFT JOIN familias fa ON p.id_familia=fa.id
	INNER JOIN categorias cat ON p.id_categoria=cat.id
	where p.id=sal.id_producto 
	group by p.id,p.id_familia

	SELECT p.`id`,p.id_familia,fa.familia,p.id_categoria,cat.categoria,p.`codigointerno`,p.`descripcion`,sum(sal.cantidad) AS cant, sum(sal.cantidad*sal.precio_venta) as venta FROM `productos` p 
	INNER JOIN hist_salidas sal ON p.id=sal.id_producto
	LEFT JOIN familias fa ON p.id_familia=fa.id
	INNER JOIN categorias cat ON p.id_categoria=cat.id
	where p.id=sal.id_producto and sal.fecha_salida='2019-04-15'
	group by p.id,p.id_familia

	SELECT prod.id, prod.imagen, prod.codigo, prod.codigointerno, LTRIM(prod.descripcion) AS descripcion, prod.stock, prod.minimo, prod.precio_compra, prod.precio_venta, prod.ventas, prod.datos_promocion, fam.id AS famid, fam.familia, cat.categoria, med.medida FROM productos prod
			INNER JOIN familias fam ON fam.id=prod.id_familia
			INNER JOIN categorias cat ON cat.id=prod.id_categoria
			INNER JOIN medidas med ON med.id=prod.id_medida
			WHERE prod.estado=1 ORDER BY prod.id DESC

ACTUALIZAR HECTOLITROS
UPDATE `productos` SET `hectolitros`='0.0426' WHERE `id` IN (14,15,239,258);
UPDATE `productos` SET `hectolitros`='0.0504' WHERE `id` IN (167,19,20,21);
UPDATE `productos` SET `hectolitros`='0.0780' WHERE `id` IN (16,241);
UPDATE `productos` SET `hectolitros`='0.0792' WHERE `id`=17;
UPDATE `productos` SET `hectolitros`='0.0852' WHERE `id` IN (17,22,23,24,25,26,27,28,29,30,163,168,238,10,11,12,13,18,8,9,70);
UPDATE `productos` SET `hectolitros`='0.1128' WHERE `id` IN (1,160,244);
UPDATE `productos` SET `hectolitros`='0.1135' WHERE `id` IN (31,32,33,36,37,38,255,260,262);
UPDATE `productos` SET `hectolitros`='0.1440' WHERE `id` IN (2,3,5,6,7,151,261,263);


	*/