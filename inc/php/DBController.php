<?php
class DBController {
	private $host = "localhost";
	private $user = "root";
	private $password = "";
	private $database = "inversion";
	private $conn;
	
    function __construct() {
        $this->conn = $this->connectDB();
    }

    function connectDB() {
        $dsn = "mysql:host={$this->host};dbname={$this->database}";
        try {
            $conn = new PDO($dsn, $this->user, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch(PDOException $e) {
            die("La conexión ha fallado: " . $e->getMessage());
        }
    }

    function runBaseQuery($query) {
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function runQuery($query, $param_value_array) {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($param_value_array);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function insert($query, $param_value_array) {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($param_value_array);
    }

    function update($query, $param_value_array) {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($param_value_array);
        return $stmt->rowCount();
    }

    function delete($query, $param_value_array) {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($param_value_array);
        return $stmt->rowCount();
    }

    function exportarTablas()
{
    $host = $this->host;
    $usuario = $this->user;
    $pasword = $this->password;
    $nombreDeBaseDeDatos = $this->database;
    set_time_limit(3000);
    $tablasARespaldar = [];
    $mysqli = new mysqli($host, $usuario, $pasword, $nombreDeBaseDeDatos);
    $mysqli->select_db($nombreDeBaseDeDatos);
    $mysqli->query("SET NAMES 'utf8'");
    $tablas = $mysqli->query('SHOW TABLES');
    while ($fila = $tablas->fetch_row()) {
        $tablasARespaldar[] = $fila[0];
    }
    $contenido = "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\r\nSET time_zone = \"+00:00\";\r\n\r\n\r\n/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\r\n/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\r\n/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\r\n/*!40101 SET NAMES utf8 */;\r\n--\r\n-- Database: `" . $nombreDeBaseDeDatos . "`\r\n--\r\n\r\n\r\n";
    foreach ($tablasARespaldar as $nombreDeLaTabla) {
        if (empty($nombreDeLaTabla)) {
            continue;
        }
        $datosQueContieneLaTabla = $mysqli->query('SELECT * FROM `' . $nombreDeLaTabla . '`');
        $cantidadDeCampos = $datosQueContieneLaTabla->field_count;
        $cantidadDeFilas = $mysqli->affected_rows;
        $esquemaDeTabla = $mysqli->query('SHOW CREATE TABLE ' . $nombreDeLaTabla);
        $filaDeTabla = $esquemaDeTabla->fetch_row();
        $contenido .= "\n\n" . $filaDeTabla[1] . ";\n\n";
        for ($i = 0, $contador = 0; $i < $cantidadDeCampos; $i++, $contador = 0) {
            while ($fila = $datosQueContieneLaTabla->fetch_row()) {
                //La primera y cada 100 veces
                if ($contador % 100 == 0 || $contador == 0) {
                    $contenido .= "\nINSERT INTO " . $nombreDeLaTabla . " VALUES";
                }
                $contenido .= "\n(";
                for ($j = 0; $j < $cantidadDeCampos; $j++) {
                    $fila[$j] = str_replace("\n", "\\n", addslashes($fila[$j]));
                    if (isset($fila[$j])) {
                        $contenido .= '"' . $fila[$j] . '"';
                    } else {
                        $contenido .= '""';
                    }
                    if ($j < ($cantidadDeCampos - 1)) {
                        $contenido .= ',';
                    }
                }
                $contenido .= ")";
                # Cada 100...
                if ((($contador + 1) % 100 == 0 && $contador != 0) || $contador + 1 == $cantidadDeFilas) {
                    $contenido .= ";";
                } else {
                    $contenido .= ",";
                }
                $contador = $contador + 1;
            }
        }
        $contenido .= "\n\n\n";
    }
    $contenido .= "\r\n\r\n/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\r\n/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\r\n/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";

    # Se guardará dependiendo del directorio, en una carpeta llamada respaldos
    $carpeta =  dirname(__DIR__, 1) . "/respaldos";
    if (!file_exists($carpeta)) {
        mkdir($carpeta);
    }

    # Calcular un ID único
    $id = uniqid();

    # También la fecha
    $fecha = date("Y-m-d");

    # Crear un archivo que tendrá un nombre como respaldo_2018-10-22_asd123.sql
    $nombreDelArchivo = sprintf('%s/respaldo_%s_%s.sql', $carpeta, $fecha, $id);

    #Escribir todo el contenido. Si todo va bien, file_put_contents NO devuelve FALSE
    return file_put_contents($nombreDelArchivo, $contenido) !== false;
}
}
?>