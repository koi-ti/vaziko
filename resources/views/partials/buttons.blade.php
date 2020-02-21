@if ($type == 'exportar')
    @ability ('exportar' | $module)
        <div class="box-footer">
            <div class="col-md-2 col-md-offset-4 col-sm-6 col-xs-6">
                <button type="submit" class="btn btn-default btn-sm btn-block btn-export-xls-koi-component">
                    <i class="fa fa-file-text-o"></i> {{ trans('app.xls') }}
                </button>
            </div>
            <div class="col-md-2 col-sm-6 col-xs-6">
                <button type="submit" class="btn btn-default btn-sm btn-block btn-export-pdf-koi-component">
                    <i class="fa fa-file-pdf-o"></i> {{ trans('app.pdf') }}
                </button>
            </div>
        </div>
    @endability
@elseif ($type == 'buscadores')

@endif
