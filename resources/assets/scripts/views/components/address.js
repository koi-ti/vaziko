/**
* Class ComponentAddressView  of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentAddressView = Backbone.View.extend({

      	el: 'body',
        template: _.template( ($('#koi-address-component-tpl').html() || '') ),
        templateSelect: _.template( ($('#koi-component-select-tpl').html() || '') ),
		events: {
        	'focus input.address-koi-component': 'addressChanged',
            'click .btn-address-koi-component': 'focusComponent',
            'submit #form-address-component': 'addAddress',
            'change #component-select': 'ChangeSelect',
            'click .koi-component-remove-last': 'removeLastItem',
            'click .koi-component-remove': 'removeItem',
            'click .koi-component-add': 'listeningAddress'
        },

        /**
        * Constructor Method
        */
        initialize: function() {
            // Initialize
            this.$modalComponent = this.$('#modal-address-component');
            this.$modalComponentValidacion = this.$('#modal-address-component-validacion');
        },

        focusComponent: function(e) {
            $("#"+$(e.currentTarget).attr("data-field")).focus();
        },

        addressChanged: function(e) {
            this.inputContent = $(e.currentTarget);
            this.inputContentNm = this.$("#"+this.inputContent.attr("data-nm-name"));
            this.inputContentNmValue = this.$("#"+this.inputContent.attr("data-nm-value"));

            this.$modalComponent.find('.content-modal').html( this.template({ }) );

            // References
            this.$addressField = this.$modalComponent.find('#koi_direccion');
            this.$addressNomenclaturaField = this.$modalComponent.find('#koi_direccion_nm');
            this.$formComponent = this.$modalComponent.find('#form-address-component');

            // Initialize
            this.addressData = new Array();
            this.addressDataNm = new Array();
            this.num = new Array();

            // Validate nomenclaturas
            this.validaciones = ['Agencia','Agrupación','Almacen','Autopista','Avenida','Avenida Carrera','Barrio','Boulevar','Calle','Camino','Carrera','Carretera','Casa','Celula','Centro Comercial','Ciudadela','Conjunto','Conjunto Residencial','Corregimiento','Departamento','Deposito','Edificio','Entrada','Etapa','Finca','Hacienda','Lote','Modulo','Municipio','Parcela','Parque','Parqueadero','Pasaje','Paseo','Predio','Puente','Puesto','Salón','Salón Comunal','Sector','Suite','Terminal','Terraza','Torre','Unidad','Unidad Residencial','Urbanización','Variante','Vereda','Zona','Zona Franca'];

            // to fire plugins
            if( typeof window.initComponent.initToUpper == 'function' )
                window.initComponent.initToUpper();

            if( typeof window.initComponent.initAlertify == 'function' )
                window.initComponent.initAlertify();

            this.$formComponent.validator();

            // Modal show
            this.$modalComponent.modal('show');
        },

        addAddress: function(e) {
            var _this = this;
            if (!e.isDefaultPrevented()) {
                e.preventDefault();

                this.inputContent.val( this.$addressField.val() );
                this.inputContentNm.text( this.$addressNomenclaturaField.val() );
                this.inputContentNmValue.val( this.$addressNomenclaturaField.val() );
                this.$modalComponent.modal('hide');
                if( $('.modal.in').length > 0){
                    setTimeout( function () { _this.$el.addClass('modal-open') }, 500);
                }
            }
        },

        listeningAddress: function(e){  
            if( parseInt($(e.target).text().trim()) > 0 || parseInt($(e.target).text().trim()) < 9 ){
                this.num = $(e.target).text().trim();
                if( parseInt(this.addressData[this.addressData.length-1]) > 0 || parseInt(this.addressData[this.addressData.length-1]) < 9){
                    this.addressData[this.addressData.length-1] += this.num;
                    this.addressDataNm[this.addressDataNm.length-1] += this.num;
                }else{
                    this.addressData.push( this.num );
                    this.addressDataNm.push( this.num );
                }
            }else{
                this.num = [];
                if( this.addressData[this.addressData.length-1] != $(e.target).text().trim() ){
                    for (var i = 0; i < this.validaciones.length; i++) {
                        if($(e.target).text().trim() == this.validaciones[i]){
                            this.$modalComponentValidacion.find('.modal-content').html( this.templateSelect( { } ));
                            this.$modalComponentValidacion.find('.modal-title').text( $(e.target).text().trim() );
                            this.$modalComponentValidacion.modal('show');
                        }
                    }
                    
                    if($(e.target).text().trim() == '#' || $(e.target).text().trim() == '-'){
                        this.addressData.push( $(e.target).text().trim() );
                        this.addressDataNm.push( ' ' );
                    }else{
                        this.addressData.push( $(e.target).text().trim() );
                        this.addressDataNm.push( $(e.target).attr('data-key') );
                    }
                }else{
                    alertify.error('No puede seleccionar dos nomenclaturas iguales ni más de dos letras seguidas');
                }
            }
            this.buildAddress();
        },

        ChangeSelect: function(e){
            var _this = this;
            this.$component = this.$('#component-input').hide();
            var valor = '';

            if($(e.target).val() == 'si'){
                _this.$component.show();
                $('input#component-input-text').change(function(){
                    var dato = $(this).val( $(this).val().toUpperCase() );
                    var reg = /[^A-Za-z0-9&]/i;
                    for(var i=0; i <= dato.val().length-1; i++){
                        if( !reg.test(dato.val().charAt(i)) ){
                            dato.val().replace(reg,'');
                            valor += dato.val().charAt(i);
                        }
                    }

                    _this.addressData.push( valor );
                    _this.addressDataNm.push( valor );
                    _this.buildAddress();
                    _this.$modalComponentValidacion.modal('hide');

                    setTimeout(function() { _this.$el.addClass('modal-open'); }, 500);
                });
            }else if($(e.target).val() == 'no'){
                _this.$modalComponentValidacion.modal('hide');
            }else{
                return false;
            }

            if( _this.$modalComponent.length > 0 ){
                setTimeout(function() { _this.$el.addClass('modal-open'); }, 500);
            }
        },

        /**
        * remove last item
        */
        removeLastItem: function(e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                this.addressData.pop();
                this.addressDataNm.pop();
                this.buildAddress();
            }
        },

        /**
        * remove item
        */
        removeItem: function(e) {
            if (!e.isDefaultPrevented()) {
                e.preventDefault();
                this.addressData.length = 0;
                this.addressDataNm.length = 0;
                this.num.length = 0;
                this.buildAddress();
            }
        },

     	/**
        * Built address
        */
		buildAddress: function() {
            var addreess = $.grep(this.addressData, Boolean).join(' ').trim();
            this.$addressField.val( addreess );

            var addreessNm = $.grep(this.addressDataNm, Boolean).join(' ').trim();
            this.$addressNomenclaturaField.val( addreessNm );
		}
    });
})(jQuery, this, this.document);