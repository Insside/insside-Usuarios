<?php
/*
 * Copyright (c) 2014, Alexis
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
/** Variables * */
$cadenas = new Cadenas();
$fechas = new Fechas();
$usuarios = new Usuarios();
$equipos = new Equipos();
$empleados = new Empleados();
$usuario = $usuarios->consultar($_REQUEST['usuario']);
/** Valores * */
$valores = $usuario;
/** Campos * */
$f->campos['usuario'] = $f->text("usuario", $valores['usuario'], "15", "required codigo", true);
$f->campos['alias'] = $f->text("alias", $valores['alias'], "64", "required", false);
$f->campos['clave'] = $f->password("clave", $valores['clave'], "64", "required", false);
$f->campos['equipo'] = $equipos->combo("equipo", $valores['equipo']);
$f->campos['fecha'] = $f->text("fecha", $valores['fecha'], "10", "", true);
$f->campos['hora'] = $f->text("hora", $valores['hora'], "8", "", true);
$f->campos['creador'] = $f->text("creador", $valores['creador'], "11", "", true);
$f->campos['empleado'] = $empleados->combo("empleado", $valores['empleado']);
$f->campos['cerrar'] = $f->button("cerrar" . $f->id, "button", "Cerrar");
$f->campos['actualizar'] = $f->button("actualizar" . $f->id, "submit", "Actualizar");
/** Celdas * */
$f->celdas["usuario"] = $f->celda("Código De Usuario:", $f->campos['usuario']);
$f->celdas["alias"] = $f->celda("Usuario (Alias):", $f->campos['alias']);
$f->celdas["clave"] = $f->celda("Clave:", $f->campos['clave']);
$f->celdas["equipo"] = $f->celda("Equipo De Trabajo:", $f->campos['equipo']);
$f->celdas["fecha"] = $f->celda("Fecha:", $f->campos['fecha']);
$f->celdas["hora"] = $f->celda("Hora:", $f->campos['hora']);
$f->celdas["creador"] = $f->celda("Creador:", $f->campos['creador']);
$f->celdas["empleado"] = $f->celda("Perfil Del Empleado Asociado:", $f->campos['empleado']);
/** Filas * */
$f->fila["fila1"] = $f->fila($f->celdas["usuario"] . $f->celdas["alias"] . $f->celdas["clave"]);
$f->fila["fila2"] = $f->fila($f->celdas["fecha"] . $f->celdas["hora"] . $f->celdas["creador"]);
$f->fila["fila3"] = $f->fila($f->celdas["equipo"]);
$f->fila["fila4"] = $f->fila($f->celdas["empleado"]);
/** Compilando * */
$f->filas($f->fila['fila1']);
$f->filas($f->fila['fila2']);
$f->filas($f->fila['fila3']);
$f->filas($f->fila['fila4']);
$f->botones($f->campos["cerrar"]);
$f->botones($f->campos["actualizar"]);
?>
<script type="text/javascript">
  MUI.resizeWindow($('<?php echo($f->ventana); ?>'), {width: 640, height: 270, top: 0, left: 0});
  MUI.centerWindow($('<?php echo($f->ventana); ?>'));

  if ($('cerrar<?php echo($f->id); ?>')) {
    $('cerrar<?php echo($f->id); ?>').addEvent('click', function(e) {
      MUI.closeWindow($('<?php echo($f->ventana); ?>'));
    });
  }
</script>