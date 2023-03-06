<?php
require_once TS_EXT.'inversionPrecio.php';
require_once TS_CLASS.'c.util.php';

class favorito{

    function insertarFavorito($user_id, $instrumento){
        $db_handle = new DBController();
        $util = new Util();
        if(empty($this->comprobarFavorito($user_id, $instrumento))){  
        $query = "INSERT INTO inversion_favoritos (fav_user, fav_instrumento) values (?, ?)";
        $db_handle->insert($query, array($user_id, $instrumento));
        $util->insertLog($user_id, "Añadio ".$instrumento." a Favoritos");
        }
    }

    function updateFavoritosInicio($user_id, $instrumento1, $instrumento2, $instrumento3, $instrumento4){
        $db_handle = new DBController();
        $query = "UPDATE inversion_usuarios SET iUsuarios_favorito1 = ?, iUsuarios_favorito2 = ?, iUsuarios_favorito3 = ?, iUsuarios_favorito4 = ?  WHERE iUsuarios_id = ?";
        $db_handle->update($query, array( $instrumento1, $instrumento2, $instrumento3, $instrumento4, $user_id));
    }

    function listadoTenecia($user_id){
        $db_handle = new DBController();
        $con = $db_handle->connectDB();
        return $con->query("SELECT Wportfolio_instrumento FROM inversion_walletportfolio WHERE Wportfolio_cantidad > 0 AND Wportfolio_user = '".$user_id."' GROUP BY Wportfolio_instrumento ORDER BY Wportfolio_instrumento");
    }

    function listadoFavoritos($user_id){
        $db_handle = new DBController();
        $con = $db_handle->connectDB();
        return $con->query("SELECT * FROM inversion_favoritos WHERE fav_user = ".$user_id." ORDER BY fav_id DESC");
    }
    
    function comprobarFavorito($user_id, $fav_instrumento){
        $db_handle = new DBController();
        $query = "SELECT * from inversion_favoritos where fav_user = ? AND fav_instrumento = ?";
        $result = $db_handle->runQuery($query, array($user_id, $fav_instrumento));
        return $result[0];
    }
}
?>
