<?php

/*
 * No lo utilizamos en el primer ejemplo de validación
 */

class Utilidades
{

    public static function filtrarDato($dato)
    {
        //Con las funciones que se necesiten
        return htmlspecialchars($dato, ENT_QUOTES, 'UTF-8');
    }

    public static function verArray($array)
    {
        echo "<pre>";
        print_r($array);
        echo "</pre>";
    }

    public static function verificarCasillas($array, $valormenu){
        if (!empty($array))
        if (in_array($valormenu, $array)){
            echo 'checked = "checked"';
        }
    }

}
