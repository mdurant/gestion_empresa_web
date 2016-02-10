<?php
require_once("validatesession_html.php");
require_once("conexion/conexion.php");

session_start();

$IDEmpresa = $_SESSION['SESS_EMPRESA_ID'];

$query="SELECT IDEmpresa,
      RUT, RazonSocial
      FROM empresa
      WHERE
      empresa.IDEmpresa = '$IDEmpresa'";
$res = mysql_query($query,conectar::con());
$dato = mysql_fetch_assoc($res);

?>

<div class="navbar">
  <div class="navbar-inner">
    <div class="contanier">
    <table style="width:100%" >
      <tr>
        <td style="width:60%"><a  href="#" class="brand"><strong><small>Sistema de Gestión Administrativo - Empresa SOC. INOX POBLETE LTDA.</small></strong></a></td>
        <td style="width:50%" align="right">
              <div id="color1" >
                  <div >
                    * Empresa de Trabajo:
                    <strong style="color:rgb(229,96,59);text-shadow:1px 1px 1px rgb(0,0,0);">
                    <?php echo $dato['RazonSocial'];?>
                    </strong>
                  </div>
                  <div >
                    * Acceso Usuario: <strong style="color:rgb(229,96,59);text-shadow:1px 1px 1px rgb(0,0,0);">
                    <?php echo $_SESSION['SESS_USERNAME'].' ('.$_SESSION['SESS_PERFILNOMBRE'].')';?>
                    </strong>
                  </div>
                  <div>
                    Versión <?=$_SESSION['SESS_VERSION']?>
                  </div>
              </div>
        </td>
        </tr>
        <tr colspan="2">
        <td></td>
      </tr>
    </table>
      <ul class="nav" id="color2" style="width:100%">
        <li class="dropdown" >
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="icon-signal icon-white"></i>
              Comercial
              <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
              <li class="nav-header">Clientes/Cobranzas</li>
              <li><a href="crud/clientes_main.php" class="tabulador" title="Ficha Clientes">
              <i class="glyphicon glyphicon-list-alt"></i> Ficha Clientes</a></li>
              <li><a href="area/notascredito/orden_main.php" class="tabulador" title="Nota de Crédito">
              <i class="glyphicon glyphicon-list-alt"></i> Notas Credito</a></li>
                  <li class="dropdown submenu">
                   <a href="#" class="dropdown-toggle" data toggle="dropdown">
                    <i class="glyphicon glyphicon-inbox"></i> Gestión Ventas</a>
                   <ul class="dropdown-menu submenu-show submenu-hide">
                      <li><a href="area/guiadespacho/ordencrud_main.php" class="tabulador" title="Guía de Despacho">Guía de Despacho</a></li>
                      <li><a href="area/guiadespacho_generica/ordencrud_main.php" class="tabulador" title="Guía de Despacho Genérica">Guía de Despacho Genérica</a></li>
                      <li><a href="area/boleta/boletacrud_main.php" class="tabulador" title="Boleta de Venta">Boleta de Venta</a></li>
                      <li><a href="area/factura/facturacrud_main.php" class="tabulador" title="Facturas de Ventas">Facturas</a></li>
                      <!-- <li class="disabled"><a href="#" class="tabulador" title="Devolución">Devolución</a></li>
                      <li class="disabled"><a href="#" class="tabulador" title="Anulación">Anulación</a></li> -->
                   </ul>
                  </li>

                  <li class="dropdown submenu">
                   <a href="#" class="dropdown-toogle" data toggle="dropdown">
                    <i class="glyphicon glyphicon-bookmark"></i> Gestión Cotización</a>
                   <ul class="dropdown-menu submenu-show submenu-hide">
                      <li><a href="area/cotizacion/cotizacioncrud_main.php" class="tabulador" title="Cotizaciones">Cotizaciones</a></li>
                      <li><a href="area/cotizacion/aplazar_cotizacioncrud_main.php" class="tabulador" title="Cotizaciones: Aplazar">Aplazar</a></li>
                      <li><a href="area/cotizacion/seguimiento_cotizacioncrud_main.php" class="tabulador" title="Cotizaciones: Seguimiento Simple">Seguimiento Simple</a></li>

                   </ul>
                  </li>

                  <li class="divider"></li>
                  <li class="nav-header">Proveedores/Pagos</li>
                  <li><a href="crud/proveedores_main.php" class="tabulador" title="Ficha Proveedores">
                  <i class="glyphicon glyphicon-user"></i> Ficha Proveedores</a></li>
                    <li class="dropdown submenu">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-flag"></i> Gestión Compras</a>
                       <ul class="dropdown-menu submenu-show submenu-hide">

                         <li><a href="area/guiacompra/ordencrud_main.php" class="tabulador" title="Compras con Guia Despacho">Guia Despacho</a></li>
                         <li><a href="area/compras/compracrud_main.php" class="tabulador" title="Compras con Factura">Facturas</a></li>
                         <li><a href="area/compras-boleta/compracrud_main.php" class="tabulador" title="Compras con Boleta">Boletas</a></li>
                         <li><a href="crud/check_proveedores.php" class="tabulador" title="Pagos/Abonos">Pagos/Abonos</a></li>
                         <li><a href="crud/combustible_main.php" class="tabulador" title="Compra Combustible">Combustible</a></li>
                       </ul>
                    </li>


            </ul>
          </li>
        <li class="dropdown">

            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="icon-lock icon-white"></i>
              Operaciones
              <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
              <li class="nav-header">Inventario</li>
              <li><a href="area/inventario/inventariocrud_main.php" class="tabulador" title="Gestión Inventario">
              <i class="glyphicon glyphicon-qrcode"></i> Gestión Inventario</a></li>

              <li><a href="area/inventario/traspasocentral_main.php" class="tabulador" title="Inventario: Traspaso Desde Bodega Central">
              <i class="glyphicon glyphicon-tag"></i> Inventario: Traspaso Desde Bodega Central</a></li>
              <li><a href="area/inventario/ajuste_inventario_main.php" class="tabulador" title="Inventario: Ajuste de Inventario">
              <i class="glyphicon glyphicon-tag"></i> Inventario: Ajuste Inventario</a></li>
              <li><a href="area/inventario/traspasobodegas_main.php"  class="tabulador" title="Inventario: Traspaso Desde Bodegas">
              <i class="glyphicon glyphicon-tags"></i> Inventario: Traspaso Desde Bodegas</a></li>
              <li><a href="area/inventario/vistainventariocrud_main.php"  class="tabulador" title="Inventario: Vista Inventario">
              <i class="glyphicon glyphicon-eye-open"></i> Inventario: Vista Inventario</a></li>
              <li class="nav-header">Solicitudes a Bodega</li>
              <li><a href="area/solicitudes_bodega/solicitudescrud_main.php"  class="tabulador" title="Bodega: Solicitud de Productos">
              <i class="glyphicon glyphicon-tags"></i> Bodega : Solicitudes a Bodega</a></li>


            </ul>
          </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="icon-tasks icon-white"></i>
              Producción
              <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
              <li class="nav-header">Productos/Insumos</li>
              <li><a href="crud/productos_main.php" class="tabulador" title="Maestro Producto">
              <i class="glyphicon glyphicon-leaf"></i> Productos</a></li>
              <li><a href="crud/servicios_main.php" class="tabulador" title="Maestro Materiales">
              <i class="glyphicon glyphicon-asterisk"></i> Servicios / Materiales</a></li>
              <li><a href="crud/categoriaproductos_main.php" class="tabulador" title="Categoria Productos">
              <i class="glyphicon glyphicon-th-list"></i> Categoria Productos</a></li>
              <li class="divider"></li>
              <li class="nav-header">
                <i class="glyphicon glyphicon-cog"></i> Plan Producción</li>
               <li>
                <a href="crud/proyectos_main.php" class="tabulador" title="Mantenedor Proyectos">
                     <i class="glyphicon glyphicon-time"></i> Mantenedor Proyectos</a></li>
              <li><a href="area/OrdenTrabajo/ordencrud_main.php" class="tabulador" title="Gesti&oacute;n OTrdenes de Trabajo">
              <i class="glyphicon glyphicon-download-alt"></i> Gestión de Proyectos</a></li>
              <li><a href="area/OrdenTrabajo/vbuenocrud_main.php" class="tabulador" title="Seguimiento Ordenes de Trabajo">
              <i class="glyphicon glyphicon-bookmark"></i> Seguimiento Proyectos</a></li>
              <li><a href="area/OrdenTrabajo/plantillacrud_main.php" class="tabulador" title="Plantillas de Proyectos">
              <i class="glyphicon glyphicon-magnet"></i> Plantillas de Proyectos</a></li>
              <li><a href="area/servicios_a_proyectos/ordencrud_main.php" class="tabulador" title="Asociar Servicios a Proyectos">
              <i class="glyphicon glyphicon-retweet"></i> Asociar Servicios->Proyectos</a></li>

            </ul>
          </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="glyphicon glyphicon-file"></i>
              Informes
              <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
              <li class="nav-header">Ventas/Compras</li>
              <li class="disabled"><a href="#">Gestión Ventas</a></li>
              <li class="disabled"><a href="#">Gestión Compras</a></li>
              <li class="disabled"><a href="#">Gestión Cotizaciones</a></li>
              <li class="disabled"><a href="#">Compromisos x Pagar $</a></li>
              <li class="disabled"><a href="#">Compromisos x Cobrar $</a></li>
              <li class="divider"></li>
               <li class="nav-header">Inventarios</li>
              <li class="disabled"><a href="#">Consulta Stock</a></li>
              <li ><a href="crud/movimientos_productos_main.php" class="tabulador" title="Movimiento de Productos">Movimiento Productos</a></li>
              <li class="divider"></li>
               <li class="nav-header">Producción</li>
               <li><a href="crud/pedidos_trabajador_main.php" class="tabulador" title="Reporte: Solicitudes x Trabajador">
              <i class="glyphicon glyphicon-menu-hamburger"></i> Reporte : Solicitudes cargadas a Trabajador (es)</a></li>
              <li class="disabled"><a href="#">Seguimiento OT</a></li>
              <li class="disabled"><a href="#">Lista OT Rango Fecha</a></li>
              <li class=""><a href="area/servicios_a_proyectos/activoscrud_main.php" class="tabulador" title="Reporte Activos a Proyectos">Solicitudes Activos a Proyectos</a></li>


            </ul>
          </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="glyphicon glyphicon-asterisk"></i>
              Configuración
              <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
                <li class="nav-header">Opciones</li>
                <li class="dropdown submenu">
                   <a href="#" class="dropdown-toogle" data toggle="dropdown">
                      <i class="glyphicon glyphicon-briefcase"></i> Bodega/Almacen
                   </a>
                   <ul class="dropdown-menu submenu-show submenu-hide">
                    <li><a href='crud/almacen_main.php' class='tabulador' title='Almacenes'>Almacenes</a></li>
                    <li><a href='crud/unidadmedida_main.php' class='tabulador' title='Unidad de Medidas'>Unidad de Medidas</a></li>                  </ul>
                </li>


                <li><a href='crud/formapago_main.php' class='tabulador' title='Formas de Pago'>
                <i class="glyphicon glyphicon-usd"></i> Formas de Pago</a></li>
                <li><a href='crud/centro_costo_main.php' class='tabulador' title='Centros de Costos'>
                <i class="glyphicon glyphicon-tower"></i> Centros de Costos</a></li>
                <li><a href='crud/banco_main.php' class='tabulador' title='Bancos'>
                <i class="glyphicon glyphicon-bold"></i> Bancos</a></li>
                <li><a href='crud/tablaipc_main.php' class='tabulador' title='IPC'>
                <i class="glyphicon glyphicon-info-sign"></i> IPC</a></li>
                <li><a href='crud/jefes_main.php' class='tabulador' title='Jefaturas'>
                <i class="glyphicon glyphicon-eye-open"></i> Jefaturas</a></li>
                <li><a href='crud/trabajadores_main.php' class='tabulador' title='Trabajadores'>
                <i class="glyphicon glyphicon-user"></i> Trabajadores</a></li>

            </ul>
          </li>

        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="glyphicon glyphicon-th"></i>
              Sistema
              <b class="caret"></b>
            </a>


            <ul class="dropdown-menu">

                <li><a href='crud/empresas_main.php' class='tabulador' title='Empresas'>Empresas</a></li>
                <li><a href='crud/sucursales_main.php' class='tabulador' title='Sucursales'>Sucursales</a></li>
                <li class="dropdown submenu">
                   <a href="#" class="dropdown-toogle" data toggle="dropdown">Seguridad</a>
                   <ul class="dropdown-menu submenu-show submenu-hide">
                      <li><a href='crud/usuarios_main.php' class='tabulador' title='Usuarios'>Usuarios</a></li>
                      <li><a href='crud/perfiles_main.php' class='tabulador' title='Perfiles de Usuarios'>Perfiles de Usuarios</a></li>
                      <li><a href='crud/modulos_main.php' class='tabulador' title='Modulos del Sistema'>Modulos del Sistema</a></li>
                   </ul>
                </li>

              <li><a href="logout.php?ID=<?php echo session_id()?>">Cerrar Sistema</a>
            </ul>
          </li>


      </ul>
    </div>
  </div>
</div>
