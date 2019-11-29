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
