<?php

$root = (!isset($root)) ? "../../../" : $root;
require_once($root . "modulos/usuarios/librerias/Configuracion.cnf.php");

class Usuarios {

  var $tabla = "usuarios";
  var $indice = "usuario";
  var $sesion;
  var $fechas;
  var $jerarquias;
  var $politicas;
  var $permisos;
  var $formularios;

  function Usuarios() {
    $this->sesion = new Sesion();
    $this->fechas = new Fechas();
    $this->permisos = new Usuarios_Permisos();
    $this->politicas = new Usuarios_Politicas();
    $this->formularios = new Formularios(time());
    $modulos = new Usuarios_Modulos();
    $this->jerarquias = new Usuarios_Jerarquias();
    $modulo = $modulos->crear("002", "Usuarios", "Modulo Control de Usuarios.", "");
    $this->permisos->permiso_crear($modulo, "USUARIOS-MODULO-A", "Acceso Modulo De Usuarios", "Permite acceder al modulo Usuarios.", "0000000000");
    $this->permisos->permiso_crear($modulo, "USUARIOS-USUARIOS-R", "Visualizar Usuarios", "Permite visualizar los usuarios del sistema.", "0000000000");
    $this->permisos->permiso_crear($modulo, "USUARIOS-USUARIOS-W", "Crear Usuarios", "Permite crear o actualizar usuarios en el sistema", "0000000000");
    $this->permisos->permiso_crear($modulo, "USUARIOS-USUARIOS-U", "Actualizar Usuario", "Permite acceder al modulo Usuarios.", "0000000000");
    $this->permisos->permiso_crear($modulo, "USUARIOS-USUARIOS-D", "Eliminar Usuarios", "Permite acceder al modulo Usuarios.", "0000000000");
    $this->permisos->permiso_crear($modulo, "USUARIOS-EQUIPOS-A", "Acceso al componente equipos.", "Permite acceder al componente equipos de trabajo.", "0000000000");
    $this->permisos->permiso_crear($modulo, "USUARIOS-EQUIPOS-R", "Visualizar equipos de trabajo existentes.", "Permite acceder al componente equipos de trabajo.", "0000000000");
    $this->permisos->permiso_crear($modulo, "USUARIOS-EQUIPOS-W", "Crear equipos de trabajo.", "Permite acceder al componente equipos de trabajo.", "0000000000");
    $this->permisos->permiso_crear($modulo, "USUARIOS-EQUIPOS-U", "Actualizar equipos de trabajo existentes.", "Permite acceder al componente equipos de trabajo.", "0000000000");
    $this->permisos->permiso_crear($modulo, "USUARIOS-EQUIPOS-D", "Eliminar equipos de trabajo existentes.", "Permite acceder al componente equipos de trabajo.", "0000000000");
  }

  function crear($datos) {
    $db = new MySQL();
    $sql = "INSERT INTO `usuarios_usuarios` SET ";
    $sql.="`usuario`='" . $datos['usuario'] . "',";
    $sql.="`alias`='" . $datos['alias'] . "',";
    $sql.="`clave`='" . $datos['clave'] . "',";
    $sql.="`fecha`='" . $datos['fecha'] . "',";
    $sql.="`hora`='" . $datos['hora'] . "',";
    $sql.="`perfil`='" . $datos['perfil'] . "',";
    $sql.="`equipo`='" . $datos['equipo'] . "',";
    $sql.="`creador`='" . $datos['creador'] . "';";
    $db->sql_query($sql);
    $db->sql_close();
  }

  function eliminar($usuario) {
    $db = new MySQL();
    $sql = "DELETE FROM `usuarios_usuarios` WHERE `usuario`=" . $usuario . ";";
    $consulta = $db->sql_query($sql);
    $db->sql_close();
    return($consulta);
  }

  /**
   * Este metodo retorna el id de un usuario a partir de su alias, el dato retornado es la id numerica
   * del usuario registrado en la base de datos.
   * @param type $alias
   * @return type
   */
  function alias($alias) {
    $db = new MySQL();
    $sql = "SELECT * FROM `usuarios_usuarios` WHERE(`alias` = '" . $alias . "');";
    $consulta = $db->sql_query($sql);
    $fila = $db->sql_fetchrow($consulta);
    $db->sql_close();
    return($fila['usuario']);
  }

  function consultar($usuario) {
    $usuario = is_array($usuario) ? $usuario['usuario'] : $usuario;
    $db = new MySQL();
    $sql = "SELECT * FROM `usuarios_usuarios` WHERE(`usuario` = '" . $usuario . "');";
    $consulta = $db->sql_query($sql);
    $fila = $db->sql_fetchrow($consulta);
    $db->sql_close();
    return($fila);
  }

  function actualizar($usuario, $campo, $valor) {
    $db = new MySQL();
    $sql = "UPDATE `usuarios_usuarios` SET `" . $campo . "`='" . $valor . "' WHERE `usuario`='" . $usuario . "';";
    $consulta = $db->sql_query($sql);
    $db->sql_close();
    return($consulta);
  }

  function identificar($alias, $clave) {
    if (!empty($clave)) {
      $alias = strtoupper($alias);
      $clave = strtoupper($clave);
      $db = new MySQL();
      $sql = "SELECT * FROM `usuarios_usuarios` WHERE(`alias` = '" . $alias . "');";
      $consulta = $db->sql_query($sql);
      $fila = $db->sql_fetchrow($consulta);
      $db->sql_close();
      if ($clave == $fila["clave"]) {
        return(true);
      } else {
        return(false);
      }
    } else {
      return(false);
    }
  }

