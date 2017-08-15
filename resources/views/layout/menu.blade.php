<ul class="sidebar-menu">
    <li class="header">Menú de navegación</li>
    <li class="{{ Request::route()->getName() == 'dashboard' ? 'active' : '' }}">
        <a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> <span>Dashboard </span></a>
    </li>

    {{-- Administracion --}}
    <li class="treeview {{ in_array(Request::segment(1), ['empresa', 'modulos', 'terceros', 'roles', 'permisos', 'actividades', 'municipios', 'departamentos', 'sucursales', 'puntosventa']) ? 'active' : '' }}">
        <a href="{{ route('dashboard') }}">
            <i class="fa fa-cog"></i> <span>Administración</span><i class="fa fa-angle-left pull-right"></i>
        </a>

        <ul class="treeview-menu">
            {{-- Modulos administracion --}}
            <li class="{{ in_array(Request::segment(1), ['empresa', 'terceros','roles']) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-wpforms"></i> Módulos <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::segment(1) == 'empresa' ? 'active' : '' }}">
                        <a href="{{ route('empresa.index') }}"><i class="fa fa-building"></i> Empresa</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'terceros' ? 'active' : '' }}">
                        <a href="{{ route('terceros.index') }}"><i class="fa fa-users"></i> Terceros</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'roles' ? 'active' : '' }}">
                        <a href="{{ route('roles.index') }}"><i class="fa fa-address-card-o"></i> Roles</a>
                    </li>
                </ul>
            </li>

            {{-- Referencias administracion --}}
            <li class="{{ in_array(Request::segment(1), ['actividades', 'modulos', 'permisos', 'municipios', 'departamentos', 'sucursales', 'puntosventa']) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-circle-o"></i> Referencias <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::segment(1) == 'actividades' ? 'active' : '' }}">
                        <a href="{{ route('actividades.index') }}"><i class="fa fa-circle-o"></i> Actividades</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'departamentos' ? 'active' : '' }}">
                        <a href="{{ route('departamentos.index') }}"><i class="fa fa-circle-o"></i> Departamentos</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'modulos' ? 'active' : '' }}">
                        <a href="{{ route('modulos.index') }}"><i class="fa fa-circle-o"></i> Modulos</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'municipios' ? 'active' : '' }}">
                        <a href="{{ route('municipios.index') }}"><i class="fa fa-circle-o"></i> Municipios</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'permisos' ? 'active' : '' }}">
                        <a href="{{ route('permisos.index') }}"><i class="fa fa-circle-o"></i> Permisos</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'puntosventa' ? 'active' : '' }}">
                        <a href="{{ route('puntosventa.index') }}"><i class="fa fa-circle-o"></i> Puntos de venta</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'sucursales' ? 'active' : '' }}">
                        <a href="{{ route('sucursales.index') }}"><i class="fa fa-circle-o"></i> Sucursales</a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>

    {{-- Cartera --}}
    <li class="treeview {{ in_array(Request::segment(1), ['facturas']) ? 'active' : '' }}">
        <a href="#">
            <i class="fa fa-suitcase"></i> <span>Cartera</span><i class="fa fa-angle-left pull-right"></i>
        </a>

        <ul class="treeview-menu">
            {{-- Modulos cartera --}}
            <li class="{{ in_array(Request::segment(1), ['facturas']) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-wpforms"></i> Módulos <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::segment(1) == 'facturas' ? 'active' : '' }}">
                        <a href="{{ route('facturas.index') }}"><i class="fa fa-pencil-square-o"></i> Facturas</a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>

    {{-- Contabilidad --}}
    <li class="treeview {{ in_array(Request::segment(1), ['asientos', 'plancuentas', 'centroscosto', 'folders', 'documentos', 'rplancuentas', 'rmayorbalance']) ? 'active' : '' }}">
        <a href="#">
            <i class="fa fa-book"></i> <span>Contabilidad</span><i class="fa fa-angle-left pull-right"></i>
        </a>

        <ul class="treeview-menu">
            {{-- Modulos contabilidad --}}
            <li class="{{ in_array(Request::segment(1), ['asientos']) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-wpforms"></i> Módulos <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::segment(1) == 'asientos' ? 'active' : '' }}">
                        <a href="{{ route('asientos.index') }}"><i class="fa fa-file-text-o"></i> Asientos</a>
                    </li>
                </ul>
            </li>

            {{-- Reportes contabilidad --}}
            <li class="{{ in_array(Request::segment(1), ['rplancuentas', 'rmayorbalance']) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-bar-chart-o"></i> Reportes <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::segment(1) == 'rplancuentas' ? 'active' : '' }}">
                        <a href="{{ route('rplancuentas.index') }}"><i class="fa fa-circle-o"></i> Plan cuentas</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'rmayorbalance' ? 'active' : '' }}">
                        <a href="{{ route('rmayorbalance.index') }}"><i class="fa fa-circle-o"></i> Mayor y balance</a>
                    </li>
                </ul>
            </li>

            {{-- Referencias contabilidad --}}
            <li class="{{ in_array(Request::segment(1), ['plancuentas', 'centroscosto', 'folders', 'documentos']) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-circle-o"></i> Referencias <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::segment(1) == 'centroscosto' ? 'active' : '' }}">
                        <a href="{{ route('centroscosto.index') }}"><i class="fa fa-circle-o"></i> Centros de costo</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'documentos' ? 'active' : '' }}">
                        <a href="{{ route('documentos.index') }}"><i class="fa fa-circle-o"></i> Documentos</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'folders' ? 'active' : '' }}">
                        <a href="{{ route('folders.index') }}"><i class="fa fa-circle-o"></i> Folders</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'plancuentas' ? 'active' : '' }}">
                        <a href="{{ route('plancuentas.index') }}"><i class="fa fa-circle-o"></i> Plan de cuentas</a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>

    {{-- Inventario --}}
    <li class="treeview {{ in_array(Request::segment(1), ['grupos', 'subgrupos', 'unidades', 'productos', 'traslados']) ? 'active' : '' }}">
        <a href="#">
            <i class="fa fa-list"></i> <span>Inventario</span><i class="fa fa-angle-left pull-right"></i>
        </a>

        <ul class="treeview-menu">
            {{-- Modulos inventario --}}
            <li class="{{ in_array(Request::segment(1), ['productos', 'traslados']) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-wpforms"></i> Módulos <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::segment(1) == 'productos' ? 'active' : '' }}">
                        <a href="{{ route('productos.index') }}"><i class="fa fa-wrench"></i> Insumos</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'traslados' ? 'active' : '' }}">
                        <a href="{{ route('traslados.index') }}"><i class="fa fa-arrows"></i> Traslados</a>
                    </li>
                </ul>
            </li>

            {{-- Referencias inventario --}}
            <li class="{{ in_array(Request::segment(1), ['grupos', 'subgrupos', 'unidades']) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-circle-o"></i> Referencias <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::segment(1) == 'grupos' ? 'active' : '' }}">
                        <a href="{{ route('grupos.index') }}"><i class="fa fa-circle-o"></i> Grupos</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'subgrupos' ? 'active' : '' }}">
                        <a href="{{ route('subgrupos.index') }}"><i class="fa fa-circle-o"></i> Subgrupos</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'unidades' ? 'active' : '' }}">
                        <a href="{{ route('unidades.index') }}"><i class="fa fa-circle-o"></i> Unidades</a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>

    {{-- Produccion --}}
    <li class="treeview {{ in_array(Request::segment(1), ['ordenes', 'productosp', 'cotizaciones', 'areasp', 'acabadosp', 'maquinasp', 'materialesp', 'tiposmaterialp', 'tipoproductosp']) ? 'active' : '' }}">
        <a href="#">
            <i class="fa fa-cogs"></i> <span>Producción</span><i class="fa fa-angle-left pull-right"></i>
        </a>

        <ul class="treeview-menu">
            {{-- Modulos produccion --}}
            <li class="{{ in_array(Request::segment(1), ['ordenes', 'productosp', 'cotizaciones']) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-wpforms"></i> Módulos <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::segment(1) == 'cotizaciones' ? 'active' : '' }}">
                        <a href="{{ route('cotizaciones.index') }}"><i class="fa fa-puzzle-piece"></i> Cotizaciones</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'productosp' ? 'active' : '' }}">
                        <a href="{{ route('productosp.index') }}"><i class="fa fa-barcode"></i> Productos</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'ordenes' ? 'active' : '' }}">
                        <a href="{{ route('ordenes.index') }}"><i class="fa fa-building-o"></i> Ordenes</a>
                    </li>
                </ul>
            </li>
            {{-- Referencias produccion --}}
            <li class="{{ in_array(Request::segment(1), ['areasp', 'acabadosp', 'maquinasp', 'materialesp', 'tiposmaterialp', 'tipoproductosp']) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-circle-o"></i> Referencias <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::segment(1) == 'acabadosp' ? 'active' : '' }}">
                        <a href="{{ route('acabadosp.index') }}"><i class="fa fa-circle-o"></i> Acabados</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'areasp' ? 'active' : '' }}">
                        <a href="{{ route('areasp.index') }}"><i class="fa fa-circle-o"></i> Áreas</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'maquinasp' ? 'active' : '' }}">
                        <a href="{{ route('maquinasp.index') }}"><i class="fa fa-circle-o"></i> Máquinas</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'materialesp' ? 'active' : '' }}">
                        <a href="{{ route('materialesp.index') }}"><i class="fa fa-circle-o"></i> Materiales</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'tiposmaterialp' ? 'active' : '' }}">
                        <a href="{{ route('tiposmaterialp.index') }}"><i class="fa fa-circle-o"></i> Tipo de material</a>
                    </li>
                    <li class="{{ Request::segment(1) == 'tipoproductosp' ? 'active' : '' }}">
                        <a href="{{ route('tipoproductosp.index') }}"><i class="fa fa-circle-o"></i> Tipo de producto</a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>

    {{-- Tesoreria --}}
    <li class="treeview {{ in_array(Request::segment(1), ['facturap']) ? 'active' : '' }}">
        <a href="#">
            <i class="fa fa-balance-scale"></i> <span>Tesorería</span><i class="fa fa-angle-left pull-right"></i>
        </a>

        <ul class="treeview-menu">
            {{-- Modulos tesoreria --}}
            <li class="{{ in_array(Request::segment(1), ['facturap']) ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-wpforms"></i> Módulos <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::segment(1) == 'facturap' ? 'active' : '' }}">
                        <a href="{{ route('facturap.index') }}"><i class="fa fa-pencil-square-o"></i> Factura proveedor</a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>
</ul>
