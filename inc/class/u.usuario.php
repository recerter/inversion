<?php 
class Usuario{
    private $user = [];

    function __construct() {
        if(empty($this->user)){
            $db_handle = new DBController();
            $query = "Select * from global_usuarios where user_id = ?";
            $this->user = $db_handle->runQuery($query, array($_SESSION["member_id"]))[0];
            unset($this->user['user_contrasena']);
        }
	}
function userData(){
        return $this->user;
}
function updateUltimaConexion(){
    $db_handle = new DBController();
    $date = time();
    $query = "UPDATE global_usuarios SET user_ultimaConexion = ? WHERE user_id = ?";
    $db_handle->update($query, array($date, $this->user["user_id"]));
}

function updateAvatar($user_avatar) {
    $db_handle = new DBController();
    $query = "UPDATE global_usuarios SET user_avatar = ? WHERE user_id = ?";
    $db_handle->update($query, array($user_avatar, $this->user["user_id"]));
}

 function getRango(){
    $db_handle = new DBController();
    $query = "Select user_rango from global_usuarios where user_id = ?";
    return $db_handle->runQuery($query, array($this->user["user_id"]))[0]["user_rango"];
 }

 function getLog(){
    $db_handle = new DBController();
    $con = $db_handle->connectDB();
    return $con->query("SELECT * FROM inversion_log WHERE log_usuario = ".$this->user['user_id']." ORDER BY log_id DESC");
 }
 function sessionesActivas(){
    $db_handle = new DBController();
    $con = $db_handle->connectDB();
    return $con->query("SELECT * FROM tbl_token_auth WHERE user_id = ".$this->user['user_id']." ORDER BY is_expired ASC, expiry_date DESC LIMIT 20");
    
 }
}