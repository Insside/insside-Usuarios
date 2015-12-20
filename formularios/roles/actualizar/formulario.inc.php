<?php
$sesion = new Sesion();
$usuarios = new Usuarios();
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
/** Procesos **/
$html="<table class=\"datosJerarquias\" width=\"100%\" cellpadding=\"3\">";
  $db = new MySQL();
  $sql = "SELECT * FROM `aplicacion_roles` ORDER BY `rol`";
  $consulta = $db->sql_query($sql);
  $total = $db->sql_numrows($consulta);
  $conteo = 0;
  while ($fila = $db->sql_fetchrow($consulta)) {
    $conteo++;
    $class = 'even';
    if ($conteo % 2 == 0) {
      $class = 'odd';
    }
    $estado = $jerarquias->estado($fila['rol'], $usuario);
    $html.=("	<tr class=\"" . $class . "\"><td><input name=\"roles[" . $fila['rol'] . "]\" type=\"checkbox\" value=\"true\" " . (($estado) ? 'checked="checked"' : '') . "/></td><td align=\"left\" nowrap>&nbsp;<b>" . $fila['nombre'] . "</b></td></tr>");
  }
  $db->sql_close();
$html.="</table>";
/** Campos **/
$f->oculto("usuario", $usuario);
$f->campos['roles']=$html;
$f->campos['ayuda'] = $f->button("ayuda" . $f->id, "button","Ayuda");
$f->campos['cancelar'] = $f->button("cancelar" . $f->id, "button","Cancelar");
$f->campos['asignar'] = $f->button("asignar" . $f->id, "submit","Asignar");
/** Celdas **/
$f->celdas["roles"] = $f->celda("Roles Asignables:", $f->campos['roles']);
/** Filas **/
$f->fila["fila1"] = $f->fila($f->celdas["roles"]);
/** Compilando **/
$f->filas($f->fila['fila1']);
/** Botones **/
$f->botones($f->campos['ayuda'], "inferior-izquierda");
$f->botones($f->campos['cancelar'], "inferior-derecha");
$f->botones($f->campos['asignar'], "inferior-derecha");
/** Javascripts **/
$f->JavaScript("MUI.titleWindow($('" . ($f->ventana) . "'), \"Roles Asignados ["+$usuario+"]\");");
$f->JavaScript("MUI.resizeWindow($('" . ($f->ventana) . "'), {width: 480, height:370});");
$f->JavaScript("MUI.centerWindow($('" . $f->ventana . "'));");
$f->eClick("cancelar" . $f->id, "MUI.closeWindow($('" . $f->ventana . "'));");
?>