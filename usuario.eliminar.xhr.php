<?php 
$root = (!isset($root)) ? "../../" : $root;
require_once($root . "modulos/usuarios/librerias/Configuracion.cnf.php");

//\\//\\//\\//\\ Variables Generadas //\\//\\//\\//\\
$sesion =new Sesion();
$usuarios =new Usuarios();

$transaccion = @$_REQUEST['transaccion'];
$accion = @$_REQUEST['accion'];
$usuario = $usuarios->consultar(@$_REQUEST['usuario']);

$formulario['id'] = "f" . $transaccion;
$formulario['ventana'] = "v" . $transaccion;
$formulario['contenedor'] = "c" . $transaccion;
$formulario['interno'] = "i" . $transaccion;
//\\//\\//\\//\\ Marco Creación Formulario //\\//\\//\\//\\
if (empty($accion)) {
 echo('<div id="' . $formulario['contenedor'] . '" class="formulario">');
 echo('<form name="' . $formulario['id'] . '" id="' . $formulario['id'] . '" action="modulos/usuarios/usuario.eliminar.xhr.php?usuario=' . $usuario['usuario'] . '&transaccion=' . $transaccion . '" method="post">');
 echo('<div id="' . $formulario['interno'] . '">');
}
?>

<?php  if (!isset($_REQUEST['accion'])) { ?>
 <input name="accion" id="accion" type="hidden" value="eliminar" />
 <input name="usuario" id="solicitud" type="hidden" value="<?php  echo($usuario['usuario']); ?>" />
 <div id="mensaje">Esta realmente seguro de querer eliminar el usuario seleccionado [ <b><?php  echo($usuario['alias']); ?></b> ], esta acción no es reversible, al eliminar el usuario no se eliminaran los datos asociados al mismo los cuales continuaran disponibles en el sistema.
  <br /><br />Para cancelar cierre este mensaje para proceder a eliminar el rol, presione el botón eliminar.</div>
 <div id="recordatorio"><?php  echo($usuario['alias']); ?></div>
 <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr><td align="center" valign="middle" height="40">
    <input type="button" name="cancelar" id="cancelar" value="Cancelar" style="height:30px; width:100px; font-size:20px;">
    <input type="submit" name="registrar" id="registrar" value="Eliminar" style="height:30px; width:100px; font-size:20px;"></td></tr>
 </table>
<?php  } else { ?>
 <div id="mensaje">El usuario seleccionado fue eliminado correctamente, y se actualizo el listado de usuarios existentes. Cierre esta notificación para continuar.</div>
 <?php  $usuarios->eliminar($usuario['usuario']); ?>
<?php  } ?>
<?php 
if (empty($accion)) {
 echo('</div>');
 echo('</form>');
 echo('</div>');
}
?>
<?php  if (empty($accion)) { ?>
 <script type="text/javascript">
  var fv =new Form.Validator.Inline($('<?php  echo($formulario['id'] ); ?>'));
  // fv.addValidation("identificacion", "req", "Ingrese la ceula o nit del quien radica la solicitud.");
  if ($('cancelar')) {
   $('cancelar').addEvent('click', function(e) {
    $('<?php  echo($formulario['ventana'] ); ?>').retrieve('instance').close();
   });
  }
  new Form.Request($('<?php  echo($formulario['id'] ); ?>'), $('<?php  echo($formulario['interno'] ); ?>'), {
   requestOptions: {
    spinnerOptions: {
     message: 'Trasmitiendo datos...'
    }
   },
   onSend: function() {
    $('spinner').show();
   },
   onSuccess: function() {
    $('spinner').hide();
    if ($('<?php  echo($formulario['interno'] ); ?>') && MUI.options.standardEffects == true) {
     $('<?php  echo($formulario['interno'] ); ?>').setStyle('opacity', 0).get('morph').start({'opacity': 1});
    }
    MUI.Usuarios_Usuarios();
    $('<?php  echo($formulario['ventana'] ); ?>').retrieve('instance').close();
   }
  });
 </script>
<?php  } ?>