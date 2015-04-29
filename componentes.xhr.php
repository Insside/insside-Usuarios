<?php
$root = (!isset($root)) ? "../../" : $root;
require_once($root . "modulos/usuarios/librerias/Configuracion.cnf.php");

$menus = new Usuarios_Menus();
echo($menus->menu("0000008000"));
?>