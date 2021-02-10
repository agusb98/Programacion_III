<?php

$opcion = 7;
$ruta = "archivo.txt";

switch($opcion){
    case 1:
		//ABRO EL ARCHIVO
		$archivo = fopen($ruta, "r");

		//LEO EL ARCHIVO COMPLETO
		echo "<h2>" . fread($archivo, filesize($ruta)) . "</h2>";

		//CIERRO EL ARCHIVO
		fclose($archivo);
		break;
	case 2:
		//ABRO EL ARCHIVO
		$archivo = fopen($ruta, "r");

		//LEO 5 BYTES DEL ARCHIVO (5 LETRAS)
		echo "<h2>" . fread($archivo, 5) . "</h2>";

		//CIERRO EL ARCHIVO
		fclose($archivo);
		break;
	case 3:
		$archivo = fopen($ruta, "r");

		//LEO 1 LINEA DEL ARCHIVO
		echo "<h2>" . fgets($archivo) . "</h2>";

		//CIERRO EL ARCHIVO
		fclose($archivo);
		break;
	case 4:
		$archivo = fopen($ruta, "r");

		//LEO LINEA A LINEA DEL ARCHIVO 
		while(!feof($archivo))
		{
			echo "<h2>" . fgets($archivo) . "</h2>";
		}
		//CIERRO EL ARCHIVO
		fclose($archivo);
		break;
	case 5:
		//ABRO EL ARCHIVO
		$archivo = fopen("archivo2", "w+");//L/E
		
		//ESCRIBO EN EL ARCHIVO
		$cant = fwrite($archivo, "Escribo en el archivo");
		
		if($cant > 0){
			echo "<h2>escritura EXITOSA </h2><br/>";			
		}
		//CIERRO EL ARCHIVO
		fclose($archivo);
		break;
	case 6:
		$path_origen = $ruta;
		$path_destino = "archivo2";
		
		//COPIO EN EL ARCHIVO
		$copio = copy($path_origen, $path_destino);
		
		if($copio){
			echo "<h2>copia EXITOSA </h2><br/>";			
		}
		else{
			echo "<h2>no se pudo COPIAR </h2>";
		}
		break;
	case 7:
		$ruta = "archivo2";
		
		//ELIMINO EL ARCHIVO
		$elimino = unlink($ruta);
		
		if($elimino){
			echo "<h2>elimino EXITOSAMENTE </h2><br/>";			
		}
		else{
			echo "<h2>no se pudo ELIMINAR </h2>";
		}
		break;
	default:
		echo "<h2>Sin ejemplo</h2>";
}
?>