@extends('layout.layout')

@section('title') 404 | Página no encontrada! @stop

@section('content')
    <section class="content-header">
        <h1> <i class="fa fa-lock text-yellow"></i> Oops! Página no encontrada. </h1>
    </section>

    <section class="content">
        <p>
            La página o módulo que buscas no se encuentra o ha sido removido. Por favor comunicate con el
            <strong>administrador</strong> para mayor información. <button type="button"
                class="btn btn-default btn-sm history-back">{{ trans('app.comeback') }}</button>
        </p>
    </section>
@stop
