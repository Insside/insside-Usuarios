<?php
$root=(!isset($root))?"../../../":$root;
require_once($root."modulos/usuarios/librerias/Configuracion.cnf.php");
if(!class_exists('Fechas')) {require_once($root."librerias/Fechas.class.php");}
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
 * Description of Historial
 * Esta clase gestionara el historial de acciones ejecutadas por cada usuario. El concepto de historial 
 * o de logging designa la grabación secuencial en la base de datos de todos los acontecimientos que 
 * afectan los procesos particulares de cada aplicación.
 * Advertencia: Esta clase no debe usar la clase Sesion() ya que puede generar errores de redundancia
 * ciclica. 
 * @author Alexis
 */
class Usuarios_Historial {
  var $tabla="usuarios_acciones";
  var $indice="accion";
  var $fechas;
  var $cadenas;
  
  function Historial(){
    $this->fechas = new Fechas();
    $this->cadenas = new Cadenas();
    $db = new MySQL();
    if(!$db->sql_tablaexiste($this->tabla)){
      $this->tabla_crear();
    }
    $db->sql_close();    
  }

  function get_Historia($usuario) {
    $db = new MySQL();
    $consulta = $db->sql_query("SELECT * FROM `".$this->tabla."` WHERE(`usuario`='" . $usuario. "');");
    $fila = $db->sql_fetchrow($consulta);
    $db->sql_close();
    return($fila);
  }
  
     function set_Historia($datos) {
    $db = new MySQL();
    $sql=""
            . "INSERT INTO `".$this->tabla."` (`accion`, `usuario`,`modulo`,`tipo`,`valor`,`descripcion`,`fecha`,`hora`,`sql`)"
            . "VALUES("
            . "'".$datos['accion']."',"
            . "'".$datos['usuario']."',"
            . "'".$datos['modulo']."',"
            . "'".$datos['tipo']."',"
            . "'".$datos['valor']."',"
            . "'".$datos['descripcion']."',"
            . "'".$datos['fecha']."',"
            . "'".$datos['hora']."',"
            . "'".$datos['sql']."');"
            . "";
    $consulta = $db->sql_query($sql);
    $db->sql_close();
    //echo($sql);
    return($sql);
  }
  
  /**
   * Resgistra un intento de acceso al sistema.
   * @param type $usuario: Usuario que realiza la accion
   * @param type $resultado: Cadena que indica el "EXITO" o "ERROR" en la acción.
   * @param type $sql: Datos SQL o adicionales.
   */
  function set_Acceso($usuario,$modulo,$resultado,$sql=""){
    $fechas=new Fechas();
    $tipo="ACCEDER";
    $mensaje_exito="El usuario accedio satisfactoriamente al sistema.";
    $mensaje_error="Se nego el acceso al sistema.";
        $registro=$this->set_Historia(array(
        "accion"=>time(),
        "usuario"=>$usuario,
        "modulo"=>$modulo,
        "tipo"=>$tipo,
        "valor"=>$resultado,
        "descripcion"=>(($resultado=="EXITO")?$mensaje_exito:$mensaje_error),
        "fecha"=>$fechas->hoy(),
        "hora"=>$fechas->ahora(),
        "sql"=>$sql
    ));
  }
    /**
     * 
     * @param type $usuario
     * @param type $modulo
     * @param type $resultado
     * @param type $sql
     */
    function set_Salir($usuario,$modulo,$resultado,$sql=""){
    $tipo="SALIR";
    $mensaje_exito="El usuario salio satisfactoriamente del sistema.";
    $mensaje_error="Se nego salida del sistema.";
        $registro=$this->set_Historia(array(
        "accion"=>time(),
        "usuario"=>$usuario,
        "modulo"=>$modulo,
        "tipo"=>$tipo,
        "valor"=>$resultado,
        "descripcion"=>(($resultado=="EXITO")?$mensaje_exito:$mensaje_error),
        "fecha"=>$this->fechas->hoy(),
        "hora"=>$this->fechas->ahora(),
        "sql"=>$sql
    ));
  }
  
  
  
  
  
  
  

  function actualizar($empleado, $campo, $valor) {
    $db = new MySQL();
    $sql = "UPDATE `".$this->tabla."` SET `" . $campo . "`='" . $valor . "' WHERE `".$this->indice."`='" . $empleado . "';";
    $consulta = $db->sql_query($sql);
    $db->sql_close();
  }
  
 

  function eliminar($empleado) {
    $db = new MySQL();
    $sql = "DELETE FROM `".$this->tabla."` WHERE `".$this->indice."`='" . $empleado . "';";
    $consulta = $db->sql_query($sql);
    $db->sql_close();
  }
  
  
  function tabla_crear(){
    $db = new MySQL();
    $sql="CREATE TABLE `usuarios_acciones` (
  `accion` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `usuario` int(10) unsigned zerofill DEFAULT NULL,
  `modulo` int(3) unsigned zerofill DEFAULT '000',
  `tipo` enum('ACCEDER','SALIR','CONSULTAR','CREAR','ACTUALIZAR','ELIMINAR') DEFAULT 'CONSULTAR',
  `valor` enum('EXITO','ERROR') DEFAULT 'ERROR',
  `descripcion` varchar(255) DEFAULT '',
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `sql` text,
  PRIMARY KEY (`accion`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
    ";
    $consulta = $db->sql_query($sql);
    $db->sql_close();
    return($consulta);
  }
}
//$h=new Historial();
//$h-> set_Acceso("","000","EXITO",$sql="");
?>