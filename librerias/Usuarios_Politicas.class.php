<?php

$root = (!isset($root)) ? "../../../" : $root;
require_once($root . "modulos/usuarios/librerias/Configuracion.cnf.php");

class Usuarios_Politicas {

  function crear($rol, $permiso, $creador) {
    $db = new MySQL();
    $sql = "INSERT INTO `aplicacion_politicas` SET `permiso`='" . $permiso . "', `rol`='" . $rol . "',`creador`='" . $creador . "',`fecha`='" . date('Y-m-d', time()) . "',`hora`='" . date('H:i:s', time()) . "';";
    $consulta = $db->sql_query($sql);
    $db->sql_close();
  }

  /**
   * Permite verificar si un determinado rol tiene o no asignado un permiso en sus politicas
   * @param type $rol
   * @param type $permiso
   */
  function consultar($rol, $permiso) {
    $db = new MySQL();
    $sql=""
            . "SELECT * "
            . "FROM `aplicacion_politicas` "
            . "WHERE(`rol`='".$rol."' AND `permiso`='".$permiso."')"
            . "ORDER BY `rol`,`permiso`"
            . ";";
    $consulta = $db->sql_query($sql);
    $fila = $db->sql_fetchrow($consulta);
    $db->sql_close();
    return($fila);
  }

  function conteo($rol) {
    $db = new MySQL();
    $sql = ("SELECT Count(*) AS `conteo`, `aplicacion_politicas`.`rol` FROM `aplicacion_politicas` INNER JOIN `aplicacion_roles` ON `aplicacion_politicas`.`rol` = `aplicacion_roles`.`rol` WHERE `aplicacion_roles`.`rol`='" . $rol . "'; ");
    $consulta = $db->sql_query($sql);
    $fila = $db->sql_fetchrow($consulta);
    $db->sql_close();
    return($fila['conteo']);
  }

  function estado($rol, $permiso) {
    $db = new MySQL();
    $sql = ("SELECT * FROM `aplicacion_politicas` WHERE `rol`='" . $rol . "' AND `permiso`='" . $permiso . "' ;");
    $consulta = $db->sql_query($sql);
    if ($db->sql_numrows($consulta) == 0) {
      $resultado = false;
    } else {
      $resultado = true;
    };
    $db->sql_close();
    return($resultado);
  }

  function asignar($rol, $permisos, $creador) {
    $this->eliminar($rol);
    for ($i = 0; $i < count($permisos); $i++) {
      $permiso = $permisos[$i];
      $this->crear($rol, $permiso, $creador);
    }
  }

  function eliminar($rol) {
    $db = new MySQL();
    $sql = "DELETE FROM `aplicacion_politicas` WHERE `rol`='" . $rol . "';";
    $consulta = $db->sql_query($sql);
    $db->sql_close();
  }

  function inicializar() {
    $sql = "create table politicas(rol char(32) not null,permiso char(32) not null,fecha date,hora time,creador char(11),primary key (rol, permiso));";
    $db = new MySQL();
    if (!$db->sql_tablaexiste("politicas")) {
      $consulta = $db->sql_query($sql);
    }$db->sql_close();
  }

}

?>