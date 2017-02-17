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
            <div class="box-body" id="render-form-asientos">
                <form method="POST" accept-charset="UTF-8" id="form-asientos" data-toggle="validator">
                    <div class="row">
                        <label for="name" class="col-sm-1 control-label">Nombre</label>
                        <div class="form-group col-sm-4">
                            <input id="name" value="<%- name %>" placeholder="Nombre" class="form-control input-sm input-toupper" name="name" required>
                        </div>

                        <label for="display_name" class="col-sm-1 control-label">Mostrar</label>
                        <div class="form-group col-sm-3">
                            <input id="display_name" value="<%- display_name %>" placeholder="Mostrar nombre" class="form-control input-sm input-toupper" name="display_name" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <label for="display_name" class="col-sm-1 control-label">Descripcion</label>
                        <div class="form-group col-sm-8">
                            <textarea id="description" name="description" class="form-control" rows="2" placeholder="Descripcion"><%- description %></textarea>
                        </div>
                    </div>
                </form>
            </div>
        </script>
    </section>
@stop