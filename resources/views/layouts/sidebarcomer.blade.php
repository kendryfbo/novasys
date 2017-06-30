<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">

  <!-- Sidebar Menu -->
  <ul class="sidebar-menu">
	<li class="header">Comercial</li>
    <li class="treeview menu-open">
      <a href=""><i class="fa fa-link"></i> <span>Nacional</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
          <li class="treeview menu-open">
            <a href=""><i class="fa fa-link"></i> <span>Mantencion</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="{{url('comercial/clientesNacionales')}}"><i class="fa fa-link"></i> <span>Clientes</span></a></li>
                <li><a href="{{url('comercial/vendedores')}}"><i class="fa fa-link"></i> <span>Vendedores</span></a></li>
                <li><a href="{{url('comercial/listaPrecios')}}"><i class="fa fa-link"></i> <span>Lista de Precios</span></a></li>
                <li><a href="#"><i class="fa fa-link"></i> <span>Condiciones de Pago</span></a></li>
            </ul>
          </li>
          <li class="treeview">
            <a href=""><i class="fa fa-link"></i> <span>Movimiento</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="{{url('comercial/notasVentas')}}"><i class="fa fa-link"></i> <span>Nota de Venta</span></a></li>
                <li><a href="{{url('comercial/facturasNacionales')}}"><i class="fa fa-link"></i> <span>Facturacion</span></a></li>
            </ul>
          </li>
          <li><a href="{{url('comercial/notasVentas/autorizacion')}}"><i class="fa fa-link"></i> <span>Autorizar Nota Venta</span></a></li>
      </ul>
    </li>
    <li class="treeview menu-open">
      <a href=""><i class="fa fa-link"></i> <span>Internacional</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
          <li class="treeview menu-open">
            <a href=""><i class="fa fa-link"></i> <span>Mantencion</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-link"></i> <span>Clientes Inter.</span></a></li>
                <li><a href="#"><i class="fa fa-link"></i> <span>Adianas</span></a></li>
                <li><a href="#"><i class="fa fa-link"></i> <span>Condiciones de Pago</span></a></li>
            </ul>
          </li>
          <li class="treeview">
            <a href=""><i class="fa fa-link"></i> <span>Movimiento</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-link"></i> <span>Proforma</span></a></li>
                <li><a href="#"><i class="fa fa-link"></i> <span>Order Despacho</span></a></li>
                <li><a href="#"><i class="fa fa-link"></i> <span>Guia Despacho</span></a></li>
                <li><a href="#"><i class="fa fa-link"></i> <span>Factura Export.</span></a></li>
                <li><a href="#"><i class="fa fa-link"></i> <span>Nota de Credito</span></a></li>
                <li><a href="#"><i class="fa fa-link"></i> <span>Factura S.I.I</span></a></li>
            </ul>
          </li>
      </ul>
    </li>
  </ul>
  <!-- /.sidebar-menu -->
</section>
<!-- /.sidebar -->
