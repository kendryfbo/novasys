<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
        <li class="header">Opéraciones</li>
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
                    </ul>
                </li>

                <li class="treeview">
                    <a href=""><i class="fa fa-code-fork"></i> <span>Movimiento</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{url('bodega')}}"><i class=""></i> <span>Consultar Bodega</span></a></li>
                        <li><a href="{{url('bodega/ingreso/')}}"><i class=""></i> <span>Ingreso</span></a></li>
                        <li><a href="{{url('bodega/pallet/MPManual/crear')}}"><i class=""></i> <span>Ingreso MP</span></a></li>
                        <li><a href="{{url('bodega/ingreso/pallet')}}"><i class=""></i> <span>Ing. Pallet Prod.</span></a></li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href=""><i class="fa fa-code-fork"></i> <span>Informes</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">

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

                <li class="treeview menu-open">
                    <a href=""><i class="fa fa-wrench"></i> <span>Mantenedor</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                </li>

                <li class="treeview">
                    <a href=""><i class="fa fa-code-fork"></i> <span>Movimiento</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{url('produccion/terminoProceso')}}"><i class=""></i> <span>Termino Proceso</span></a></li>
                        <li><a href="{{url('bodega/creacionPalletProduccion')}}"><i class=""></i> <span>Creacion Pallet</span></a></li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href=""><i class="fa fa-code-fork"></i> <span>Informes</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">

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
