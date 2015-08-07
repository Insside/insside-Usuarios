<?php 
$root = (!isset($root)) ? "../../" : $root;
require_once($root . "modulos/usuarios/librerias/Configuracion.cnf.php");
$sesion =new Sesion();

$transaccion = @$_REQUEST['transaccion'];
$formulario['id'] = "f" . $transaccion;
$formulario['ventana'] = "v" . $transaccion;
$formulario['contenedor'] = "c" . $transaccion;
$formulario['interno'] = "i" . $transaccion;

$accion = @$_REQUEST['accion'];
$rol = @$_REQUEST['rol'];
$nombre = @$_REQUEST['nombre'];
$descripcion = @$_REQUEST['descripcion'];

$estado['general'] = true;
if ($accion == "verificar-datos") {
 if (!empty($rol)) {
  $estado['rol'] = "verificado";
  if (!empty($nombre)) {
   $estado['nombre'] = "verificado";
   if (!empty($descripcion)) {
    $estado['descripcion'] = "verificado";
    $estado['general'] = false;
   } else {
    $estado['descripcion'] = "error";
   }
  } else {
   $estado['nombre'] = "error";
  }
 } else {
  $estado['rol'] = "error";
 }
} else {

}





//\\//\\//\\//\\ Marco Creación Formulario //\\//\\//\\//\\
if (empty($accion)) {
 echo('<div id="' . $formulario['contenedor'] . '" class="formulario">');
 echo('<form name="' . $formulario['id'] . '" id="' . $formulario['id'] . '" action="modulos/usuarios/rol.crear.xhr.php?transaccion=' . $transaccion . '" method="post">');
 echo('<div id="' . $formulario['interno'] . '">');
}
?>








<?php  if (!isset($_REQUEST['accion'])) { ?>
 <input name="accion" id="accion" type="hidden" value="verificar-datos" />
 <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr><td><label>Rol:</label></td></tr>
  <tr><td><input type="text" name="rol" id="rol" class="campo <?php  echo(@$estado['rol']); ?>" value="<?php  echo(time()); ?>" readonly="readonly"></td></tr>
  <tr><td><label>Nombre:</label></td></tr>
  <tr><td><input type="text" name="nombre" id="nombre" class="campo <?php  echo(@$estado['nombre']); ?>" value="<?php  echo($nombre); ?>"></td></tr>
  <tr><td><label>Descripción:</label></td></tr>
  <tr><td><textarea id="descripcion" name="descripcion" class="area <?php  echo(@$estado['descripcion']); ?>" ></textarea></td></tr>
  <tr><td align="center" valign="middle" height="40"><input type="submit" name="registrar" id="registrar" value="Crear" style="height:30px; width:160px; font-size:20px;"></td></tr>
  <tr><td>&nbsp;</td></tr>
 </table>
<?php  } else { ?>
 <?php  $roles->crear($rol, $nombre, $descripcion); ?>
 <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr><td><p style="font-size:14px; line-height:13px;">El nuevo rol ha sido creado satisfactoriamente, al cerrar esta ventana estará disponible, para ser vinculado o relacionado, según la función que se planee este cumpla en el sistema. </p></td></tr>
  <tr><td><input type="button" name="registrar" id="registrar" value="Cerrar" onclick="$('<?php  echo($ventana); ?>').close();"style="height:30px; width:160px; font-size:20px;"></td></tr>
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