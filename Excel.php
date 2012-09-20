<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<? if (!$_POST) {
	
	?>
    <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" >
  <label>
    <input type="file" name="archivo" id="archivo" />
  </label>
  <label>
    <input type="submit" name="button" id="button" value="Enviar" />
  </label>
</form>
    <?
	
}
else {
	echo $_POST["archivo"];
	require_once "Excel/oleread.php";
	    /* Cuando cargamos un archivo mediante un formulario, se mueve a una ubicación temporal dada por el servidor y desde ahí debemos moverlo manualmente a donde queremos que quede. Si no lo movemos, el archivo se eliminará al terminar la ejecución del archivo php. El movimiento lo hacemos mediante la función move uploaded file la cual utiliza como parámetros: el array del archivo, el nombre del campo, la propiedad de nombre temporal dada y luego el nombre y la ruta con el que lo guardaremos. Si solo incluimos el nombre en la última, se guardará en el mismo directorio donde está el archivo php que estamos ejecutando */

    /* Luego, mediante un include, llamamos a la clase PHP Excel Reader, mediante el archivo reader.php */

    include("Excel/reader.php");

    /* Creamos un nuevo objeto de tipo Spreadsheet_Excel_Reader que corresponde a la clase que incluimos recién */

    $datos = new Spreadsheet_Excel_Reader();

    /* Le decimos al objeto que “lea” el archivo cargado. Esto extraerá toda la información correspondiente al archivo y la almacenará en el objeto */
	$nombre='test_excel.xls';
    $datos->read($nombre);

    /* Ahora, definimos una variable llamada celdas, en la cual guardaremos todos los datos de las celdas del archivo excel leído. Esto podemos hacerlo, llamando al método sheets sobre nuestro objeto datos, el cual contenía la información del archivo excel, e indicandole mediante los parámetros que nos pase los datos de la hoja 0 (primera hoja del archivo) y que queremos la información de sus celdas (cells) */

    $celdas = $datos->sheets[0]['cells'];

    /* Luego, mediante un echo, empezamos a construir una tabla en HTML */

    echo "<table width='300' align='center'>";

    /* Luego, mediante un ciclo, seguiremos armando nuestra tabla y concatenamos con el contenido de las celdas. Estos valores se almacenan en la variable en una FORMA de array de 2 dimensiones. La primera corresponde a la fila y la segunda a la columna, siempre empezando de 1 , poniendo como condición que cuando lea una celda vacía se detenga */

    $i=1;
    while($celdas[$i][1]!="")
    {
    echo "<tr><td width='150' align='center'>".$celdas[$i][1]."</td><td width='150' align='center'>".$celdas[$i][2]."</td></tr>";
    $i++;
    }

    /* Cerramos la tabla */

    echo "</table>";
}
?>

</body>
</html>