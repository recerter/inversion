<?php 
class precio {
    
	public function precioCrypto($moneda){
        $url = "https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&ids=$moneda";
        $curl = curl_init($url);
    
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
    
        if($response === false) {
            throw new Exception(curl_error($curl));
        }
    
        $datos = json_decode($response, true);
    
        if(empty($datos)) {
            throw new Exception("No se encontró información para la criptomoneda especificada.");
        }
    
        return $datos[0];
    }

    public function apiYahooFinance($moneda) {
        // Llamada a la API
        $url = "http://query1.finance.yahoo.com/v8/finance/chart/$moneda?includePrePost=false&interval=1h&useYfid=true&range=1d&includeTimeChange=true";
    
        $json = file_get_contents($url);
        $data = json_decode($json, true);
    
        // Manejo de errores
        if ($data === null || !isset($data['chart']['result'][0]['meta'])) {
            return null;
        }
    
        // Procesamiento de resultados
        $meta = $data['chart']['result'][0]['meta'];
        $result = [
            'symbol' => $meta['symbol'],
            'currency' => $meta['currency'],
            'currentPrice' => $meta['regularMarketPrice'],
            'percentChange' => (($meta["regularMarketPrice"]*100)/$meta["chartPreviousClose"])-100,
        ];
        return $result;
    }

    public function riesgoPais()
    {
    $html = file_get_contents('https://www.ambito.com/contenidos/riesgo-pais.html');
    preg_match('/<span class="value data-ultimo">(.*)<\/span>/i', $html, $cotizacion);
    $title_out = $cotizacion[1];
    return floatval($title_out);
    }

    public function precioDolar($tipo)
    {
    $ch1 = curl_init(); 
    curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));                         
    curl_setopt($ch1, CURLOPT_URL, "https://mercados.ambito.com/dolar/$tipo/variacion");
    curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
    $res1 = curl_exec($ch1);
    $res1 = json_decode($res1);
    curl_close($ch1);
    return $res1;
    }
    public function precioDolar2($tipo)
    {
    $ch1 = curl_init(); 
    curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));                         
    curl_setopt($ch1, CURLOPT_URL, "https://api-dolar-argentina.herokuapp.com/api/$tipo");
    curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
    $res1 = curl_exec($ch1);
    $res1 = json_decode($res1);
    curl_close($ch1);
    return $res1;
    }

    public function precioFondoInversionAlamerica($fondo){
        $title = 0;
        $rating = 0;
        $url = file_get_contents($fondo);
 
        //creamos nuevo DOMDocument y cargamos la url
        $dom = new DOMDocument();
        @$dom->loadHTML($url);
    
        //obtenemos todos los div de la url
        $divs = $dom->getElementsByTagName( 'td' );
        //recorremos los divs
        foreach( $divs as $div ){
            if( $div->getAttribute( 'data-label' ) === 'Valor CP' ){
                $title = $div->nodeValue;
            }
            if( $div->getAttribute( 'data-label' ) === 'Variación Diaria' ){
                $rating = $div->nodeValue;
                break;
            }
        }
        $title = floatval(str_replace(',', '.', $title)); //Cambiamos la COMA por un PUNTO
        $rating = floatval(str_replace(',', '.', $rating)); //Cambiamos la COMA por un PUNTO
        $rating = trim($rating, '%');
        return ["valor" => $title, "variacion" => $rating];
    }

    public function precioFondoInversionSantander($fondo){
        $title = 0;
        $rating = 0;
        $url = file_get_contents("https://banco.santanderrio.com.ar/asset/rendimiento_fondos.jsp");

        $doc = new DOMDocument();
        @$doc->loadHTML($url);
        $tr_list = $doc->getElementsByTagName('tr');
        $components = array();

        foreach ($tr_list as $tr) {
            $component = array();
            $td_list = $tr->getElementsByTagName('td');
            foreach ($td_list as $td) {
                if($td_list->length == 8)
                $component[] = $td->nodeValue;
            }
            if(count($component) > 2){
                $components[] = $component;
                //Pasamos todo a minusculas
                $oracion1 = strtolower($component[0]);
                $oracion2 = strtolower($fondo);
                // Eliminamos los espacios en blanco al inicio y al final de las oraciones
                $oracion1 = trim($oracion1);
                $oracion2 = trim($oracion2);
                if($oracion1 == $oracion2){
                    $title = $component[3];
                    $rating = $component[4];
                    break;
                }
            }
        }
        $title = floatval(str_replace(',', '', $title)); //Cambiamos la COMA por un PUNTO
        $rating = floatval(str_replace(',', '.', $rating)); //Cambiamos la COMA por un PUNTO
        $rating = trim($rating, '%');
        return ["valor" => $title, "variacion" => $rating];
    }

    function updateInstrumentoPrecio($instrumento_sigla_api, $instrumento_ultimoPrecio, $instrumento_ultimoPrecioCambio) {
        $db_handle = new DBController();
        $query = "UPDATE inversion_instrumentos SET instrumento_ultimoPrecio = ?, instrumento_ultimoPrecioCambio = ?, instrumento_ultimoPrecioFecha = CURRENT_TIMESTAMP  WHERE instrumento_sigla_api = ?";
        $db_handle->update($query, array($instrumento_ultimoPrecio, $instrumento_ultimoPrecioCambio, $instrumento_sigla_api));
    }

    function updateCotizacion($cotizacion_api, $cotizacion_compra, $cotizacion_venta, $cotizacion_valor)
    {
        $db_handle = new DBController();
        $query = "UPDATE inversion_cotizaciones SET cotizacion_compra = ?, cotizacion_venta = ?, cotizacion_valor = ?, cotizacion_fecha = CURRENT_TIMESTAMP  WHERE cotizacion_api = ?";
        $db_handle->update($query, array($cotizacion_compra, $cotizacion_venta, $cotizacion_valor, $cotizacion_api));
    }
    function precioCotizacion($cotizacion_api){
        $db_handle = new DBController();
        $query = "SELECT * FROM inversion_cotizaciones WHERE cotizacion_api = ?";
        $result = $db_handle->runQuery($query, array($cotizacion_api));
        return $result[0];
    }
    function jsonUrlToArray($url) {
        $jsonString = file_get_contents($url);
        $jsonData = json_decode($jsonString, true);
        return $jsonData;
    }
}
?>
