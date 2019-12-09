<section class="content" id="ordenes-show">
    <div class="box box-primary">
        <div class="box-body bg-primary">
            <div class="row">
                <div class="form-group col-md-2">
                    <label class="control-label">Código</label>
                    <div>
                        {{ $orden->orden_codigo }}
                        @if($orden->orden_anulada)
                            <span class="label label-danger">ANULADA</span>
                        @elseif($orden->orden_abierta)
                            <span class="label label-success">ABIERTA</span>
                        @elseif($orden->orden_culminada)
                            <span class="label bg-blue">CULMINADO</span>
                        @else
                            <span class="label label-warning">CERRADA</span>
                        @endif
                    </div>
                </div>
                @if ($orden->precotizacion_codigo)
                    <div class="form-group col-md-2">
                        <label class="control-label">Pre-cotización</label>
                        <div>
                            <a href="{{ route('precotizaciones.show', ['precotizaciones' => $orden->cotizacion1_precotizacion]) }}" title="Ir a precotización">{{ $orden->precotizacion_codigo }}</a>
                        </div>
                    </div>
                @endif
                @if ($orden->cotizacion_codigo)
                    <div class="form-group col-md-2">
                        <label class="control-label">Cotización</label>
                        <div>
                            <a href="{{ route('cotizaciones.show', ['cotizaciones' => $orden->orden_cotizacion]) }}" title="Ir a cotización">{{ $orden->cotizacion_codigo }}</a>
                        </div>
                    </div>
                @endif
                <div class="form-group col-md-5">
                    <label class="control-label">Referencia</label>
                    <div>{{ $orden->orden_referencia }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label class="control-label">F. Inicio</label>
                    <div>{{ $orden->orden_fecha_inicio }}</div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">F. Entrega</label>
                    <div>{{ $orden->orden_fecha_entrega }}</div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">H. Entrega</label>
                    <div>{{ $orden->orden_hora_entrega }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-9">
                    <label class="control-label">Cliente</label>
                    <div>
                        <a href="{{ route('terceros.show', ['terceros' =>  $orden->orden_cliente ]) }}">
                            {{ $orden->tercero_nit }}
                        </a>- {{ $orden->tercero_nombre }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label class="control-label">Contacto</label>
                    <div>{{ $orden->tcontacto_nombre }}</div>
                </div>
                <div class="form-group col-md-3">
                    <label class="control-label">Teléfono</label>
                    <div>{{ $orden->tcontacto_telefono }}</div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label class="control-label">Suministran</label>
                    <div>{{ $orden->orden_suministran }}</div>
                </div>
                <div class="form-group col-md-6">
                    <label class="control-label">Forma pago</label>
                    <div>{{ $orden->orden_formapago }}</div>
                </div>
            </div>
            @if ($orden->orden_observaciones)
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="control-label">Detalle</label>
                        <div>{{ $orden->orden_observaciones }}</div>
                    </div>
                </div>
            @endif
            @if ($orden->orden_terminado)
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="control-label">Terminado</label>
                        <div>{{ $orden->orden_terminado }}</div>
                    </div>
                </div>
            @endif
            <div class="row">
                @if ($orden->orden_fecha_recogida1)
                    <div class="form-group col-md-3">
                        <label class="control-label">F. Recogida #1</label>
                        <div>{{ $orden->orden_fecha_recogida1 }}</div>
                    </div>
                @endif
                @if ($orden->orden_hora_recogida1)
                    <div class="form-group col-md-3">
                        <label class="control-label">H. Recogida #1</label>
                        <div>{{ $orden->orden_hora_recogida1 }}</div>
                    </div>
                @endif
                @if ($orden->orden_fecha_recogida2)
                    <div class="form-group col-md-3">
                        <label class="control-label">F. Recogida #2</label>
                        <div>{{ $orden->orden_fecha_recogida2 }}</div>
                    </div>
                @endif
                @if ($orden->orden_hora_recogida2)
                    <div class="form-group col-md-3">
                        <label class="control-label">H. Recogida #2</label>
                        <div>{{ $orden->orden_hora_recogida2 }}</div>
                    </div>
                @endif
            </div>
            <div class="row">
                <div class="form-group col-md-2">
                    <label class="control-label">Usuario elaboro</label>
                    <div>
                        <a href="{{ route('terceros.show', ['terceros' =>  $orden->orden_usuario_elaboro ]) }}" title="Ver tercero">
                            {{ $orden->username_elaboro }}</a>
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Fecha elaboro</label>
                    <div>{{ $orden->orden_fecha_elaboro }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="box box-primary spinner-main">
        <div class="box-header with-border">
            <h3 class="box-title title-producto-show"></b></h3>
            <div class="box-tools pull-right">
                <a href="#" class="btn btn-md producto-pagination" data-action="P">
                    <i class="fa fa-chevron-circle-left"></i>
                </a>
                <a href="#" class="btn btn-md producto-pagination" data-action="N">
                    <i class="fa fa-chevron-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="box-body" id="render-show-producto">

        </div>
    </div>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Quienes trabajaron en esta orden</h3>
        </div>
        <div class="box-body">
            <table id="browse-tiemposp-global-list" class="table table-bordered" cellspacing="0">
                <thead>
                    <tr>
                        <th width="20%">Tercero</th>
                        <th width="6%">Fecha</th>
                        <th width="5%">H. inicio</th>
                        <th width="5%">H. fin</th>
                        <th width="15%">Actividad</th>
                        <th width="20%">Subactividad</th>
                        <th width="25%">Área</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th colspan="7" class="text-center">No existen registros.</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="box-footer with-border">
        <div class="row">
            <div class="col-md-2 col-md-offset-5 col-sm-6 col-xs-6">
                <a href="{{ route('ordenes.index') }}" class="btn btn-default btn-sm btn-block">{{ trans('app.comeback') }}</a>
            </div>
        </div>
    </div>
</section>

<script type="text/template" id="qq-template-ordenp-producto">
    <div class="qq-uploader-selector qq-uploader" qq-drop-area-text="{{ trans('app.files.drop') }}">
        <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
            <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
        </div>
        <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
            <span class="qq-upload-drop-area-text-selector"></span>
        </div>

        @if (auth()->user()->ability('admin', 'opcional3', ['module' => 'ordenes']))
            <div class="buttons">
                <div class="qq-upload-button-selector qq-upload-button">
                    <div><i class="fa fa-folder-open" aria-hidden="true"></i> {{ trans('app.files.choose-file') }}</div>
                </div>
            </div>
            <span class="qq-drop-processing-selector qq-drop-processing">
                <span>{{ trans('app.files.process') }}</span>
                <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
            </span>
        @elseif (isset($ordenp2) && $ordenp2->continue)
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
                @if (auth()->user()->ability('admin', 'opcional3', ['module' => 'ordenes']))
                    <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">{{ trans('app.delete') }}</button>
                @elseif (isset($ordenp2) && $ordenp2->continue)
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

<script type="text/template" id="orden-producto-materialp-item-tpl">
    <td><%- !_.isUndefined(producto_nombre) && !_.isNull(producto_nombre) ? producto_nombre : "-" %></td>
    <td><%- orden4_medidas %></td>
    <td><%- orden4_cantidad %></td>
</script>

<script type="text/template" id="orden-producto-empaque-item-tpl">
    <td><%- !_.isUndefined(empaque_nombre) && !_.isNull(empaque_nombre) ? empaque_nombre : '-' %></td>
    <td><%- !_.isUndefined(producto_nombre) && !_.isNull(producto_nombre) ? producto_nombre : '-' %></td>
    <td><%- orden9_medidas %></td>
    <td><%- orden9_cantidad %></td>
</script>

<script type="text/template" id="orden-producto-areas-item-tpl">
    <td><%- areap_nombre ? areap_nombre : '-' %></td>
    <td><%- orden6_nombre ? orden6_nombre : '-' %></td>
    <td class="text-center"><%- orden6_horas %>:<%- orden6_minutos %></td>
</script>

<script type="text/template" id="orden-producto-transporte-item-tpl">
    <td><%- !_.isUndefined(transporte_nombre) && !_.isNull(transporte_nombre) ? transporte_nombre : '-' %></td>
    <td><%- !_.isUndefined(producto_nombre) && !_.isNull(producto_nombre) ? producto_nombre : '-' %></td>
    <td><%- orden10_medidas %></td>
    <td><%- orden10_cantidad %></td>
</script>

<script type="text/template" id="ordenp-tiempop-item-list-tpl">
    <td><%- tercero_nombre %></td>
    <td><%- tiempop_fecha %></td>
    <td><%- moment(tiempop_hora_inicio, 'HH:mm').format('HH:mm') %></td>
    <td><%- moment(tiempop_hora_fin, 'H:mm').format('H:mm') %></td>
    <td><%- actividadp_nombre %></td>
    <td><%- !_.isNull(subactividadp_nombre) ? subactividadp_nombre : ' - ' %></td>
    <td><%- areap_nombre %></td>
</script>
