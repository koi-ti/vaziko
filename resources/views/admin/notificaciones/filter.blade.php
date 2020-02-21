<ul class="list-group">
    @foreach ($notificaciones as $notificacion)
        <li class="list-group-item {{ $notificacion->notificacion_visto ? 'active' : 'view-true' }}" data-notification="{{ $notificacion->id }}">
            <h4>{{ $notificacion->notificacion_titulo }} <small class="pull-right {{ $notificacion->notificacion_visto ? 'text white' : ''}}"><i class="fa fa-clock-o"></i> {{ $notificacion->notificacion_fh }}</small></h4>
            <p>{{ $notificacion->notificacion_descripcion }} <span class="pull-right">{!! $notificacion->notificacion_visto ? '<i class="fa fa-check"></i><i class="fa fa-check"></i>' : '' !!}</span></p>
        </li>
    @endforeach
    <div class="pull-right">{!! $notificaciones->render() !!}</div>
</ul>
