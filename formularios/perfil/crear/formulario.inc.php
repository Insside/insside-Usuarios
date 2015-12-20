<?php

$root = (!isset($root)) ? "../../../../../" : $root;
require_once($root . "modulos/usuarios/librerias/Configuracion.cnf.php");
require_once($root . "librerias/Componentes.class.php");

$usuarios = new Usuarios();
$cadenas = new Cadenas();
$equipos = new Usuarios_Equipos();
$componentes = new Componentes();
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
$transaccion = $validaciones->recibir("transaccion");
$usuario = Sesion::usuario();
$componentes=new Componentes();

$v = array();
$v['info'] = "<p>Este formulario le permitirá crear un perfil personal para un usuario y realizar el cambio de contraseña, si la información que desea modificar no es accesible mediante este formulario contacte al departamento de sistemas.</p>";
if (!isset($v['foto']) || empty($v['foto'])) {
    $v['foto'] = "modulos/usuarios/imagenes/usuario.fw.png";
}
/** Campos * */
$f->oculto("itable", $validaciones->recibir("itable"));
$f->campos['info'] = $v['info'];
$f->campos['foto'] = "<img src=\"" . $v['foto'] . "\" width=\"200\" height=\"267\"/>";
$f->campos['documento'] = $componentes->combo_documentos("documento", @$v['documento']);
$f->campos['identificacion'] = $f->iTextBox("identificacion","identificacion","","required","10");
$f->campos['sexo'] =$componentes->combo_sexo("sexo", "M");
$f->campos['nombres'] =$f->iTextBox("nombres","nombre","","required"); 
$f->campos['apellidos'] =$f->iTextBox("apellidos","nombre","","required"); 
$f->campos['direccion'] = $f->text("direccion","", "128", "required", false);
$f->campos['telefonos'] = $f->text("telefonos","", "128", "required", false);
$f->campos['correo'] = $f->iTextBox("correo","correo","","required"); 
$f->campos['ayuda'] = $f->button("ayuda" . $f->id, "button", "Ayuda");
$f->campos['modificar'] = $f->button("modificar" . $f->id, "submit", "Registrar");
$f->campos['cancelar'] = $f->button("cancelar" . $f->id, "button", "Cancelar");
/** Celdas * */
$f->celdas["info"] = $f->celda("", $f->campos['info']);
$f->celdas["documento"] = $f->celda("Documento:", $f->campos['documento']);
$f->celdas["identificacion"] = $f->celda("Identificación:", $f->campos['identificacion']);
$f->celdas["sexo"] = $f->celda("Sexo:", $f->campos['sexo']);
$f->celdas["nombres"] = $f->celda("Nombres:", $f->campos['nombres']);
$f->celdas["apellidos"] = $f->celda("Apellidos:", $f->campos['apellidos']);
$f->celdas["direccion"] = $f->celda("Dirección:", $f->campos['direccion']);
$f->celdas["telefonos"] = $f->celda("Teléfonos:", $f->campos['telefonos']);
$f->celdas["correo"] = $f->celda("Correo Electrónico:", $f->campos['correo']);

/** Filas * */
$f->fila['sf1'] = $f->fila($f->celdas["info"]);
$f->fila['sf2'] = $f->fila($f->celdas["documento"] . $f->celdas["identificacion"]);
$f->fila['sf3'] = $f->fila($f->celdas["sexo"] .$f->celdas["nombres"] . $f->celdas["apellidos"]);
$f->fila['sf4'] = $f->fila($f->celdas["direccion"] . $f->celdas["telefonos"]);
$f->fila['sf5'] = $f->fila($f->celdas["correo"]);
/** Subceldas * */
$f->celdas["foto"] = $f->celda("", $f->campos['foto'], "", "w200");
$f->celdas["datos"] = $f->celda("", $f->fila['sf1'] . $f->fila['sf2'] . $f->fila['sf3'] . $f->fila['sf4'] . $f->fila['sf5']);
/** Filas * */
$f->fila["f1"] = $f->fila($f->celdas["foto"] . $f->celdas["datos"]);
/** Compilando * */
$f->filas($f->fila['f1']);
//$f->filas($f->fila['fila2']);
//$f->filas($f->fila['fila3']);
//$f->filas($f->fila['fila4']);
/** Botones * */
$f->botones($f->campos["ayuda"], "inferior-izquierda");
$f->botones($f->campos["modificar"], "inferior-derecha");
$f->botones($f->campos["cancelar"], "inferior-derecha");
/** JavaScripts * */
$f->JavaScript("MUI.titleWindow($('" . ($f->ventana) . "'),\"Crear Perfil - <span style=\'color:#47639E;\'>v1.5</span>\");");
$f->JavaScript("MUI.resizeWindow($('" . ($f->ventana) . "'),{width: 640,height:390});");
//$f->JavaScript("MUI.centerWindow($('".$f->ventana."'));");
$f->eClick("cancelar" . $f->id, "MUI.closeWindow($('" . $f->ventana . "'));");
//$f->eClick("modificar".$f->id,"MUI.Usuarios_Usuario_Perfil_Modificar();");
?>
