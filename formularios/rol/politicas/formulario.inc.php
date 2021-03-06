<?php
$sesion = new Sesion();
$cadenas=new Cadenas();
$usuarios = new Usuarios();
$roles=new Usuarios_Roles();
$politicas = new Usuarios_Politicas();
$jerarquias = new Usuarios_Jerarquias();
/*
 * Copyright (c) 2013, Alexis
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
$usuario =$validaciones->recibir("usuario");
$rol=$roles->consultar($validaciones->recibir("rol"));

/** Procesos **/
$info="<div id=\"i100x100_permisos\" style=\"float: left;\"></div>";
$info.="<div class=\"notificacion\"><p><b>Recuerde</b>: "
        . "El presente formulario le permitirá modificar los permisos asignados al rol <b>".$rol['nombre']."</b>, se "
        . "le recuerda que la modificación de estas características afecta el acceso de los usuarios "
        . "a los diversos modulos y componentes del sistema, del listado localizado en la parte inferior "
        . "del presente mensaje, seleccione los permisos que desea asignar.Verificado el listado de "
        . "permisos asignados presione el botón <i>“Asignar”</i> para concluir el procedimiento.</p></div>";

$html="<div style=\"height:180px; overflow-y:scroll;\">";
  $db = new MySQL();
  $sql = "SELECT * FROM `aplicacion_permisos` ORDER BY `permiso`";
  $consulta = $db->sql_query($sql);
  $total = $db->sql_numrows($consulta);
  $conteo = 0;
  while ($fila = $db->sql_fetchrow($consulta)) {
    $conteo++;
    $class = 'even';
    if ($conteo % 2 == 0) {$class = 'odd';}
    $estado = $politicas->estado($rol['rol'], $fila['permiso']);
    $html.=("<div class=\"fila\" style=\"border:1px solid #cccccc;\"><div class=\"columna\"><input name=\"permisos[" . $fila['permiso'] . "]\" type=\"checkbox\" value=\"true\" " . (($estado) ? 'checked="checked"' : '') . "/>&nbsp;" . $cadenas->capitalizar($fila['permiso']) . "</div></div>");
  }
  $db->sql_close();
$html.="</div>";
/** Campos **/
$f->oculto("rol", $rol['rol']);
$f->campos['ayuda'] = $f->button("ayuda" . $f->id, "button","Ayuda");
$f->campos['cancelar'] = $f->button("cancelar" . $f->id, "button","Cancelar");
$f->campos['asignar'] = $f->button("asignar" . $f->id, "submit","Asignar");
/** Celdas **/
$f->celdas['info']=$f->celda("",$info,"","notificacion");
$f->celdas["permisos"] = $f->celda("",$html);
/** Filas **/
$f->fila["info"]=$f->fila($f->celdas['info'],"notificacion");
$f->fila["fila1"] = $f->fila($f->celdas["permisos"]);
/** Compilando **/
$f->filas($f->fila['info']);
$f->filas($f->fila['fila1']);
/** Botones **/
$f->botones($f->campos['ayuda'], "inferior-izquierda");
$f->botones($f->campos['asignar'], "inferior-derecha");
$f->botones($f->campos['cancelar'], "inferior-derecha");
/** Javascripts **/
$f->JavaScript("MUI.titleWindow($('" . ($f->ventana) . "'), \"Roles Asignados ["+$rol['nombre']+"]\");");
$f->JavaScript("MUI.resizeWindow($('" . ($f->ventana) . "'), {width: 640, height:370});");
$f->JavaScript("MUI.centerWindow($('" . $f->ventana . "'));");
$f->eClick("cancelar" . $f->id, "MUI.closeWindow($('" . $f->ventana . "'));");
?>