<?php
require_once "DBController.php";
class AuthRegistro {

    function insertEncuesta($user_id, $encuesta_edad, $encuesta_sexo, $encuesta_antiguedad, $encuesta_invirtio, $encuesta_otro, $encuesta_favorito) {
        $db_handle = new DBController();
        $query = "INSERT INTO inversion_encuesta (encuesta_id, encuesta_edad, encuesta_sexo, encuesta_antiguedad, encuesta_invirtio, encuesta_otro, encuesta_favorito) values (?, ?, ?, ?, ?, ?, ?)";
        $db_handle->insert($query, 'sssssss', array($user_id, $encuesta_edad, $encuesta_sexo, $encuesta_antiguedad, $encuesta_invirtio, $encuesta_otro, $encuesta_favorito));

    }
}
?>