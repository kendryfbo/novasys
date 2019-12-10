<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
        <li class="header">Módulo Informes</li>
        <li class="treeview menu-open">
            <a href=""><i class="fa fa-bar-chart"></i><span>Ventas</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>

            <ul class="treeview-menu">
                <li>
                  <a href="{{url('/informes/ventasPorMes')}}"><i class="fa fa-file-text-o"></i> <span>Mercado Total</span></a>
                </li>
                <li>
                  <a href="{{url('/informes/ventasPorMes/internacional')}}"><i class="fa fa-globe"></i> <span>Mercado Intl.</span></a>
                </li>
                <li>
                  <a href="{{url('/informes/ventasPorMes/nacional')}}"><i class="fa fa-flag-checkered"></i> <span>Mercado Nacional</span></a>
                </li>
            </ul>
        </li>

        <li class="treeview menu-open">
            <a href=""><i class="fa fa-bolt"></i><span>Menú</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li>
                  <a href="{{url('#')}}"><i class="fa fa-file-o"></i> <span>Ingresar</span></a>
                </li>

            </ul>
        </li>

    </li>
    </ul>


    <!-- /.sidebar-menu -->
</section>
<!-- /.sidebar -->
