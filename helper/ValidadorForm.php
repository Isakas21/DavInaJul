<?php

/**
 *       
 */
//SI
class ValidadorForm
{

    private $errores;
    private $reglasValidacion;
    private $valido;

    function __construct()
    {
        $this->errores = array();
        $this->valido = false;
        $this->reglasValidacion = null;
    }

    // @param $fuente: array con los datos a validar - $reglasValidacion: reglas que deben cumplir los campos
    function validar($fuente, $reglasValidacion)
    {
        $this->reglasValidacion = $reglasValidacion;
        foreach ($reglasValidacion as $nombreCampo => $reglasCampo) {
            foreach ($reglasCampo as $nombreRegla => $valorRegla) {
                // si el campo es un elemento botón, casilla o elemento de lista sin seleccionar
                // es decir no está isset y daría error
                if (isset($fuente[$nombreCampo])) {
                    $valor = StrLen($fuente[$nombreCampo]);
                }

                if ($nombreRegla === 'required' && $valorRegla) //si es true y requerido
                {
                    if (empty($valor))
                        $this->addError($nombreCampo, "El valor {$nombreCampo} es requerido");
                }

                if ($nombreRegla === 'min') // otra regla
                {
                    if($valor == 0){
                        $this->addError($nombreCampo, "El valor {$nombreCampo} es requerido");
                    }
                    else if ($valor < 8) { // que tiene que contar las letras de la contraseña
                        $this->addError($nombreCampo, "La {$nombreCampo} debe tener más de 8 carácteres");
                    }
                }

            }
        }
        $this->valido = count($this->errores) == 0;
    }

    private function addError($nombreCampo, $error)
    {
        $this->errores[$nombreCampo] = $error;
    }

    function esValido()
    {
        return $this->valido;
    }

    function getErrores()
    {
        return $this->errores;
    }

    function getMensajeError($campo)
    {

        if (isset($this->errores[$campo])) {

            return $this->errores[$campo];
        }
        return "";
    }
}
