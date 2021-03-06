<?php
$usuarios=new Usuarios();
$up=new Usuarios_Perfiles();
$validaciones=new Validaciones();
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
//print_r($_REQUEST);
$usuario=Sesion::usuario();
$perfil= $validaciones->recibir("perfil");
$itable=$validaciones->recibir("itable");

$up->actualizar($perfil,'identificacion', $validaciones->recibir("identificacion"));
$up->actualizar($perfil,'sexo', $validaciones->recibir("sexo"));
$up->actualizar($perfil,'nombres', $validaciones->recibir("nombres"));
$up->actualizar($perfil,'apellidos', $validaciones->recibir("apellidos"));
$up->actualizar($perfil,'direccion', $validaciones->recibir("direccion"));
$up->actualizar($perfil,'telefonos', $validaciones->recibir("telefonos"));
$up->actualizar($perfil,'correo', $validaciones->recibir("correo"));



if($validaciones->recibir("clave".$f->id)==$validaciones->recibir("confirmacion".$f->id)){
  $usuarios->actualizar($usuario['usuario'],'clave', $validaciones->recibir("clave".$f->id));
  echo("<div class=\"success\"><b>Notificación</b>: Actualización realizada correcta y exitosamente.</div>");
}else{
  echo("<div class=\"error\"><b>Advertencia</b>: La clave y la confirmación no coinciden. </div>");
}

$f->JavaScript("MUI.closeWindow($('" . ($f->ventana) . "'));");
$f->JavaScript("if(".$itable."){".$itable.".refresh();}");

?>