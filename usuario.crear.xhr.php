<?php 
$root = (!isset($root)) ? "../../" : $root;
require_once($root . "modulos/usuarios/librerias/Configuracion.cnf.php");

//\\//\\//\\//\\ Variables Generadas //\\//\\//\\//\\
$sesion =new Sesion();
$usuarios =new Usuarios();

$transaccion = @$_REQUEST['transaccion'];
$formulario['id'] = "f" . $transaccion;
$formulario['ventana'] = "v" . $transaccion;
$formulario['contenedor'] = "c" . $transaccion;
$formulario['interno'] = "i" . $transaccion;

$accion = @$_REQUEST['accion'];
$usuario = @$_REQUEST['usuario'];
$alias = @$_REQUEST['alias'];
$clave = @$_REQUEST['clave'];
$verificacion = @$_REQUEST['verificacion'];

$estado['general'] = true;
if ($accion == "verificar-datos") {
 if (!empty($usuario)) {
  $estado['usuario'] = "verificado";
  if (!empty($alias)) {
   $estado['alias'] = "verificado";
   if (!empty($clave)) {
    $estado['clave'] = "verificado";
    if (!empty($verificacion) && $clave == $verificacion) {
     $estado['verificacion'] = "verificado";
     $estado['general'] = false;
    } else {
     $estado['verificacion'] = "error";
    }
   } else {
    $estado['clave'] = "error";
   }
  } else {
   $estado['alias'] = "error";
  }
 } else {
  $estado['usuario'] = "error";
 }
} else {

}





//\\//\\//\\//\\ Marco Creación Formulario //\\//\\//\\//\\
if (empty($accion)) {
 echo('<div id="' . $formulario['contenedor'] . '" class="formulario">');
 echo('<form name="' . $formulario['id'] . '" id="' . $formulario['id'] . '" action="modulos/usuarios/usuario.crear.xhr.php?usuario=' . $usuario['usuario'] . '&transaccion=' . $transaccion . '" method="post">');
 echo('<div id="' . $formulario['interno'] . '">');
}
?>








<?php  if (!isset($_REQUEST['accion'])) { ?>
 <input name="accion" id="accion" type="hidden" value="verificar-datos" />
 <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr><td><label>Usuario: </label></td></tr>
  <tr><td align="center"><input type="text" name="usuario" id="usuario" class="campo <?php  echo(@$estado['usuario']); ?>" value="<?php  echo(time()); ?>" readonly="readonly"></td></tr>
  <tr><td><label>Alias:</label></td></tr>
  <tr><td align="center"><input type="text" name="alias" id="alias" class="campo <?php  echo(@$estado['alias']); ?>" value="<?php  echo($alias); ?>"></td></tr>
  <tr><td><label>Contraseña:</label></td></tr>
  <tr><td align="center"><input type="text" name="clave" id="clave" class="campo <?php  echo(@$estado['clave']); ?>" value="<?php  echo($clave); ?>"></td></tr>
  <tr><td ><label>Verificación (Contraseña):</label></td></tr>
  <tr><td align="center"><input type="text" name="verificacion" id="verificacion" class="campo <?php  echo(@$estado['verificacion']); ?>" ></td></tr>
  <tr><td align="center" valign="middle" height="40">
    <input type="submit" name="registrar" id="registrar" value="Registrar" style="height:30px; width:160px; font-size:20px;"></td></tr>
  <tr><td>&nbsp;</td></tr>
 </table>
<?php  } else { ?>
 <?php  $usuarios->crear($alias, $clave); ?>
 <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr><td><p>El nuevo usuario ha sido creado satisfactoriamente, al cerrar esta ventana estará disponible, para ser vinculado o relacionado, según la función que se planee este cumpla en el sistema. </p></td></tr>
  <tr><td><input type="button" name="registrar" id="registrar" value="Cerrar" onclick="$('<?php  echo($formulario['ventana'] ); ?>').retrieve('instance').close(); ').close();"style="height:30px; width:160px; font-size:20px;"></td></tr>
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
     MUI.Usuarios_Usuarios();
    }
   });
 </script>
<?php  } ?>