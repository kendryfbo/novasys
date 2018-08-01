<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">

  <!-- Sidebar Menu -->
  <ul class="sidebar-menu">
	<li class="header">Comercial</li>
    <li class="treeview menu-open">
      <a href=""><i class="fa fa-flag"></i> <span>Nacional</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
          <li class="treeview menu-open">
            <a href=""><i class="fa fa-wrench"></i> <span>Mantenedor</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="{{url('comercial/clientesNacionales')}}"><i class=""></i> <span>Clientes</span></a></li>
                <li><a href="{{url('comercial/vendedores')}}"><i class=""></i> <span>Vendedores</span></a></li>
                <li><a href="{{url('comercial/listaPrecios')}}"><i class=""></i> <span>Lista de Precios</span></a></li>
                <li><a href="{{url('comercial/formasPagos')}}"><i class=""></i> <span>Condiciones de Pago</span></a></li>
            </ul>
          </li>
          <li class="treeview">
            <a href=""><i class="fa fa-code-fork"></i> <span>Movimiento</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="{{url('comercial/notaVenta')}}"><i class=""></i> <span>Nota de Venta</span></a></li>
                <li><a href="{{url('comercial/facturasNacionales')}}"><i class=""></i> <span>Facturacion</span></a></li>
                <li><a href="{{url('comercial/notasCreditoNac')}}"><i class=""></i> <span>Nota Credito</span></a></li>
                <li><a href="{{url('comercial/notasDebitoNac')}}"><i class=""></i> <span>Nota Debito</span></a></li>
            </ul>
          </li>

          <li class="treeview">
            <a href=""><i class="fa fa-code-fork"></i> <span>Informes</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="{{url('comercial/informesNac/facturaNac')}}"><i class=""></i> <span>Informe X Fact</span></a></li>
                <li><a href="{{url('comercial/informesNac/facturaNacProd')}}"><i class=""></i> <span>Informe X Prod</span></a></li>
            </ul>
          </li>
          <li><a href="{{route('autNotaVenta')}}"><i class="fa fa-check-square-o"></i> <span>Aut. Nota Venta</span></a></li>
          <li><a href="{{url('comercial/notasCreditoNac/autorizacion')}}"><i class="fa fa-check-square-o"></i> <span>Aut. Nota Credito</span></a></li>
      </ul>
    </li>
    <li class="treeview menu-open">
      <a href=""><i class="fa fa-globe"></i> <span>Internacional</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
          <li class="treeview menu-open">
            <a href=""><i class="fa fa-wrench"></i> <span>Mantenedor</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="{{url('comercial/clientesIntl')}}"><i class=""></i> <span>Clientes Inter.</span></a></li>
                <li><a href="{{url('comercial/aduanas')}}"><i class=""></i> <span>Aduanas</span></a></li>
                <li><a href="{{url('comercial/puertosEmbarque')}}"><i class=""></i> <span>Puerto Emb.</span></a></li>
                <li><a href="{{url('comercial/FormasPagosIntl')}}"><i class=""></i> <span>Condiciones de Pago</span></a></li>
            </ul>
          </li>
          <li class="treeview">
            <a href=""><i class="fa fa-code-fork"></i> <span>Movimiento</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="{{url('comercial/proformas')}}"><i class=""></i> <span>Proforma</span></a></li>
                <li><a href="{{url('comercial/guiaDespacho')}}"><i class=""></i> <span>Guia Despacho</span></a></li>
                <li><a href="{{url('comercial/notasCreditoIntl')}}"><i class=""></i> <span>Nota Credito</span></a></li>
                <li><a href="{{url('comercial/notasDebitoIntl')}}"><i class=""></i> <span>Nota Debito</span></a></li>
                <li><a href="{{url('comercial/packingList/crear')}}"><i class=""></i> <span>Packing List.</span></a></li>
                <li><a href="{{url('comercial/FacturaIntl')}}"><i class=""></i> <span>Factura Export.</span></a></li>
                <li><a href="{{url('comercial/facturaIntlSII')}}"><i class=""></i> <span>Factura S.I.I</span></a></li>
            </ul>
          </li>
          <li class="treeview">
            <a href=""><i class="fa fa-code-fork"></i> <span>Informes</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
                {{--<li><a href="{{url('comercial/informesIntl/proformas')}}"><i class=""></i> <span>Proforma</span></a></li>--}}
                <li><a href="{{url('comercial/informesIntl/facturaIntl')}}"><i class=""></i> <span>Informe X Factura</span></a></li>
                <li><a href="{{url('comercial/informesIntl/facturaIntlProd')}}"><i class=""></i> <span>Informe X Producto</span></a></li>
          </li>
      </ul>
      <li><a href="{{url('comercial/proformas/autorizacion')}}"><i class="fa fa-check-square-o"></i> <span>Aut. Proforma</span></a></li>
    </li>
  </ul>
  <!-- /.sidebar-menu -->
</section>
<!-- /.sidebar -->
