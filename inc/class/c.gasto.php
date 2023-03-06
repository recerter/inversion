<?php
require_once TS_CLASS.'c.util.php';
class gasto
{
    function gastosDariosListado($user_id)
    {
        $db_handle = new DBController();
        $con = $db_handle->connectDB();
        return $con->query("SELECT * FROM inversion_gastosdiarios WHERE Gdiarios_user = $user_id AND YEAR(Gdiarios_fecha) = YEAR(CURDATE()) AND MONTH(Gdiarios_fecha) = MONTH(CURDATE())");
    }

    function gastosFijosListado($user_id)
    {
        $db_handle = new DBController();
        $con = $db_handle->connectDB();
        return $con->query("SELECT * FROM inversion_gastosfijos WHERE Gfijos_user = $user_id");
    }

    function gastosTarjetaListado($user_id){
        $db_handle = new DBController();
        $con = $db_handle->connectDB();
        return $con->query("SELECT * FROM inversion_tarjetas WHERE tarjeta_user = $user_id");
    }

    function tarjetaMovimiento($tarjeta_id){
        $db_handle = new DBController();
        $con = $db_handle->connectDB();
        return $con->query("SELECT * FROM inversion_tarjetasmovimientos WHERE YEAR(Tmovimientos_fecha) = YEAR(CURDATE()) AND MONTH(Tmovimientos_fecha) = MONTH(CURDATE()) AND Tmovimientos_tarjeta = $tarjeta_id ORDER BY Tmovimientos_fecha DESC");
    }

