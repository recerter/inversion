<?php 
require_once TS_CLASS.'c.util.php';
class publicaciones {
    function countPublicaciones($user_id){
        $db_handle = new DBController();
        $query = "SELECT count(*) as total FROM inversion_post WHERE post_user = ?";
        $result = $db_handle->runQuery($query, array($user_id));
        return $result[0]['total'];
    }
    function nuevoPost($user_id, $texto, $imagen){
        $db_handle = new DBController();
        $query = "INSERT INTO inversion_post (post_user, post_contenido, post_imagen ) values (?, ?, ?)";
        return $db_handle->insert($query, array($user_id, $texto, $imagen));  
    }

    function getPost($post_id){
        $db_handle = new DBController();
        $query = "SELECT * FROM inversion_post WHERE post_id = ?";
        $result = $db_handle->runQuery($query, array($post_id));
        return $result;
    }
    function listarPosts($user_id){
        $db_handle = new DBController();
        $con = $db_handle->connectDB();
        return $con->query("SELECT * FROM inversion_post WHERE post_user = $user_id ORDER BY post_id DESC"); 
        
    }
}