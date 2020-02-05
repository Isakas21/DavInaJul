<?php

interface IDatabase {

    public function conectar();
    public function desconectar();
    public function ejecutarSql($sql);
    public function ejecutarSqlActualizacion($sql,$args); 

}