    function gastoTarjetasAll($user_id){
        $db_handle = new DBController();
        $con = $db_handle->connectDB();
        return $con->query("SELECT t.tarjeta_id, tm.Tmovimientos_descripcion, t.tarjeta_user, t.tarjeta_tipo, t.tarjeta_ultimosdigitos, tm.Tmovimientos_tarjeta, tm.Tmovimientos_monto, tm.Tmovimientos_fecha, tm.Tmovimientos_operacion 
        FROM inversion_tarjetasmovimientos tm
        JOIN inversion_tarjetas t ON tm.Tmovimientos_tarjeta = t.tarjeta_id
        WHERE t.tarjeta_user = $user_id 
        AND tm.Tmovimientos_fecha >= DATE_FORMAT(NOW(), '%Y-%m-01')
        ORDER BY tm.Tmovimientos_fecha DESC");
    }
    function insertGastodiario($Gdiarios_user, $Gdiarios_descripcion, $Gdiarios_imagen ,$Gdiarios_monto) {
        $db_handle = new DBController();
        $cUtil = new util();
        $query = "INSERT INTO inversion_gastosdiarios (Gdiarios_user, Gdiarios_descripcion, Gdiarios_imagen ,Gdiarios_monto, Gdiarios_fecha) values (?, ?, ?, ?, CURDATE())";
        $db_handle->insert($query, array($Gdiarios_user, $Gdiarios_descripcion, $Gdiarios_imagen ,$Gdiarios_monto));
        $cUtil->insertLog($Gdiarios_user, "Agrego un nuevo gasto Diario: " . $Gdiarios_descripcion);
    }
    function insertGastofijo($Gfijos_user, $Gfijos_descripcion, $Gfijos_imagen ,$Gfijos_monto) {
        $db_handle = new DBController();
        $cUtil = new util();
        $query = "INSERT INTO inversion_gastosfijos (Gfijos_user, Gfijos_descripcion, Gfijos_imagen , Gfijos_monto, Gfijos_fecha) values (?, ?, ?, ?, CURDATE())";
        $db_handle->insert($query, array($Gfijos_user, $Gfijos_descripcion, $Gfijos_imagen ,$Gfijos_monto));
        $cUtil->insertLog($Gfijos_user, "Agrego un nuevo gasto Fijo: " . $Gfijos_descripcion);
    }
    function updateGastofijo($Gfijos_id, $Gfijos_user, $Gfijos_monto) {
        $db_handle = new DBController();
        $query = "UPDATE inversion_gastosfijos SET Gfijos_monto = ?, Gfijos_fecha = CURRENT_TIMESTAMP WHERE Gfijos_id = ? AND Gfijos_user = ?";
        $db_handle->update($query, array($Gfijos_monto, $Gfijos_id, $Gfijos_user));
    }
    function deletGastofijo($Gfijos_id, $Gfijos_user) {
        $db_handle = new DBController();
        $con = $db_handle->connectDB();
        $con->query("DELETE FROM inversion_gastosfijos WHERE Gfijos_id = $Gfijos_id AND Gfijos_user = $Gfijos_user");
    }
    function deletGastodiario($Gdiarios_id, $Gdiarios_user) {
        $db_handle = new DBController();
        $con = $db_handle->connectDB();
        $con->query("DELETE FROM inversion_gastosdiarios WHERE Gdiarios_id = $Gdiarios_id AND Gdiarios_user = $Gdiarios_user");
    }
    function getgastos($tipoGasto, $mes, $user) {
        $db_handle = new DBController();
        switch ($tipoGasto) {
            case 'tarjeta':
                $query = "SELECT SUM(Tmovimientos_monto) AS total FROM inversion_tarjetasmovimientos INNER JOIN inversion_tarjetas ON inversion_tarjetas.tarjeta_id = inversion_tarjetasmovimientos.Tmovimientos_tarjeta WHERE inversion_tarjetas.tarjeta_user = ? AND YEAR(Tmovimientos_fecha) = ? AND MONTH(Tmovimientos_fecha) = ?";
                $params = array($user, date('Y', strtotime($mes)), date('m', strtotime($mes)));
                break;
            case 'diario':
                $query = "SELECT SUM(Gdiarios_monto) AS total FROM inversion_gastosdiarios WHERE Gdiarios_user = ? AND YEAR(Gdiarios_fecha) = ? AND MONTH(Gdiarios_fecha) = ?";
                $params = array($user, date('Y', strtotime($mes)), date('m', strtotime($mes)));
                break;
            case 'fijo':
                $query = "SELECT SUM(Gfijos_monto) AS total FROM inversion_gastosfijos WHERE Gfijos_user = ?";
                $params = array($user);
                break;
            default:
                return NULL;
        }
        $result = $db_handle->runQuery($query, $params);
        if ($result && count($result) > 0) {
            return $result[0]['total'];
        } else {
            return 0;
        }     
    }
    function getTarjetaById($id) {
        $db_handle = new DBController();
        $query = "Select * from inversion_tarjetas where tarjeta_id = ?";
        $result = $db_handle->runQuery($query, array($id));
        return $result;
    }

    function insertTarjeta($tarjeta_user, $tarjeta_ultimosdigitos, $tarjeta_vencimiento, $tarjeta_banco, $tarjeta_tipo, $tarjeta_limite) {
        $db_handle = new DBController();
        $cUtil = new util();
        $query = "INSERT INTO inversion_tarjetas (tarjeta_user, tarjeta_ultimosdigitos, tarjeta_vencimiento, tarjeta_banco, tarjeta_tipo, tarjeta_limite, tarjeta_imagen) values (?, ?, ?, ?, ?, ?, 'images/card/card3.jpg')";
        $db_handle->insert($query, array($tarjeta_user, $tarjeta_ultimosdigitos, $tarjeta_vencimiento, $tarjeta_banco, $tarjeta_tipo, $tarjeta_limite));
        $cUtil->insertLog($tarjeta_user, "Añadio una tarjeta nueva *".$tarjeta_ultimosdigitos);
    }

    function insertTarjetaMovimiento($Tmovimientos_tarjeta, $Tmovimientos_descripcion, $Tmovimientos_monto, $Tmovimientos_fecha, $Tmovimientos_operacion) {
        $cUtil = new util();
        $usuario = $GLOBALS["user"]->userData();
        if(empty($Tmovimientos_fecha))
            $Tmovimientos_fecha = date("Y-m-d");
        $db_handle = new DBController();
        $query = "INSERT INTO inversion_tarjetasmovimientos (Tmovimientos_tarjeta, Tmovimientos_descripcion, Tmovimientos_monto, Tmovimientos_fecha, Tmovimientos_operacion) values (?, ?, ?, ?, ?)";
        $db_handle->insert($query, array($Tmovimientos_tarjeta, $Tmovimientos_descripcion, $Tmovimientos_monto, $Tmovimientos_fecha, $Tmovimientos_operacion));
        $cUtil->insertLog($usuario["user_id"], "Añadio un gasto de $".$Tmovimientos_monto." en el comercio *".$Tmovimientos_descripcion);
    }

    function gettarjetaGastos($Tmovimientos_tarjeta) {
        $db_handle = new DBController();
        $query = "SELECT sum(Tmovimientos_monto) FROM inversion_tarjetasmovimientos WHERE Tmovimientos_tarjeta = ? AND YEAR(Tmovimientos_fecha) = YEAR(CURDATE()) AND MONTH(Tmovimientos_fecha) = MONTH(CURDATE())";
        $result = $db_handle->runQuery($query, array($Tmovimientos_tarjeta));
        return $result;
    }
}
?>