<?php
class mainCore{
    private $web_nombre = "OviTec";
    private $web_url = "http://localhost/inversion/";
    
    function __construct() {
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        define('TS_INCLUDES', 'includes/');
        define('TS_CLASS', 'inc/class/');
        define('TS_PHP', 'inc/php/');
        define('TS_EXT', 'inc/ext/');
    	require_once TS_PHP.'DBController.php';
	}

    function getWebNombre(){
        return $this->web_nombre;
    }

    function getWebUrl(){
        return $this->web_url;
    }

}