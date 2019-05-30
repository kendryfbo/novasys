<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
        <li class="header">Gestión de Calidad</li>
        <li class="treeview menu-open">
            <a href=""><i class="fa fa-check-circle-o"></i><span>No Conformidad</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>

            <ul class="treeview-menu">
                <li>
                <a href="{{url('/sgcalidad/NoConformidades/crear')}}"><i class="fa fa-file-o"></i> <span>Ingresar</span></a>
                <a href="{{url('/sgcalidad/NoConformidades')}}"><i class="fa fa-list-ol"></i> <span>Listado NC</span></a>
                <a href="{{url('/sgcalidad/NoConformidades/lista_administrador')}}"><i class="fa fa-tasks"></i> <span>Administrar NC</span></a>
                </li>

            </ul>
        </li>

        <li class="treeview menu-open">
            <a href=""><i class="fa fa-copy"></i><span>Documentación</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>

            <ul class="treeview-menu">
                <li>
                <a href="{{url('/sgcalidad/Documentos/crear')}}"><i class="fa fa-file-o"></i> <span>Ingresar</span></a>
                <a href="{{url('/sgcalidad/Documentos')}}"><i class="fa fa-file-pdf-o"></i> <span>Docs PDF</span></a>
                <a href="{{url('/sgcalidad/Documentos/acceso')}}"><i class="fa fa-file-pdf-o"></i> <span>Acceso Docs</span></a>
                </li>

            </ul>
        </li>



    </li>
    </ul>


    <!-- /.sidebar-menu -->
</section>
<!-- /.sidebar -->
