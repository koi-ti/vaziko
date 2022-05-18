@extends('layout.layout')

@section('title') Pre-cotizaciones @stop

@section('content')
    @yield ('module')

    <script type="text/template" id="qq-template-precotizacion-producto">
        <div class="qq-uploader-selector qq-uploader" qq-drop-area-text="{{ trans('app.files.drop') }}">
            <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
                <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
            </div>
            <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
                <span class="qq-upload-drop-area-text-selector"></span>
            </div>
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
                    <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
                </li>
            </ul>
        </div>
    </script>
@stop
