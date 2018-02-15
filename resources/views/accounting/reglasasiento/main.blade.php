@extends('layout.layout')

@section('title') Asiento reglas @stop

@section('content')
<section class="content-header">
    <h1>
        Asiento <small>Generador de asiento con reglas</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
        <li class="active">Generador de asiento con reglas</li>
    </ol>
</section>

<section class="content">
    <div class="box box-success" id="intereses-main">
        <div class="box-body">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            {!! Form::open(['post'=>'get', 'id' => 'form-generar-asiento', 'data-toggle' => 'validator']) !!}
                <div class="box-header">
                    <div class="row">
                        <label for="factura_numero" class=" text-right col-sm-1 col-md-offset-3 control-label">Factura:</label>
                        <div class="form-group col-md-4 col-sm-6 col-xs-6">
                            <input id="factura_numero" name="factura_numero" class="form-control input-sm" placeholder="Digite aquí número de factura" type="text" required>
						</div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-md-offset-5 col-sm-6 col-xs-6">
                            <button type="submit" class="btn btn-default btn-sm btn-block">
                                <i class="fa fa-file-text-o"></i>  Generar asiento
                            </button>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}

            @if(isset($asiento))
                <div class="row">
                    <div class="form-group col-md-1">
                        <label for="asiento1_ano" class="control-label">Año</label>
                        <div>{{ $asiento->encabezado->asiento1_ano }}</div>
                    </div>
                    <div class="form-group col-md-1">
                        <label for="asiento1_mes" class="control-label">Mes</label>
                        <div>{{ $asiento->encabezado->asiento1_mes ? config('koi.meses')[$asiento->encabezado->asiento1_mes] : ''  }}</div>
                    </div>
                    <div class="form-group col-md-1">
                        <label for="asiento1_dia" class="control-label">Día</label>
                        <div>{{ $asiento->encabezado->asiento1_dia }}</div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-3 col-xs-10">
                        <label for="asiento1_folder" class="control-label">Folder</label>
                        <div>{{ $asiento->encabezado->folder_nombre }}</div>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="asiento1_documento" class="control-label">Documento</label>
                        <div>{{ $asiento->encabezado->documento_nombre }}</div>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="asiento1_numero" class="control-label">Número</label>
                        <div>{{ $asiento->encabezado->asiento1_numero }}</div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-9">
                        <label for="asiento1_beneficiario" class="control-label">Beneficiario</label>
                        <div>
                                {{ $asiento->encabezado->tercero_nit }}
                            - {{ $asiento->encabezado->tercero_nombre }}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-9">
                        <label for="asiento1_detalle" class="control-label">Detalle</label>
                        <div>{{ $asiento->encabezado->asiento1_detalle }}</div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-2">
                        <label class="control-label">Usuario elaboro</label>
                        <div>
                                {{ $asiento->encabezado->username_elaboro }}
                        </div>
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Fecha elaboro</label>
                        <div>{{ $asiento->encabezado->asiento1_fecha_elaboro }}</div>
                    </div>
                </div><br>

                <div class="box-footer table-responsive">
                    <table id="generator-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Cuenta</th>
                                <th>Nombre de la cuenta</th>
                                <th>Tercero</th>
                                <th>Centro Costo</th>
                                <th>Base</th>
                                <th>Debito</th>
                                <th>Credito</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{--*/  $tdebito = $tcredito = 0 ;  /*--}}
                            @foreach($asiento->detalle as $key => $item)
                            <tr>
                                <td>{{$item['Cuenta']}}</td>
                                <td>{{$item['Cuenta_Nombre']}}</td>
                                <td>{{$item['Tercero']}}</td>
                                <td>{{$item['CentroCosto_Nombre']}}</td>
                                <td class="text-right">{{number_format($item['Base'], 2, ',', '.')}}</td>
                                <td class="text-right">{{number_format($item['Debito'], 2, ',', '.')}}</td>
                                <td class="text-right">{{number_format($item['Credito'], 2, ',', '.')}}</td>
                            </tr>
                            {{--*/
                                $tdebito += $item['Debito'];
                                $tcredito += $item['Credito'];
                            /*--}}
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-right"colspan="5">Total: </th>
                                <th class="text-right">{{number_format($tdebito, 2, ',', '.')}}</th>
                                <th class="text-right">{{number_format($tcredito, 2, ',', '.')}}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endif
        </div>
    </div>
</section>
@stop
