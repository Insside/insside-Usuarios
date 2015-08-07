<?php 
$root = (!isset($root)) ? "../../" : $root;
require_once($root . "modulos/usuarios/librerias/Configuracion.cnf.php");
//\\//\\//\\//\\ Variables Generadas //\\//\\//\\//\\
$sesion =new Sesion();
$roles =new Roles();

$transaccion = @$_REQUEST['transaccion'];
$accion = @$_REQUEST['accion'];
$rol = $roles->consultar(@$_REQUEST['rol']);

$formulario['id'] = "f" . $transaccion;
$formulario['ventana'] = "v" . $transaccion;
$formulario['contenedor'] = "c" . $transaccion;
$formulario['interno'] = "i" . $transaccion;
//\\//\\//\\//\\ Marco Creación Formulario //\\//\\//\\//\\
if (empty($accion)) {
 echo('<div id="' . $formulario['contenedor'] . '" class="formulario">');
 echo('<form name="' . $formulario['id'] . '" id="' . $formulario['id'] . '" action="modulos/usuarios/rol.eliminar.xhr.php?rol=' . $rol ['rol'] . '&transaccion=' . $transaccion . '" method="post">');
 echo('<div id="' . $formulario['interno'] . '">');
}
?>

<?php  if (!isset($_REQUEST['accion'])) { ?>
 <input name="accion" id="accion" type="hidden" value="verificar-datos" />
 <input name="rol" id="rol" type="hidden" value="<?php  echo($rol['rol']); ?>" />
 <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr><td><p class="mensaje">Esta realmente seguro de querer eliminar el rol seleccionado [ <b><u><?php  echo($rol['nombre']); ?></u></b> ], esta acción no es reversible y afecta a los usuarios que estén vinculados a este rol, al eliminar el rol eliminara también la política administrativa asociada al mismo por lo tanto los usuarios perderán los privilegios que este rol les concede sobre el sistema.
     <br /><br />Para cancelar cierre este mensaje para proceder a eliminar el rol, presione el botón eliminar.
    </p></td></tr>
  <tr><td align="center" valign="middle" height="40">

    <input type="submit" name="registrar" id="registrar" value="Eliminar" style="height:30px; width:100px; font-size:20px;"></td></tr>
  <tr><td>&nbsp;</td></tr>
 </table>
<?php  } else { ?>
 <?php  $roles->eliminar($rol['rol']); ?>
 <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr><td><p style="font-size:14px; line-height:13px;">La actualización se ha realizado satisfactoriamente, al cerrar esta ventana estará disponible, para ser vinculado o relacionado, según la función que se planee este cumpla en el sistema. </p></td></tr>

 </table>
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
    MUI.Usuarios_Roles();
    $('<?php  echo($formulario['ventana'] ); ?>').retrieve('instance').close();
   }
  });
 </script>
<?php  } ?>