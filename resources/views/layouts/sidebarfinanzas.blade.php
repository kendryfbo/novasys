<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
        <li class="header">Finanzas</li>
        <li class="treeview menu-open">
            <a href=""><i class="fa fa-credit-card"></i> <span>Adquisiciones</span>
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
                        <li><a href="{{url('adquisicion/proveedores')}}"><i class=""></i> <span>Proveedores</span></a></li>
                        <li><a href="{{url('adquisicion/formaPago')}}"><i class=""></i> <span>Cond. Pago</span></a></li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href=""><i class="fa fa-code-fork"></i> <span>Movimiento</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{url('adquisicion/ordenCompra')}}"><i class=""></i> <span>Orden Compra</span></a></li>
                        <li><a href="{{route('planProduccion')}}"><i class=""></i> <span>Analisis Produccion</span></a></li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href=""><i class="fa fa-code-fork"></i> <span>Informes</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('ordenCompraPendiente')}}"><i class=""></i> <span>O.C Pendientes</span></a></li>
                        <li><a href="{{route('reporteOrdenCompraProveedor')}}"><i class=""></i> <span>Reporte Proveedor</span></a></li>
                        <li><a href="{{route('reporteOrdenCompraInsumo')}}"><i class=""></i> <span>Reporte Insumos</span></a></li>
                    </ul>
                </li>

            </ul>
        </li>

        <li class="treeview menu-open">
            <a href=""><i class="fa fa-money"></i> <span>Finanzas</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>

            <ul class="treeview-menu">
                <li class="treeview">
                    <a href=""><i class="fa fa-globe"></i><span>Exportación</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                    <li><a href="{{url('finanzas/pagos_intl/crearAbono')}}"><i class=""></i> <span>Ingresar Abono</span></a></li>
                    <li><a href="{{url('finanzas/pagos_intl/abonos')}}"><i class=""></i> <span>Ver Abonos</span></a></li>
                    <li><a href="{{url('finanzas/pagos_intl/crear')}}"><i class=""></i> <span>Pago de Facturas</span></a></li>
                    <li><a href="{{url('finanzas/pagos_intl/historial')}}"><i class=""></i> <span>Historial de Pago</span></a></li>
                    <li><a href="{{url('finanzas/pagos_intl/facturasPorCobrar')}}"><i class=""></i> <span>Facturas x Cobrar</span></a></li>
                    <li><a href="{{url('finanzas/pagos_intl/anularFact')}}"><i class=""></i> <span>Anulación de Pagos</span></a></li>
                    <li><a href="#"><i class=""></i> <span>Informe de Cobranza</span></a></li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href=""><i class="fa fa-flag"></i><span>Nacional</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                    <li><a href="#"><i class=""></i> <span>Pago de Facturas</span></a></li>
                    <li><a href="#"><i class=""></i> <span>Historial de Pago</span></a></li>
                    <li><a href="#"><i class=""></i> <span>Facturas x Cobrar</span></a></li>
                    <li><a href="#"><i class=""></i> <span>Anulación de Pagos</span></a></li>
                    <li><a href="#"><i class=""></i> <span>Informe de Cobranza</span></a></li>
                    </ul>
                </li>


                <li><a href="{{url('finanzas/autorizacion/proforma')}}"><i class="fa fa-check-square-o"></i> <span>Aut. Proforma</span></a></li>
                <li><a href="{{url('finanzas/autorizacion/notaVenta')}}"><i class="fa fa-check-square-o"></i> <span>Aut. N.Venta</span></a></li>
                <li><a href="{{url('finanzas/autorizacion/ordenCompra')}}"><i class="fa fa-check-square-o"></i> <span>Aut. O.Compra</span></a></li>
            </ul>
        </li>
    </ul>
    <!-- /.sidebar-menu -->
</section>
<!-- /.sidebar -->
