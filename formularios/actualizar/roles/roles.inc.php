<?php
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
$sesion = new Sesion();
$usuarios = new Usuarios();
$jerarquias = new Jerarquias();
$transaccion = @$_REQUEST['transaccion'];
$usuario = $usuarios->consultar(@$_REQUEST['usuario_usuario']);
$f->oculto("usuario", $usuario['usuario']);
?>

<table class="datosJerarquias" width="100%" cellpadding="3">
  <tr class="titulares">
    <td width="10"></td>
    <td align="center"><?php echo($usuario['usuario']); ?>[ Jerarquia De Roles ]</td>
  </tr>
  <?php
  $db = new MySQL();
  $acentos = $db->sql_query("SET NAMES 'utf8'");
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
    $estado = $jerarquias->estado($fila['rol'], $usuario['usuario']);
    echo("	<tr class=\"" . $class . "\"><td><input name=\"roles[" . $fila['rol'] . "]\" type=\"checkbox\" value=\"true\" " . (($estado) ? 'checked="checked"' : '') . "/></td><td align=\"left\" nowrap>&nbsp;<b>" . $fila['nombre'] . "</b></td></tr>");
  }
  $db->sql_close();
  ?>
  <tr><td></td><td><input id="actualizar" name="actualizar" type="submit" value="Actualizar" ></td></tr>
</table>