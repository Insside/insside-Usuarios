<?php
$root = (!isset($root)) ? "../../../" : $root;
require_once($root . "librerias/Configuracion.cnf.php");
// Modulo
if(!class_exists('Usuarios_Historial')) {require_once($root."modulos/usuarios/librerias/Usuarios_Historial.class.php");}
if(!class_exists('Usuarios_Jerarquias')) {require_once($root."modulos/usuarios/librerias/Usuarios_Jerarquias.class.php");}
if(!class_exists('Usuarios_Permisos')) {require_once($root."modulos/usuarios/librerias/Usuarios_Permisos.class.php");}
if(!class_exists('Usuarios_Politicas')) {require_once($root."modulos/usuarios/librerias/Usuarios_Politicas.class.php");}
if(!class_exists('Usuarios_Roles')) {require_once($root."modulos/usuarios/librerias/Usuarios_Roles.class.php");}
if(!class_exists('Usuarios_Equipos')) {require_once($root."modulos/usuarios/librerias/Usuarios_Equipos.class.php");}
if(!class_exists('Usuarios_Perfiles')) {require_once($root."modulos/usuarios/librerias/Usuarios_Perfiles.class.php");}
if(!class_exists('Usuarios_Modulos')) {require_once($root."modulos/usuarios/librerias/Usuarios_Modulos.class.php");}
if(!class_exists('Usuarios_Menus')) {require_once($root."modulos/usuarios/librerias/Usuarios_Menus.class.php");}
if(!class_exists('Usuarios')) {require_once($root."modulos/usuarios/librerias/Usuarios.class.php");}
?>