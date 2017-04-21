<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">

  <!-- Sidebar Menu -->
  <ul class="sidebar-menu">
	<li class="header">Menu</li>
	<!-- Optionally, you can add icons to the links -->
	<li class="active"><a href="#"><i class="fa fa-link"></i> <span>Link</span></a></li>

    @foreach ($menus as $key => $value)

        @if (is_array($value))
            <li class="treeview">
              <a href="#"><i class="fa fa-link"></i> <span>{{$key}}</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
            @foreach ($value as $item)
            		<li><a href="#">{{$item}}</a></li>
            @endforeach
              </ul>
            </li>
        @else
            <li><a href="#"><i class="fa fa-link"></i> <span>{{$value}}</span></a></li>

        @endif

    @endforeach
  </ul>
  <!-- /.sidebar-menu -->
</section>
<!-- /.sidebar -->
