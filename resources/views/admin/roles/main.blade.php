@extends('layout.layout')

@section('title') Roles @stop

@section('content')
    <section class="content-header">
        <h1>
            Roles <small>Administración de roles</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{trans('app.home')}}</a></li>
            @yield('breadcrumb')
        </ol>
    </section>

    <section class="content">
        @yield ('module')

        <!-- Modal add permisorol -->
        <div class="modal fade" id="modal-permisorol-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content" id="content-permisorol-component">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="inner-title-modal">Permisos</h4>
                    </div>
                    {!! Form::open(['id' => 'form-permisorol-component', 'data-toggle' => 'validator']) !!}
                        <div class="modal-body box box-success">
                            <div class="content-modal"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary btn-sm">Continuar</button>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        {{-- Templates --}}
        <script type="text/template" id="add-rol-tpl">
            <div class="box-body">
                <form method="POST" accept-charset="UTF-8" id="form-roles" data-toggle="validator">
                    <div class="row">
                        <label for="display_name" class="col-sm-1 control-label">Nombre</label>
                        <div class="form-group col-sm-3">
                            <input id="display_name" value="<%- display_name %>" placeholder="Mostrar nombre" class="form-control input-sm" name="display_name" required>
                        </div>

                        <label for="name" class="col-sm-1 control-label">Key</label>
                        <div class="form-group col-sm-4">
                            <input id="name" value="<%- name %>" placeholder="Nombre" class="form-control input-sm" name="name" <%- typeof(id) !== 'undefined' ? 'readonly' : ''%> >
                        </div>
                    </div>
                    <div class="row">
                        <label for="display_name" class="col-sm-1 control-label">Descripcion</label>
                        <div class="form-group col-sm-8">
                            <textarea id="description" name="description" class="form-control" rows="2" placeholder="Descripcion"><%- description %></textarea>
                        </div>
                    </div>

                    <div class="box-header with-border">
                        <div class="row">
                            <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6">
                                <a href="<%- window.Misc.urlFull( (typeof(id) !== 'undefined' && !_.isUndefined(id) && !_.isNull(id) && id != '') ? Route.route('roles.show', { roles: id}) : Route.route('roles.index') ) %>" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
                            </div>
                            <div class="col-md-2 col-sm-6 col-xs-6">
                                <button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.save') }}</button>
                            </div>
                        </div>
                    </div>
                </form>

                <% if( typeof(id) !== 'undefined' && !_.isUndefined(id) && !_.isNull(id) && id != '') { %>
                <div class="row">
                    <div class="form-group col-md-12">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab_modulos" data-toggle="tab">Permisos</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_modulos">
                                    <div class="box-group">
                                        @foreach(App\Models\Base\Modulo::getModules() as $father)
                                            <div id="wrapper-father-{{ $father->id }}" class="panel box box-whithout-border">
                                                <div class="box-header">
                                                    <h1 class="box-title">
                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse_{{ $father->id }}">{{ $father->display_name }}</a>
                                                    </h1>
                                                </div>
                                                <div id="collapse_{{ $father->id }}" class="panel-collapse collapse">
                                                    <div class="box-body">
                                                        <table class="table table-condensed">
                                                            @foreach($father->childrens as $children)
                                                                <tr>
                                                                    <th>
                                                                        <a class="toggle-children" data-resource="{{ $children->id }}" data-father="{{ $father->id }}" data-nivel1="{{ $children->nivel1 }}" data-nivel2="{{ $children->nivel2 }}" data-toggle="collapse" data-parent="#accordion" href="#collapse_children_{{ $children->id }}">
                                                                            {{ $children->display_name }}
                                                                        </a>
                                                                        <div id="collapse_children_{{ $children->id }}" class="collapse">
                                                                            <table id="wrapper-permisions-{{ $children->id }}" class="table table-striped">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th style="width: 30%"></th>
                                                                                        <% _.each(permissions, function(permission) { %>
                                                                                            <th style="width: 10%" class="text-center"><%- permission.display_name %></th>
                                                                                        <% }); %>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    {{-- Render permissions --}}
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </th>
                                                                </tr>
                                                            @endforeach
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <% } %>
            </div>
        </script>

        <script type="text/template" id="permissions-rol-list-tpl">
            <th><a href="#" class="btn-set-permission" data-father="<%- father %>" data-resource="<%- id %>"><%- display_name %></a></th>
            <% _.each(permissions, function(permission) { %>
                <td class="text-center">
                    <span class="label label-<%- mpermissions.indexOf(permission.id) != -1 ? 'success' : 'danger'  %>">
                        <i class="fa fa-fw fa-<%- mpermissions.indexOf(permission.id) != -1 ? 'check' : 'close'  %>"></i>
                    </span>
                </td>
            <% }); %>
        </script>
    </section>
@stop