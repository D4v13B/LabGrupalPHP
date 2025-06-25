<?PHP
class Sanitizador {
    
    public static function limpiarCadena($cadena) {
        return trim(strip_tags($cadena));
    }

    public static function ValidarEntero($variableEntera) {
       $variableEntera = trim($variableEntera);
        
        if (is_numeric($variableEntera) and ($variableEntera > 0))
                $variableNumerica = $variableEntera;
                    else
                        $variableNumerica = 0;
                        
        
        return($variableNumerica);
    }
  

}
?>