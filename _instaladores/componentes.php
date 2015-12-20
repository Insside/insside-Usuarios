<?php
$root = (!isset($root)) ? "../../../" : $root;
require_once($root . "modulos/usuarios/librerias/Configuracion.cnf.php");
$componentes=new Usuarios_Componentes();
$componentes->regenerar();
?>