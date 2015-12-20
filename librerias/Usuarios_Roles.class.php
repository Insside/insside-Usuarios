<?php 
$root = (!isset($root)) ? "../../../" : $root;
require_once($root . "modulos/usuarios/librerias/Configuracion.cnf.php");
require_once($root . "librerias/Fechas.class.php");
/**
 * @package Insside
 * @subpackage Usuarios
 * @author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 * @copyright (c) 2015 www.insside.com
 */
if (!class_exists('Usuarios_Roles')) {

    class Usuarios_Roles {

        var $tabla = "roles", $indice = "rol", $sesion, $fechas;

        function Usuarios_Roles() {
            $this->inicializar();
            $permisos = new Usuarios_Permisos();
            $this->sesion = new Sesion();
            $this->fechas = new Fechas();
            $permisos->crear("USUARIOS-ROLES", "Permite acceder al componente roles del modulo usuarios", "SISTEMA");
            $permisos->crear("USUARIOS-ROLES-R", "Permite ver los roles existentes en el sistema.", "SISTEMA");
            $permisos->crear("USUARIOS-ROLES-W", "Permite crear o definir roles.", "SISTEMA");
            $permisos->crear("USUARIOS-ROLES-D", "Permite eliminar roles en el sistema.", "SISTEMA");
        }

        function crear() {
            $rol = time();
            $db = new MySQL();
            $sql = "INSERT INTO `aplicacion_roles` SET ";
            $sql.="`rol`='" . $rol . "';";
            $consulta = $db->sql_query($sql);
            $db->sql_close();
            return($rol);
        }

        function eliminar($rol) {
            $db = new MySQL();
            $sql = "DELETE FROM `aplicacion_roles` WHERE `rol`='" . $rol . "';";
            $consulta = $db->sql_query($sql);
            $db->sql_close();
            $politicas = new Usuarios_Politicas();
            $politicas->eliminar($rol);
        }

        function actualizar($rol, $campo, $valor) {
            $db = new MySQL();
            $sql = "UPDATE `aplicacion_roles` SET `" . $campo . "`='" . $valor . "' WHERE `rol`='" . $rol . "';";
            echo($sql);
            $consulta = $db->sql_query($sql);
            $db->sql_close();
        }

        function consultar($rol) {
            $db = new MySQL();
            $consulta = $db->sql_query("SELECT * FROM `aplicacion_roles` WHERE `rol`='" . $rol . "' ;");
            $fila = $db->sql_fetchrow($consulta);
            $db->sql_close();
            return($fila);
        }

        function inicializar() {
            $sql = "CREATE TABLE `aplicacion_roles` (`rol` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',`nombre` varchar(32) DEFAULT NULL,`descripcion` blob NOT NULL,`fecha` date NOT NULL,`hora` time NOT NULL,`creador` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',PRIMARY KEY (`rol`));";
            $db = new MySQL();
            if (!$db->sql_tablaexiste("roles")) {
                $consulta = $db->sql_query($sql);
            }$db->sql_close();
        }

        //\\//\\//\\//\\//\\//\\ Estadisticas & Conteos //\\//\\//\\//\\//\\//\\
        function conteo() {
            $db = new MySQL();
            $consulta = $db->sql_query("SELECT Count(*) AS `conteo` FROM `aplicacion_roles`;");
            $fila = $db->sql_fetchrow($consulta);
            $db->sql_close();
            return($fila['conteo']);
        }

    }

}
?>