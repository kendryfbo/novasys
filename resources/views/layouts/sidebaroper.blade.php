<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
        <li class="header">Opéraciones</li>
        <li class="treeview menu-open">
            <a href=""><i class="fa fa-truck"></i> <span>Logistica</span>
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
                        <li><a href="{{url('bodega/config')}}"><i class=""></i> <span>Bodega</span></a></li>
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
                        <li><a href="{{url('bodega/egreso')}}"><i class=""></i> <span>Egresos</span></a></li>
                        <li><a href="{{url('bodega/ingreso')}}"><i class=""></i> <span>Ingresos</span></a></li>
                        <li><a href="{{url('bodega/pallet')}}"><i class=""></i> <span>Pallets</span></a></li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href=""><i class="fa fa-code-fork"></i> <span>Informes</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('buscaLote')}}"><i class=""></i> <span>Busca Lote</span></a></li>
                        <li><a href="{{route('reporteBodega')}}"><i class=""></i> <span>Saldos Bodega</span></a></li>
                        <li><a href="{{route('reporteStockTotal')}}"><i class=""></i> <span>Stock Total</span></a></li>
                    </ul>
                </li>

            </ul>
        </li>

        <li class="treeview menu-open">
            <a href=""><i class="fa fa-industry"></i> <span>Producción</span>
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
                        <li><a href="{{url('produccion/premezcla')}}"><i class=""></i> <span>Prod. Premezcla</span></a></li>
                        <li><a href="{{url('produccion/mezclado')}}"><i class=""></i>  <span>Prod. Mezclado</span></a></li>
                        <li><a href="{{url('produccion/envasado')}}"><i class=""></i>  <span>Prod. Envasado</span></a></li>
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
                        <li><a href="{{route('reporteTerminoProceso')}}"><i class=""></i> <span>Termino Proceso</span></a></li>
                    </ul>
                </li>

            </ul>
        </li>
    </ul>
    <!-- /.sidebar-menu -->
</section>
<!-- /.sidebar -->
