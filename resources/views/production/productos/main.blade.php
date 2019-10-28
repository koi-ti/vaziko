@extends('layout.layout')

@section('title') Productos @stop

@section('content')
    @yield ('module')

    <script type="text/template" id="add-productop-tpl">
        <section class="content-header">
            <h1>
                Productos <small>Administración de productos</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
                <li><a href="{{ route('productosp.index')}}">Producto</a></li>
                <% if( !_.isUndefined(edit) && !_.isNull(edit) && edit) { %>
                    <li><a href="<%- window.Misc.urlFull( Route.route('productosp.show', { productosp: id}) ) %>"><%- id %></a></li>
                    <li class="active">Editar</li>
                <% }else{ %>
                    <li class="active">Nuevo</li>
                <% } %>
            </ol>
        </section>

        <section class="content">
            <div class="box box-success spinner-main">
                <div class="box-body">
                    <form method="POST" accept-charset="UTF-8" id="form-productosp" data-toggle="validator">
                        <div class="row">
                            <label for="productop_nombre" class="col-sm-1 control-label">Nombre</label>
                            <div class="form-group col-sm-11">
                                <input type="text" id="productop_nombre" name="productop_nombre" value="<%- productop_nombre %>" placeholder="Nombre" class="form-control input-sm input-toupper" maxlength="250" required>
                            </div>
                        </div>
                        <div class="row">
                            <label for="productop_tipoproductop" class="col-sm-1 control-label">Tipo de producto</label>
                            <div class="form-group col-sm-4 ">
                                <select name="productop_tipoproductop" id="productop_tipoproductop" class="form-control select2-default-clear" required>
                                    @foreach( App\Models\Production\TipoProductop::getTypeProductsp() as $key => $value)
                                        <option value="{{ $key }}" <%- productop_tipoproductop == '{{ $key }}' ? 'selected': '' %>>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="productop_subtipoproductop" class="col-sm-1 control-label">Subtipo de producto</label>
                            <div class="form-group col-sm-4 ">
                                <select name="productop_subtipoproductop" id="productop_subtipoproductop" class="form-control select2-default" required>
                                    <option value="<%- productop_subtipoproductop %>"><%- subtipoproductop_nombre %></option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label for="productop_observaciones" class="col-sm-1 control-label">Detalle</label>
                            <div class="form-group col-sm-6">
                                <textarea id="productop_observaciones" name="productop_observaciones" class="form-control" rows="2" placeholder="Detalle"><%- productop_observaciones %></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <label for="productop_abierto" class="col-sm-1 control-label">Abierto</label>
                            <div class="form-group col-md-1">
                                <input type="checkbox" id="productop_abierto" name="productop_abierto" value="productop_abierto" class="change-productop-abierto-koi-component" <%- parseInt(productop_abierto) ? 'checked': ''%>>
                            </div>
                            <label for="productop_ancho_med" class="col-sm-1 control-label">Ancho</label>
                            <div class="form-group col-md-2">
                                <select name="productop_ancho_med" id="productop_ancho_med" class="form-control">
                                    <option value="" selected>Seleccione</option>
                                    @foreach( App\Models\Inventory\Unidad::getUnidades() as $key => $value)
                                        <option value="{{ $key }}" <%- productop_ancho_med == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="productop_alto_med" class="col-sm-1 control-label">Alto</label>
                            <div class="form-group col-md-2">
                                <select name="productop_alto_med" id="productop_alto_med" class="form-control">
                                    <option value="" selected>Seleccione</option>
                                    @foreach( App\Models\Inventory\Unidad::getUnidades() as $key => $value)
                                        <option value="{{ $key }}" <%- productop_alto_med == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label for="productop_cerrado" class="col-sm-1 control-label">Cerrado</label>
                            <div class="form-group col-md-1">
                                <input type="checkbox" id="productop_cerrado" name="productop_cerrado" value="productop_cerrado" <%- parseInt(productop_cerrado) ? 'checked': ''%> class="change-productop-cerrado-koi-component">
                            </div>
                            <label for="productop_c_med_ancho" class="col-sm-1 control-label">Ancho</label>
                            <div class="form-group col-md-2">
                                <select name="productop_c_med_ancho" id="productop_c_med_ancho" class="form-control">
                                    <option value="" selected>Seleccione</option>
                                    @foreach( App\Models\Inventory\Unidad::getUnidades() as $key => $value)
                                        <option value="{{ $key }}" <%- productop_c_med_ancho == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="productop_c_med_alto" class="col-sm-1 control-label">Alto</label>
                            <div class="form-group col-md-2">
                                <select name="productop_c_med_alto" id="productop_c_med_alto" class="form-control">
                                    <option value="" selected>Seleccione</option>
                                    @foreach( App\Models\Inventory\Unidad::getUnidades() as $key => $value)
                                        <option value="{{ $key }}" <%- productop_c_med_alto == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label for="productop_3d" class="col-sm-1 control-label">3D</label>
                            <div class="form-group col-sm-1">
                                <input type="checkbox" id="productop_3d" name="productop_3d" value="productop_3d" <%- parseInt(productop_3d) ? 'checked': ''%> class="change-productop-3d-koi-component">
                            </div>
                            <label for="productop_3d_ancho_med" class="col-sm-1 control-label">Ancho</label>
                            <div class="form-group col-md-2">
                                <select name="productop_3d_ancho_med" id="productop_3d_ancho_med" class="form-control">
                                    <option value="" selected>Seleccione</option>
                                    @foreach( App\Models\Inventory\Unidad::getUnidades() as $key => $value)
                                        <option value="{{ $key }}" <%- productop_3d_ancho_med == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="productop_3d_alto_med" class="col-sm-1 control-label">Alto</label>
                            <div class="form-group col-md-2">
                                <select name="productop_3d_alto_med" id="productop_3d_alto_med" class="form-control">
                                    <option value="" selected>Seleccione</option>
                                    @foreach( App\Models\Inventory\Unidad::getUnidades() as $key => $value)
                                        <option value="{{ $key }}" <%- productop_3d_alto_med == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="productop_3d_profundidad_med" class="col-sm-1 control-label">Profundidad</label>
                            <div class="form-group col-md-2">
                                <select name="productop_3d_profundidad_med" id="productop_3d_profundidad_med" class="form-control">
                                    <option value="" selected>Seleccione</option>
                                    @foreach( App\Models\Inventory\Unidad::getUnidades() as $key => $value)
                                        <option value="{{ $key }}" <%- productop_3d_profundidad_med == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label for="productop_tiro" class="col-sm-1 control-label">Tiro</label>
                            <div class="form-group col-md-1">
                                <input type="checkbox" id="productop_tiro" name="productop_tiro" value="productop_tiro" <%- parseInt(productop_tiro) ? 'checked': ''%>>
                            </div>

                            <label for="productop_retiro" class="col-sm-1 control-label">Retiro</label>
                            <div class="form-group col-md-1">
                                <input type="checkbox" id="productop_retiro" name="productop_retiro" value="productop_retiro" <%- parseInt(productop_retiro) ? 'checked': ''%>>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="box-footer with-border">
                    <div class="row">
                        <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6 text-left">
                            <a href="<%- window.Misc.urlFull( (typeof(id) !== 'undefined' && !_.isUndefined(id) && !_.isNull(id) && id != '') ? Route.route('productosp.show', { productosp: id}) : Route.route('productosp.index') ) %>" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
                        </div>
                        <div class="col-md-2 col-sm-6 col-xs-6 text-right">
                            <button type="button" class="btn btn-primary btn-sm btn-block submit-productosp">{{ trans('app.save') }}</button>
                        </div>
                    </div>
                </div>
            </div>
            <% if (typeof(id) !== 'undefined' && !_.isUndefined(id) && !_.isNull(id) && id != '') { %>
                <div class="box box-solid spinner-main">
                    <div class="nav-tabs-custom tab-success">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_areas" data-toggle="tab">Áreas involucradas</a></li>
                            <li><a href="#tab_tips" data-toggle="tab">Tips</a></li>
                            <li><a href="#tab_maquinas" data-toggle="tab">Máquinas</a></li>
                            <li><a href="#tab_materiales" data-toggle="tab">Materiales</a></li>
                            <li><a href="#tab_acabados" data-toggle="tab">Acabados</a></li>
                            <li><a href="#tab_imagenes" data-toggle="tab">Imágenes</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_areas">
                                <div class="box box-solid" id="wrapper-productop-areas">
                                    <div class="box-body">
                                        <form method="POST" accept-charset="UTF-8" id="form-productosp3" data-toggle="validator">
                                            <div class="row">
                                                <label for="productop3_areap" class="control-label col-sm-1 col-sm-offset-1 hidden-xs">Área</label>
                                                <div class="form-group col-sm-7 col-xs-10">
                                                    <select name="productop3_areap" id="productop3_areap" class="form-control select2-default" required>
                                                        @foreach( App\Models\Production\Areap::getAreas() as $key => $value)
                                                            <option value="{{ $key }}">{{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-1 col-xs-2 text-right">
                                                    <button type="button" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="areap" data-field="productop3_areap">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                                <div class="form-group col-sm-1 col-xs-12">
                                                    <button type="submit" class="btn btn-success btn-sm btn-block">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- table table-bordered table-striped -->
                                        <div class="box-body table-responsive no-padding">
                                            <table id="browse-areas-productop-list" class="table table-hover table-bordered" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th width="5%"></th>
                                                        <th width="95%">Nombre</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{-- Render content areas --}}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_tips">
                                <div class="box box-solid" id="wrapper-productop-tips">
                                    <div class="box-body">
                                        <form method="POST" accept-charset="UTF-8" id="form-productosp2" data-toggle="validator">
                                            <div class="row">
                                                <div class="form-group col-sm-11">
                                                    <input id="productop2_tip" name="productop2_tip" class="form-control input-sm input-toupper" placeholder="Tip" type="text" required>
                                                </div>
                                                <div class="form-group col-sm-1">
                                                    <button type="submit" class="btn btn-success btn-sm btn-block">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- table table-bordered table-striped -->
                                        <div class="box-body table-responsive no-padding">
                                            <table id="browse-tips-productop-list" class="table table-hover table-bordered" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th width="5%"></th>
                                                        <th width="95%">Tip</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{-- Render content tips --}}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_maquinas">
                                <div class="box box-solid" id="wrapper-productop-maquinas">
                                    <div class="box-body">
                                        <form method="POST" accept-charset="UTF-8" id="form-productosp4" data-toggle="validator">
                                            <div class="row">
                                                <label for="productop4_maquinap" class="control-label col-sm-1 col-sm-offset-1 hidden-xs">Máquina</label>
                                                <div class="form-group col-sm-7 col-xs-10">
                                                    <select name="productop4_maquinap" id="productop4_maquinap" class="form-control select2-default" required>
                                                        @foreach( App\Models\Production\Maquinap::getMaquinas() as $key => $value)
                                                            <option value="{{ $key }}">{{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-1 col-xs-2 text-right">
                                                    <button type="button" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="maquinap" data-field="productop4_maquinap">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                                <div class="form-group col-sm-1 col-xs-12">
                                                    <button type="submit" class="btn btn-success btn-sm btn-block">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- table table-bordered table-striped -->
                                        <div class="box-body table-responsive no-padding">
                                            <table id="browse-maquinas-productop-list" class="table table-hover table-bordered" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th width="5%"></th>
                                                        <th width="5%">Código</th>
                                                        <th width="90%">Nombre</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{-- Render content maquinas --}}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_materiales">
                                <div class="box box-solid" id="wrapper-productop-materiales">
                                    <div class="box-body">
                                        <form method="POST" accept-charset="UTF-8" id="form-productosp5" data-toggle="validator">
                                            <div class="row">
                                                <label for="productop5_materialp" class="control-label col-sm-1 col-sm-offset-1 hidden-xs">Material</label>
                                                <div class="form-group col-sm-7 col-xs-10">
                                                    <select name="productop5_materialp" id="productop5_materialp" class="form-control select2-default" required>
                                                        @foreach( App\Models\Production\Materialp::getMateriales() as $key => $value)
                                                            <option value="{{ $key }}">{{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-1 col-xs-2 text-right">
                                                    <button type="button" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="materialp" data-field="productop5_materialp">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                                <div class="form-group col-sm-1 col-xs-12">
                                                    <button type="submit" class="btn btn-success btn-sm btn-block">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- table table-bordered table-striped -->
                                        <div class="box-body table-responsive no-padding">
                                            <table id="browse-materiales-productop-list" class="table table-hover table-bordered" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th width="5%"></th>
                                                        <th width="5%">Código</th>
                                                        <th width="90%">Nombre</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{-- Render content materiales --}}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_acabados">
                                <div class="box box-solid" id="wrapper-productop-acabados">
                                    <div class="box-body">
                                        <form method="POST" accept-charset="UTF-8" id="form-productosp6" data-toggle="validator">
                                            <div class="row">
                                                <label for="productop6_acabadop" class="control-label col-sm-1 col-sm-offset-1 hidden-xs">Acabado</label>
                                                <div class="form-group col-sm-7 col-xs-10">
                                                    <select name="productop6_acabadop" id="productop6_acabadop" class="form-control select2-default" required>
                                                        @foreach( App\Models\Production\Acabadop::getAcabados() as $key => $value)
                                                            <option value="{{ $key }}">{{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-1 col-xs-2 text-right">
                                                    <button type="button" class="btn btn-default btn-flat btn-sm btn-add-resource-koi-component" data-resource="acabadop" data-field="productop6_acabadop">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                                <div class="form-group col-sm-1 col-xs-12">
                                                    <button type="submit" class="btn btn-success btn-sm btn-block">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- table table-bordered table-striped -->
                                        <div class="box-body table-responsive no-padding">
                                            <table id="browse-acabados-productop-list" class="table table-hover table-bordered" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th width="5%"></th>
                                                        <th width="5%">Código</th>
                                                        <th width="90%">Nombre</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{-- Render content acabados --}}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_imagenes">
                                <div class="box box-solid">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="form-group col-sm-12">
                                                <div class="fine-uploader"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <% } %>
        </section>
    </script>

    <script type="text/template" id="productop-tip-item-list-tpl">
        <% if (edit) { %>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-productop2-remove" data-resource="<%- id %>">
                    <span><i class="fa fa-times"></i></span>
                </a>
            </td>
        <% } %>
        <td><%- productop2_tip %></td>
    </script>

    <script type="text/template" id="productop-area-item-list-tpl">
        <% if (edit) { %>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-productop3-remove" data-resource="<%- id %>">
                    <span><i class="fa fa-times"></i></span>
                </a>
            </td>
        <% } %>
        <td><%- areap_nombre %></td>
    </script>

    <script type="text/template" id="productop-maquina-item-list-tpl">
        <% if (edit) { %>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-productop4-remove" data-resource="<%- id %>">
                    <span><i class="fa fa-times"></i></span>
                </a>
            </td>
        <% } %>
        <td><%- maquinap_id %></td>
        <td><%- maquinap_nombre %></td>
    </script>

    <script type="text/template" id="productop-material-item-list-tpl">
        <% if (edit) { %>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-productop5-remove" data-resource="<%- id %>">
                    <span><i class="fa fa-times"></i></span>
                </a>
            </td>
        <% } %>
        <td><%- materialp_id %></td>
        <td><%- materialp_nombre %></td>
    </script>

    <script type="text/template" id="productop-acabado-item-list-tpl">
        <% if (edit) { %>
            <td class="text-center">
                <a class="btn btn-default btn-xs item-productop6-remove" data-resource="<%- id %>">
                    <span><i class="fa fa-times"></i></span>
                </a>
            </td>
        <% } %>
        <td><%- acabadop_id %></td>
        <td><%- acabadop_nombre %></td>
    </script>

    <script type="text/template" id="qq-template-producto">
        <div class="qq-uploader-selector qq-uploader" qq-drop-area-text="{{ trans('app.files.drop') }}">
            <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
                <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
            </div>
            <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
                <span class="qq-upload-drop-area-text-selector"></span>
            </div>
            @if (auth()->user()->ability('admin', ['create', 'edit'], ['module' => 'productosp']))
                <div class="buttons">
                    <div class="qq-upload-button-selector qq-upload-button">
                        <div><i class="fa fa-folder-open" aria-hidden="true"></i> {{ trans('app.files.choose-file') }}</div>
                    </div>
                </div>
                <span class="qq-drop-processing-selector qq-drop-processing">
                    <span>{{ trans('app.files.process') }}</span>
                    <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
                </span>
            @endif
            <ul class="qq-upload-list-selector qq-upload-list" aria-live="polite" aria-relevant="additions removals">
                <li>
                    <div class="qq-progress-bar-container-selector">
                        <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
                    </div>
                    <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                    <a class="preview-link" target="_blank">
                        <img class="qq-thumbnail-selector" qq-max-size="100" qq-server-scale>
                    </a>
                    <span class="qq-upload-file-selector qq-upload-file"></span>
                    <span class="qq-upload-size-selector qq-upload-size"></span>
                    <button type="button" class="qq-btn qq-upload-cancel-selector qq-upload-cancel">{{ trans('app.cancel') }}</button>
                    <button type="button" class="qq-btn qq-upload-retry-selector qq-upload-retry">{{ trans('app.files.retry') }}</button>
                    @if (auth()->user()->ability('admin', ['create', 'edit'], ['module' => 'productosp']))
                        <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">{{ trans('app.delete') }}</button>
                    @endif
                    <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
                </li>
            </ul>
            <dialog class="qq-alert-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Cerrar</button>
                </div>
            </dialog>
            <dialog class="qq-confirm-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">No</button>
                    <button type="button" class="qq-ok-button-selector">Si</button>
                </div>
            </dialog>
            <dialog class="qq-prompt-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <input type="text">
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">{{ trans('app.cancel') }}</button>
                    <button type="button" class="qq-ok-button-selector">{{ trans('app.continue') }}</button>
                </div>
            </dialog>
        </div>
    </script>
@stop
