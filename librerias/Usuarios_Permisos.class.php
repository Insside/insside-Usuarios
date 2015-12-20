<?php

$root = (!isset($root)) ? "../../../" : $root;
require_once($root . "modulos/usuarios/librerias/Configuracion.cnf.php");

/**
 * @package Insside
 * @subpackage Usuarios
 * @author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 * @copyright (c) 2015 www.insside.com
 */


    class Usuarios_Permisos {

        function Usuarios_Permisos() {
            
        }

        function crear($permiso, $descripcion, $creador) {
            return($this->permiso_crear("999", $permiso, $permiso, $descripcion, $creador));
        }

        function permiso_crear($modulo, $permiso, $nombre, $descripcion, $creador) {
            $db = new MySQL();
            $sql = "INSERT INTO `aplicacion_permisos` SET ";
            $sql.="`modulo`='" . $modulo . "',";
            $sql.="`permiso`='" . $permiso . "',";
            $sql.="`nombre`='" . $nombre . "',";
            $sql.="`descripcion`='" . $descripcion . "',";
            $sql.="`creador`='" . $creador . "',";
            $sql.="`fecha`='" . date('Y-m-d', time()) . "',";
            $sql.="`hora`='" . date('H:i:s', time()) . "';";
            $consulta = $db->sql_query($sql);
            $db->sql_close();
            return($consulta);
        }

        function actualizar($permiso, $descripcion) {
            $db = new MySQL();
            $sql = "UPDATE `aplicacion_permisos` SET ";
            $sql.="`descripcion`='" . $descripcion . "',";
            $sql.="`fecha`='" . date('Y-m-d', time()) . "',";
            $sql.="`hora`='" . date('H:i:s', time()) . "'";
            $sql.=" WHERE `permiso`='" . $permiso . "'";
            $sql.=";";
            $db->sql_query($sql);
            $db->sql_close();
        }

        function eliminar($permiso) {
            $db = new MySQL();
            $sql = "DELETE FROM `aplicacion_permisos` WHERE `permiso`='" . $permiso . "';";
            $db->sql_query($sql);
            $db->sql_close();
        }

        function consultar($permiso) {
            $db = new MySQL();
            $consulta = $db->sql_query("SELECT * FROM `aplicacion_permisos` WHERE `permiso`='" . $permiso . "' ;");
            $fila = $db->sql_fetchrow($consulta);
            $db->sql_close();
            return($fila);
        }

        function inicializar() {
            $sql = "create table permisos(permiso char(32) not null,descripcion blob not null,fecha date not null,hora time not null,creador char(11),primary key(permiso));";
            $db = new MySQL();
            if (!$db->sql_tablaexiste("permisos")) {
                $db->sql_query($sql);
            }$db->sql_close();
        }

        //\\//\\//\\//\\//\\//\\ Estadisticas & Conteos //\\//\\//\\//\\//\\//\\
        function conteo() {
            $db = new MySQL();
            $consulta = $db->sql_query("SELECT Count(*) AS `conteo` FROM `aplicacion_permisos`;");
            $fila = $db->sql_fetchrow($consulta);
            $db->sql_close();
            return($fila['conteo']);
        }

        function combo($name, $selected) {
            $db = new MySQL();
            $sql = "SELECT * FROM `aplicacion_permisos` ORDER BY `modulo`,`permiso` DESC";
            $consulta = $db->sql_query($sql);
            $html = ('<select name="' . $name . '"id="' . $name . '">');
            $conteo = 0;
            while ($fila = $db->sql_fetchrow($consulta)) {
                $html.=('<option value="' . $fila['permiso'] . '"' . (($selected == $fila['permiso']) ? "selected" : "") . '>' . $fila['modulo'] . ": " . $fila['permiso'] . '</option>');
                $conteo++;
            } $db->sql_close();
            $html.=("</select>");
            return($html);
        }

        function politicas($permiso) {
            $db = new MySQL();
            $sql = "SELECT  `aplicacion_politicas`.`rol`,`aplicacion_roles`.`nombre` ";
            $sql.="FROM `aplicacion_roles`";
            $sql.="INNER JOIN `aplicacion_politicas` ON `aplicacion_politicas`.`rol` = `aplicacion_roles`.`rol` ";
            $sql.="WHERE `permiso` = '" . $permiso . "' ";
            $sql.="GROUP BY `aplicacion_politicas`.`rol`,`aplicacion_roles`.`nombre`; ";
            $consulta = $db->sql_query($sql);
            $html = ('<p style="padding-left: 10px !important;">');
            $conteo = 0;
            while ($fila = $db->sql_fetchrow($consulta)) {
                $html.=('<br><b><a href="#" onClick="MUI.Usuarios_Roles_Rol_Permisos(\'' . $fila['rol'] . '\');">' . $fila['rol'] . '</a></b>: ' . $fila['nombre'] . '');
                $conteo++;
            } $db->sql_close();
            $html.=("</p>");
            return($html);
        }



}
?>