<!-- Modal -->
<div class="modal fade" id="modal-address-component" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Generador de direcciones</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="form-group col-md-8">
						{!! Form::select('departamento_codigo', App\Models\Base\Municipio::getMunicipios(), null, ['id' => 'departamento_codigo', 'class' => 'form-control select2', 'width' => '100%']) !!}
					</div>
		        </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-primary">Continuar</button>
			</div>
		</div>
	</div>
</div>