<?php 
require_once TS_CLASS.'c.util.php';
class classUsuario{
    function listadoUsuarios(){
        $db_handle = new DBController();
        $con = $db_handle->connectDB();
        return $con->query("SELECT * FROM global_usuarios");
    }

    function getRangoNombre($rango_id){
        $db_handle = new DBController();
        $query = "Select rango_nombre from global_rangos where rango_id = ?";
        return $db_handle->runQuery($query, array($rango_id))[0]["rango_nombre"];
    }

    function comprobarOnlineUsuario($user_id) {
        $db_handle = new DBController();
        $con = $db_handle->connectDB();
        $limite = time() - 3*60; // Limite de 3 minutos
        $stmt = $con->prepare("SELECT user_id FROM global_usuarios WHERE user_id = ? AND user_ultimaConexion <= ?");
        $stmt->execute([$user_id, $limite]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return count($result) > 0;
    }
    function updateAvatar($user_id, $user_avatar) {
        $db_handle = new DBController();
        $query = "UPDATE global_usuarios SET user_avatar = ? WHERE user_id = ?";
        $db_handle->update($query, array($user_avatar, $user_id));
    }
    function UpdateRango($user_id, $rango) {
        $db_handle = new DBController();
        $query = "UPDATE global_usuarios SET user_rango = ? WHERE user_id = ?";
        $db_handle->update($query, array($rango, $user_id));
    }
    
    function insertInvertirUsuario($user_id) {
        $db_handle = new DBController();
        $iUsuarios_favorito1 = "1";
        $iUsuarios_favorito2 = "12";
        $iUsuarios_favorito3 = "6";
        $iUsuarios_favorito4 = "10";
        $query = "INSERT INTO inversion_usuarios (iUsuarios_id, iUsuarios_favorito1, iUsuarios_favorito2, iUsuarios_favorito3, iUsuarios_favorito4) values (?, ?, ?, ?, ?)";
        $db_handle->insert($query, array($user_id, $iUsuarios_favorito1, $iUsuarios_favorito2, $iUsuarios_favorito3, $iUsuarios_favorito4));
    }

    function insertUsuario($user_nombre, $user_contrasena, $user_email) {
        $db_handle = new DBController();
        $cUtil = new Util();
        $perfil = "http://inversiones.ovitec.com.ar/images/avatar.png";
        $rango = 0;
        $query = "INSERT INTO global_usuarios (user_nombre, user_contrasena, user_email, user_avatar, user_rango) values (?, ?, ?, ?, ?)";
        $db_handle->insert($query, array($user_nombre, $user_contrasena, $user_email, $perfil, $rango));
        $getEmail = $this->getMemberByEmail($user_email);
        $cUtil->insertLog($getEmail[0]["user_id"], "Registro");
    }

    function getMemberByEmail($email) {
        $db_handle = new DBController();
        $query = "Select * from global_usuarios where user_email = ?";
        $result = $db_handle->runQuery($query, array($email));
        return $result;
    }

    function getMemberById($id) {
        $db_handle = new DBController();
        $query = "Select * from global_usuarios where user_id = ?";
        $result = $db_handle->runQuery($query, array($id));
        return $result;
    }

    function getMemberInversionById($id) {
        $db_handle = new DBController();
        $query = "Select * from inversion_usuarios where iUsuarios_id = ?";
        $result = $db_handle->runQuery($query, array($id));
        return $result[0];
    }
    

    function getRegistro($email, $token) {
        $db_handle = new DBController();
        $query = "Select * from global_usuarios where user_email = ? and u_token = ?";
        $result = $db_handle->runQuery($query, array($email, $token));
        return $result;
    } 
       function instrumentoInvierteListado($user_id, $limit){
        $db_handle = new DBController();
        $con = $db_handle->connectDB();
        return $con->query("SELECT Wportfolio_instrumento FROM inversion_walletportfolio WHERE Wportfolio_cantidad > 0 AND Wportfolio_user = $user_id GROUP BY Wportfolio_instrumento LIMIT $limit");
       }
       function getTokenByuser_id($user_id, $expired) {
        $db_handle = new DBController();
        $con = $db_handle->connectDB();
        $current_time = time();
        $current_date = date("Y-m-d H:i:s", $current_time);
        $stmt = $con->prepare("SELECT * FROM tbl_token_auth WHERE user_id = ? AND is_expired = ?");
        $stmt->bindParam(1, $user_id);
        $stmt->bindParam(2, $expired);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
    
        foreach ($result as $token) {
            $isPasswordVerified = false;
            $isSelectorVerified = false;
            $isExpiryDateVerified = false;
            if (password_verify($_COOKIE["random_password"], $token["password_hash"])) {
                $isPasswordVerified = true;
            }
            
            // Validate random selector cookie with database
            if (password_verify($_COOKIE["random_selector"], $token["selector_hash"])) {
                $isSelectorVerified = true;
            }
            
            // check cookie expiration by date
            if($token["expiry_date"] >= $current_date) {
                $isExpiryDateVerified = true;
            } else {
                $this->markAsExpired($token["id"]);
            }
    
            if ($isPasswordVerified && $isSelectorVerified && $isExpiryDateVerified) {
                $_SESSION["member_id"] = $token["user_id"];
                $query = "Select * from tbl_token_auth where id = ?";
                $result = $db_handle->runQuery($query, array($token["id"]));
                return $result;
            }
        }
    
        return null;
    }
    
    function markAsExpired($tokenId) {
        $db_handle = new DBController();
        $query = "UPDATE tbl_token_auth SET is_expired = ? WHERE id = ?";
        $expired = 1;
        $db_handle->update($query, array($expired, $tokenId));
    }
    
    function insertToken($user_id, $random_password_hash, $random_selector_hash, $expiry_date) {
        $db_handle = new DBController();
        $cUtil = new util();
        $query = "INSERT INTO tbl_token_auth (user_id, password_hash, selector_hash, ip, navegador, expiry_date) values (?, ?, ?, ?, ?, ?)";
        $db_handle->insert($query, array($user_id, $random_password_hash, $random_selector_hash, $cUtil->getRealIP(), $cUtil->getBrowser(), $expiry_date));
    }
}