<?php
$root = (!isset($root)) ? "../../../" : $root;
require_once($root . "librerias/Configuracion.cnf.php");
/* 
 * Copyright (c) 2015, Jose Alexis Correa Valencia <jalexiscv@gmail.com>
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
Sesion::init();
$usuario = Sesion::usuario();
// Modulo
require_once($root."modulos/usuarios/librerias/Usuarios_Historial.class.php");
require_once($root."modulos/usuarios/librerias/Usuarios_Jerarquias.class.php");
require_once($root."modulos/usuarios/librerias/Usuarios_Politicas.class.php");
require_once($root."modulos/usuarios/librerias/Usuarios_Roles.class.php");
require_once($root."modulos/usuarios/librerias/Usuarios_Equipos.class.php");
require_once($root."modulos/usuarios/librerias/Usuarios_Perfiles.class.php");
require_once($root."modulos/usuarios/librerias/Usuarios_Componentes.class.php");
require_once($root."modulos/usuarios/librerias/Usuarios_Menus.class.php");
require_once($root."modulos/usuarios/librerias/Usuarios_Modulo.class.php");
require_once($root."modulos/usuarios/librerias/Usuarios_Permisos.class.php");
require_once($root."modulos/usuarios/librerias/Usuarios.class.php");

//
//echo("<!--<pre>");
//print_r($_SESSION);
//echo("</pre>-->");
?>