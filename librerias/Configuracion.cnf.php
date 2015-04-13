<?php

$root = (!isset($root)) ? "../../../" : $root;
require_once($root . "librerias/Configuracion.cnf.php");
// Modulo
require_once($root . "modulos/usuarios/librerias/Jerarquias.class.php");
require_once($root . "modulos/usuarios/librerias/Permisos.class.php");
require_once($root . "modulos/usuarios/librerias/Politicas.class.php");
require_once($root . "modulos/usuarios/librerias/Roles.class.php");
require_once($root . "modulos/usuarios/librerias/Usuarios.class.php");
require_once($root . "modulos/usuarios/librerias/Usuarios_Equipos.class.php");
require_once($root . "modulos/usuarios/librerias/Usuarios_Perfiles.class.php");
/** Otros Modulos **/
require_once($root . "modulos/aplicacion/librerias/Menus.class.php");
?>