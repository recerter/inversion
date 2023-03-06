<?php
class util{
    function insertLog($usuario, $descripcion) {
        $db_handle = new DBController();
        $query = "INSERT INTO inversion_log (log_usuario, log_descripcion) values (?, ?)";
        $db_handle->insert($query, array($usuario, $descripcion));
    }

    public function getToken($length)
    {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet .= "0123456789";
        $max = strlen($codeAlphabet) - 1;
        for ($i = 0; $i < $length; $i ++) {
            $token .= $codeAlphabet[$this->cryptoRandSecure(0, $max)];
        }
        return $token;
    }
    
    public function cryptoRandSecure($min, $max)
    {
        $range = $max - $min;
        if ($range < 1) {
            return $min; // not so random...
        }
        $log = ceil(log($range, 2));
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd >= $range);
        return $min + $rnd;
    }
    
    public function redirect($url) {
        header("Location:" . $url);
        exit;
    }   
     public function redirect2($url) {
        echo "<script> window.location='".$url."'; </script>";
        exit;
    } 

    public function soloLetras($nombre_usuario){
        if (preg_match('/^[A-Za-z]*$/', $nombre_usuario)) {
            return true;
         } else {
            return false;
        }
    }

    public function comprobar_email($email) {
        return (filter_var($email, FILTER_VALIDATE_EMAIL)) ? 1 : 0;
    }
    
    public function clearAuthCookie() {
        if (isset($_COOKIE["member_login"])) {
            setcookie("member_login", "");
        }
        if (isset($_COOKIE["random_password"])) {
            setcookie("random_password", "");
        }
        if (isset($_COOKIE["random_selector"])) {
            setcookie("random_selector", "");
        }
    }

    function getRealIP() {
        $ip = filter_input(INPUT_SERVER, 'HTTP_CLIENT_IP', FILTER_VALIDATE_IP) ?: '';
        $ip = $ip ?: filter_input(INPUT_SERVER, 'HTTP_X_FORWARDED_FOR', FILTER_VALIDATE_IP) ?: '';
        $ip = $ip ?: filter_input(INPUT_SERVER, 'HTTP_X_FORWARDED', FILTER_VALIDATE_IP) ?: '';
        $ip = $ip ?: filter_input(INPUT_SERVER, 'HTTP_FORWARDED_FOR', FILTER_VALIDATE_IP) ?: '';
        $ip = $ip ?: filter_input(INPUT_SERVER, 'HTTP_FORWARDED', FILTER_VALIDATE_IP) ?: '';
        $ip = $ip ?: filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP) ?: '';
        return $ip;
    }

    function getBrowser() {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        if (strpos($user_agent, 'Chrome') !== false) {
            return 'Google Chrome';
        } elseif (strpos($user_agent, 'Firefox') !== false) {
            return 'Mozilla Firefox';
        } elseif (strpos($user_agent, 'Safari') !== false) {
            return 'Safari';
        } elseif (strpos($user_agent, 'Edge') !== false) {
            return 'Microsoft Edge';
        } elseif (strpos($user_agent, 'Opera') !== false || strpos($user_agent, 'OPR') !== false) {
            return 'Opera';
        } elseif (strpos($user_agent, 'MSIE') !== false || strpos($user_agent, 'Trident') !== false) {
            return 'Internet Explorer';
        } elseif (strpos($user_agent, 'Opera Mini') !== false) {
            return 'Opera Mini';
        } else {
            return 'No detectado';
        }
    }
    function time_elapsed_string($datetime, $full = false) {
        $now = time();
        $ago = strtotime($datetime);
        $diff = $now - $ago;
    
        $string = '';
    
        $years = floor($diff / (365 * 60 * 60 * 24));
        if ($years) {
            $string .= $years . ' año' . ($years > 1 ? 's' : '') . ', ';
        }
    
        $months = floor($diff / (30 * 60 * 60 * 24));
        if ($months) {
            $string .= $months . ' mes' . ($months > 1 ? 'es' : '') . ', ';
        }
    
        $weeks = floor($diff / (7 * 60 * 60 * 24));
        if ($weeks) {
            $string .= $weeks . ' semana' . ($weeks > 1 ? 's' : '') . ', ';
        }
    
        $days = floor($diff / (60 * 60 * 24));
        if ($days) {
            $string .= $days . ' dia' . ($days > 1 ? 's' : '') . ', ';
        }
    
        $hours = floor($diff / (60 * 60));
        if ($hours) {
            $string .= $hours . ' hora' . ($hours > 1 ? 's' : '') . ', ';
        }
    
        $minutes = floor($diff / 60);
        if ($minutes) {
            $string .= $minutes . ' minuto' . ($minutes > 1 ? 's' : '') . ', ';
        }
    
        $seconds = $diff;
        if ($seconds) {
            $string .= $seconds . ' segundo' . ($seconds > 1 ? 's' : '') . ', ';
        }
    
        $string = trim($string, ', ');
    
        if (!$full) {
            $string = substr($string, 0, strpos($string, ', ') + 1);
        }
    
        return $string ? $string . ' atras' : 'justo ahora';
    }

    function reemplazar_imagen($imagen, $reemplazo) {
        $headers = @get_headers($imagen);
        if ($headers && strpos($headers[0], '200')) {
            return $imagen;
        }
        return $reemplazo;
    }
}