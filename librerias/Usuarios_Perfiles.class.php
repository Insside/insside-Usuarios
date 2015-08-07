<?php

$root = (!isset($root)) ? "../../../" : $root;
require_once($root . "modulos/usuarios/librerias/Configuracion.cnf.php");
/*
 * Copyright (c) 2015, Alexis
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * * Redistributions of source code must retain the above copyright notice, this
 *   list of conditions and the following disclaimer.
 * * Redistributions in binary form must reproduce the above copyright notice,
 *   this list of conditions and the following disclaimer in the documentation
 *   and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 */

/**
 * Description of Usuarios_Empleados
 * La tabla que registra la informacion del usuario, no es la misma tabla que registra el perfil o datos
 * personales del usuario como Empleado que labora en la entidad, esta clase es una versión 
 * resumida que permite recrear y actualizar perfiles de empleado de una forma muy basica en caso
 * de que el sistema creado no disponga acceso o contratación con nuestro software de gestión de 
 * empleados.
 *
 * @author Alexis
 */
class Usuarios_Perfiles {

  var $tabla = "usuarios_perfiles";
  var $indice = "perfil";
  var $sesion;
  var $fechas;
  var $cadenas;

  function Usuarios_Perfiles() {
    $this->sesion = new Sesion();
    $this->fechas = new Fechas();
    $this->cadenas = new Cadenas();
    $db = new MySQL();
    if (!$db->sql_tablaexiste($this->tabla)) {
      $this->tabla_crear();
    }
    $db->sql_close();
  }

  function consultar($perfil) {
    $db = new MySQL();
    $consulta = $db->sql_query("SELECT * FROM `" . $this->tabla . "` WHERE `" . $this->indice . "` = '" . $perfil . "'");
    $fila = $db->sql_fetchrow($consulta);
    $db->sql_close();
    return($fila);
  }

  function actualizar($perfil, $campo, $valor) {
    $db = new MySQL();
    $sql = "UPDATE `" . $this->tabla . "` SET `" . $campo . "`='" . $valor . "' WHERE `" . $this->indice . "`='" . $perfil . "';";
    $consulta = $db->sql_query($sql);
    $db->sql_close();
  }

  function crear() {
    $perfil = time();
    $db = new MySQL();
    $sql = "INSERT INTO `" . $this->tabla . "` SET ";
    $sql.="`empleado`='" . $perfil . "',";
    $sql.="`estado`='ACTIVO',";
    $sql.="`usuario`=NULL,";
    $sql.="`fecha`='" . $this->fechas->hoy() . "',";
    $sql.="`hora`='" . $this->fechas->ahora() . "',";
    $sql.="`creador`='" . $this->sesion->consultar("usuario") . "';";
    echo($sql);
    $consulta = $db->sql_query($sql);
    $db->sql_close();
    return($perfil);
  }

  function eliminar($perfil) {
    $db = new MySQL();
    $sql = "DELETE FROM `" . $this->tabla . "` WHERE `" . $this->indice . "`='" . $perfil . "';";
    $consulta = $db->sql_query($sql);
    $db->sql_close();
  }

  function tabla_crear() {
    $db = new MySQL();
    $sql = "CREATE TABLE `usuarios_perfiles` (
        `empleado` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000' COMMENT 'Numero Identificación',
        `documento` enum('CC','CE') DEFAULT 'CC',
        `nombres` varchar(255) NOT NULL DEFAULT '',
        `apellidos` varchar(255) NOT NULL DEFAULT '',
        `direccion` varchar(255) NOT NULL DEFAULT '',
        `telefono` varchar(255) NOT NULL DEFAULT '',
        `correo` varchar(255) NOT NULL DEFAULT '',
        `sexo` enum('M','F') NOT NULL DEFAULT 'M',
        `foto` varchar(255) DEFAULT NULL,
        `creado` date DEFAULT NULL,
        `actualizado` date DEFAULT NULL,
        `creador` varchar(10) DEFAULT NULL,
        PRIMARY KEY (`empleado`)
      ) ENGINE=MyISAM DEFAULT CHARSET=latin1;
    ";
    $consulta = $db->sql_query($sql);
    $db->sql_close();
    return($consulta);
  }

  function combo($name, $selected) {
    $db = new MySQL();
    $sql = "SELECT * FROM `usuarios_perfiles` ORDER BY `nombre` DESC";
    $consulta = $db->sql_query($sql);
    $html = ('<select name="' . $name . '"id="' . $name . '">');
    $conteo = 0;
    while ($fila = $db->sql_fetchrow($consulta)) {
      $html.=('<option value="' . $fila['perfil'] . '"' . (($selected == $fila['perfil']) ? "selected" : "") . '>' . $fila['perfil'] . ": " . $fila['nombre'] . " " . $fila['apellidos'] . '</option>');
      $conteo++;
    } $db->sql_close();
    $html.=("</select>");
    return($html);
  }

}