  function autorizar($uid) {
    $uid = strtoupper($uid);
    $db = new MySQL();
    $consulta = $db->sql_query("SELECT * FROM `aplicacion_roles` WHERE `uid` = '" . $uid . "'");
    $numero_registros = $db->sql_numrows($consulta);
    for ($i = 0; $i < $numero_registros; $i++) {
      $roles[$i] = $db->sql_fetchrow($consulta);
    }

    for ($i = 0; $i < count($roles); $i++) {
      $consulta = $db->sql_query("SELECT * FROM `aplicacion_permisos` WHERE `rid` = '" . $roles[$i][0] . "' ORDER BY `rid`,`pid`");
      $numero_registros = $db->sql_numrows($consulta);
      for ($j = 0; $j < $numero_registros; $j++) {
        $permisos[$j] = $db->sql_fetchrow($consulta);
        $_SESSION[$permisos[$j][1]] = true;
      }
    }

    $db->sql_close();
  }

  function combo($selected) {
    return($this->combo_consulta("usuarios", "alias", "usuario", "usuarios_usuarios", $selected, "", "height:30px; width:160px; font-size:24px;margin:0; padding-bottom:3"));
  }

  function combo_consulta($id, $etiquetas, $valores, $tabla, $selected, $condicion = "", $class = "", $disabled = false) {
    if (empty($selected)) {
      $selected = isset($_REQUEST['_' . $id]) ? $_REQUEST['_' . $id] : "";
    }
    $disabled = ($disabled) ? "disabled=\"disabled\"" : "";
    $condicion = empty($condicion) ? "" : "WHERE(" . $condicion . ")";
    $db = new MySQL();
    $sql = "SELECT * FROM `" . $tabla . "` " . $condicion . " ORDER BY `" . $etiquetas . "`";
    $consulta = $db->sql_query($sql);
    $html = ('<select name="' . $id . '"id="' . $id . '" class="' . $class . '" ' . $disabled . '>');
    $conteo = 0;
    while ($fila = $db->sql_fetchrow($consulta)) {
      $html.=('<option value="' . $fila[$valores] . '"' . (($selected == $fila[$valores]) ? "selected" : "") . '>' . $fila['usuario'] . ":  " . $fila['alias'] . '</option>');
      $conteo++;
    }
    $db->sql_close();
    $html.=("</select>");
    return($html);
  }

  function combo_estado($id, $selected, $class) {
    return($this->formularios->combo($id, array("Activo", "Deshabilitado"), array("ACTIVO", "DESHABILITADO"), $selected, $class));
  }

  //\\//\\//\\//\\//\\//\\ Estadisticas & Conteos //\\//\\//\\//\\//\\//\\

  function conteo($sql = "") {
    $db = new MySQL();
    $sql = "SELECT Count(`usuario`) AS `conteo` FROM `usuarios_usuarios` " . $sql . ";";
    $consulta = $db->sql_query($sql);
    $fila = $db->sql_fetchrow($consulta);
    return(intval($fila['conteo']));
  }

  /**
   * Consulta si un usuario tiene a su disposicion un sierto permiso
   * @param type $permiso
   */

  /**
   * Este metodo permite determinar si un alias es decir un nombre de usuario ya se encuentra registrado en el sistema
   * @param type $alias
   * @return type boolean
   */
  function alias_existente($alias) {
    $db = new MySQL();
    $existencia = $db->sql_query("SELECT * FROM `usuarios_usuarios` WHERE `alias`='" . $alias . "' ;");
    $existe = $db->sql_numrows($existencia);
    $db->sql_close();
    if ($existe == 0) {
      return(false);
    } else {
      return(true);
    }
  }

  function permiso($permiso, $usuario) {
    $roles = $this->jerarquias->consultar($usuario);
    foreach ($roles as $rol) {
      $asignado = $this->politicas->consultar($rol['rol'], $permiso);
      if (!empty($asignado['permiso'])) {
        return(true);
      }
    }
    return(false);
  }

  function empleado($usuario) {
    $usuario = $this->consultar($usuario);
    $empleado = $usuario['empleado'];
    $db = new MySQL();
    $sql = "SELECT * FROM `empleados_empleados` WHERE `empleado` = '" . $empleado . "'";
    $consulta = $db->sql_query($sql);
    $fila = $db->sql_fetchrow($consulta);
    $db->sql_close();
    return($fila);
  }

  /**
   *  Retorna un elemento html tipo select que contiene los posibles criterios a usar en el componente de 
   * busqueda
   * 
   * @param type $nombre
   * @param type $seleccionado
   * @return type
   */
  function criterios($nombre, $seleccionado) {
    $etiquetas = array("Código del Usuario", "Alias");
    $valores = array("usuario", "alias");
    return($this->formularios->combo($nombre, $etiquetas, $valores, $seleccionado, ""));
  }

  function nombre($usuario) {
    $cadenas = new Cadenas();
    $usuario = $this->consultar($usuario);
    $db = new MySQL();
    $sql = "SELECT * FROM `usuarios_perfiles` WHERE `perfil` = '" . $usuario['perfil'] . "'";
    $consulta = $db->sql_query($sql);
    $fila = $db->sql_fetchrow($consulta);
    $db->sql_close();
    return($cadenas->capitalizar($fila['nombres'] . " " . $fila["apellidos"]));
  }

  function perfil($perfil) {
    $cadenas = new Cadenas();
    $db = new MySQL();
    $sql = "SELECT * FROM `usuarios_perfiles` WHERE `perfil` = '" . $perfil . "'";
    $consulta = $db->sql_query($sql);
    $fila = $db->sql_fetchrow($consulta);
    $db->sql_close();
    return($fila);
  }

}

?>