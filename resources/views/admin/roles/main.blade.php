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
                                    <div class="box-group" id="accordion-permisos">
                                        {{-- Content modulos --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <% } %>

                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6">
                            <a href="<%- window.Misc.urlFull( (typeof(id) !== 'undefined' && !_.isUndefined(id) && !_.isNull(id) && id != '') ? Route.route('roles.show', { roles: id}) : Route.route('roles.index') ) %>" class="btn btn-default btn-sm btn-block">{{ trans('app.cancel') }}</a>
                        </div>
                        <div class="col-md-2 col-sm-6 col-xs-6">
                            <button type="button" class="btn btn-primary btn-sm btn-block submit-rol">{{ trans('app.save') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </script>

        <script type="text/template" id="roles-modulo-list-tpl">
            <div class="box-header">
                <h4 class="box-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse_<%- nivel1 %>"><%- display_name %></a>
                </h4>
            </div>
            <div id="collapse_<%- nivel1 %>" class="panel-collapse collapse">
                <div class="box-body">
                    <table class="table table-condensed">
                        <tr>
                            <th><a href="#">Todos <%- display_name %></a></th>
                        </tr>
                        <tr>
                            <td><a data-toggle="collapse" data-parent="#accordion" href="#collapse_<%- nivel2 %>">Modulos</a></td>
                        </tr>
                        <tr>
                        <% if(nivel1 == 2) { %>
                            <td><a data-toggle="collapse" data-parent="#accordion" href="#collapse_<%- nivel2 %>">Reportes</a></td>
                        <% } %>
                        </tr>
                        <tr>
                            <td><a data-toggle="collapse" data-parent="#accordion" href="#collapse_<%- nivel2 %>">Referencias</a></td>
                        </tr>
                    </table>
                </div>
            </div>
        </script>
    </section>
@stop