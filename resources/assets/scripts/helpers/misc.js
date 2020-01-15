/**
 * Utilities for seg component
 *
 *
 */
( function( $, window, document, undefined ){

    var Misc = function( a ){

        // attributes or global vars here

    }

    Misc.prototype = {

        /**
        * Inializes the functions when DOM ready
        */
        initialize: function(){

        },

        /**
         *  Serialize form into json format
         *
         *  @param { string } name class or id of the html element to embed the loader
         *  @return { object } form into json
         *
         */
        formToJson: function( selector ){
            var o = {}, a = [];
            if( $.prototype.isPrototypeOf(selector) ){
                a = selector.serializeArray();
            }
            else{
                a = $(selector).serializeArray();
            }

            $.each( a, function() {
                if ( o[ this.name ] !== undefined ) {
                    if ( ! o[this.name].push ) {
                        o[ this.name ] = [ o[ this.name ] ];
                    }

                    o[ this.name ].push( this.value || '' );

                } else {
                    o[ this.name ] = this.value || '';
                }
            });

            return o;
        },

        getColorsRGB: function(){
            var getStepColor = function (colorA, colorB, value) {
                return colorA.map(function (color, i) {
                    return (color + value * (colorB[i] - color)) & 255;
                });
            };

            var colorStops = [];
            var colors = [];

            var colorToRgb = {
                "red": [255, 0, 0, 0],
                "green": [0, 128, 0, 50],
                "blue": [0, 0, 255, 100]
            };

            _.each(colorToRgb, function( color ) {
                colorStops.push({
                    percentage: color[3],
                    color: [ color[0], color[1], color[2] ]
                });
            });

            for ( var i = 0; i < 30; i++ ) {
                var percentage = ( i / 30 ) * 100;

                var j;
                for (j = 0; j < colorStops.length; j++) {
                    if ( colorStops[j].percentage > percentage ) {
                        break;
                    };
                }

                var lowerIndex = j == 1 ? 0 : j - 1;
                var upperIndex = lowerIndex + 1;
                var value = i / (30 / (colorStops.length - 1) ) % 1;

                color = getStepColor( colorStops[lowerIndex].color , colorStops[upperIndex].color , value);
                colors.push( "rgb("+color[0]+","+color[1]+","+color[2]+")" );
            }

            return colors;
        },

        /**
         *  Validate formula format
         */
        validarMedida: function (medida) {
            var reg = /[0-9/\+/\-/\*/\/\/\./\(/\)]/,
                medida = medida,
                formula = 1;

            try {
                if (reg.test(medida)) {
                    formula = eval(medida);
                }
            } catch (e) {
                formula = 1;
            }

            return formula;
        },

        /**
        * validate the urls
        */
        isUrl : function( str ){
            // var patt = /^(http[s]?:\/\/(www\.)?|ftp:\/\/(www\.)?|www\.){1}([0-9A-Za-z-\.@:%_\+~#=]+)+\.[a-zA-Z]{2,3}(\/([^\n\r\s])*)?(\?([^\n\r\s])*)?/i;
            var patt = /^(http[s]?:\/\/(www\.)?|ftp:\/\/(www\.)?|www\.){1}([0-9A-Za-z-\.@:%_\+~#=]+)+(\/(.)*)?(\?(.)*)?/i;

            return patt.test( str );
        },

        /**
        * Build URI with route and base url
        */
        urlFull: function ( route ){

            if( !this.isUrl(document.url) )
                return route;

            route || (route = '');
            var patt = /^\//;
            patt.test(route) || (route = '/'+route);

            return document.url + route;
        },

        /**
        * Build URI with route and base url
        */
        parseErrors: function ( errors ){
            var text = '';
            if( _.isObject( errors ) ){

                var listError = '<ul>';

                $.each(errors, function(field, item) {
                     listError += '<li>'+ item[0] +'</li>';
                });
                listError += '</ul>';

                text = listError;
            }
            return text;
        },

        /**
        *  Sets a loading spinner in a box
        * @param { selector } String|Object Selector jQuery
        */
        setSpinner: function( selector ){
            if ( !selector ) return;

            $(selector).prepend('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
        },

        /**
        * Removes the loading spinner and trigger a callback
        * @param { wrap } String|Object wrapper jQuery element
        *
        */
        removeSpinner: function( selector ){

            var $selector = $(selector).find( '.overlay' );

            if($selector.length)
                $selector.remove();
        },

        /**
        *   ClearFields the forms
        */
        clearForm: function( form ){

            form.trigger('reset');

            form.find(':input').each(function(){
                field_type = $(this);

                // Inputmask data-currency
                if ( field_type.attr('data-currency') == '' || field_type.attr('data-currency-negative') == ''){
                    field_type.val('');
                }

                if( field_type.hasClass('timepicker') ){
                    field_type.val( moment().format('H:mm') );
                }

                // Checkbox && radiobutton
                if( field_type.attr('type') == 'radio' || field_type.attr('type') == 'checkbox'){
                    field_type.iCheck('update');
                }

                // Select2
                if( field_type.hasClass('select2-default-clear') || field_type.hasClass('select2-default') ){
                    var name = field_type.attr('id');
                    field_type.val('').trigger('change');
                    $('#select2-'+name+'-container').removeAttr('title');

                    // Select2 with ajax
                }else if( field_type.hasClass('choice-select-autocomplete') ){
                    field_type.empty();
                    id = field_type.attr('id');
                    $('#select2-'+id+'-container').removeAttr('title');
                }
            });
        },

        /**
        * Display the DataTables interface in Spanish
        */
        dataTableES: function(){
            return {
                "sProcessing":     "<div class=\"overlay\"><i class=\"fa fa-refresh fa-spin\"></i></div>",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        },

        /**
        * Redirect to an specific url or refresh the page
        * @param { string } the url to be redirect to
        *
        */
        redirect: function( url ){
            if( url !== undefined && url != ''){
                window.location = url;
            }else{
                window.location.reload();
            }
        },

        /**
        * Redirect to an specific url or refresh the page
        * @param { string } the url to be redirect to
        *
        */
        successRedirect: function( msg, url ){
            alertify.success(msg);
            setTimeout(function(){
                window.Misc.redirect( url );
            }, 500);
        },

        /**
        * Format COP currency
        * @param { value }
        *
        */
        currency: function( value ){
            return accounting.formatMoney(value, '', 2, ".", ",");
        },

        /**
        * Evaluate actions accounts
        */
        evaluateActionsAccount: function ( options ) {

            options || (options = {});

            var defaults = {
                'callback': null,
                'wrap': 'body',
                'data': null
            }, settings = {};

            settings = $.extend({}, defaults, options);

            // Search plancuenta
            $.ajax({
                url: window.Misc.urlFull(Route.route('asientos.detalle.evaluate')),
                type: 'POST',
                data: settings.data,
                beforeSend: function() {
                    window.Misc.setSpinner( settings.wrap );
                }
            })
            .done(function(resp) {
                window.Misc.removeSpinner( settings.wrap );

                // response success or error
                var text = resp.success ? '' : resp.errors;
                if( _.isObject( resp.errors ) ) {
                    text = window.Misc.parseErrors(resp.errors);
                }

                if( !resp.success ) {
                    alertify.error(text);
                    return;
                }

                // return callback
                if( ({}).toString.call(settings.callback).slice(8,-1) === 'Function' )
                    settings.callback( resp.actions );
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( settings.wrap );
                alertify.error(thrownError);
            });
        },
        /**
        * Evaluate actions accounts
        */
        evaluateActionsAccountNif: function ( options ) {

            options || (options = {});

            var defaults = {
                'callback': null,
                'wrap': 'body',
                'data': null
            }, settings = {};

            settings = $.extend({}, defaults, options);

            // Search plancuenta
            $.ajax({
                url: window.Misc.urlFull(Route.route('asientosnif.detalle.evaluate')),
                type: 'POST',
                data: settings.data,
                beforeSend: function() {
                    window.Misc.setSpinner( settings.wrap );
                }
            })
            .done(function(resp) {
                window.Misc.removeSpinner( settings.wrap );

                // response success or error
                var text = resp.success ? '' : resp.errors;
                if( _.isObject( resp.errors ) ) {
                    text = window.Misc.parseErrors(resp.errors);
                }

                if( !resp.success ) {
                    alertify.error(text);
                    return;
                }

                // return callback
                if( ({}).toString.call(settings.callback).slice(8,-1) === 'Function' )
                    settings.callback( resp.actions );
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( settings.wrap );
                alertify.error(thrownError);
            });
        },

        /**
        * Evaluate facturap
        */
        evaluateFacturap: function ( options ) {

            options || (options = {});

            var defaults = {
                'callback': null,
                'wrap': 'body',
                'facturap': null,
                'tercero': null,
                'naturaleza': null
            }, settings = {};
            settings = $.extend({}, defaults, options);

            // Search facturap
            $.ajax({
                url: window.Misc.urlFull(Route.route('facturap.search')),
                type: 'GET',
                data: { facturap1_factura: settings.facturap, tercero_nit: settings.tercero },
                beforeSend: function() {
                    window.Misc.setSpinner( settings.wrap );
                }
            })
            .done(function(resp) {
                window.Misc.removeSpinner( settings.wrap );
                var response = { actions: false };

                if(resp.success) {
                    // Evaluate actions
                    response.actions = true;
                    response.facturap = resp.id;
                    response.action = 'quota';

                }else{
                    if(settings.naturaleza == 'C') {
                        response.actions = true;
                        response.action = 'add';

                    }else if(settings.naturaleza == 'D') {
                        response.message = 'Para realizar movimientos de naturaleza débito de ingresar un numero de factura existente.';
                    }
                }

                // return callback
                if( ({}).toString.call(settings.callback).slice(8,-1) === 'Function' )
                    settings.callback( response );
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( settings.wrap );
                alertify.error(thrownError);
            });
        },

        /**
        *Evaluate action Inventory
        */
        evaluateActionsInventory: function(options){
            options || (options = {});
            var defaults = {
                'callback': null,
                'wrap': 'body',
                'data': null
            }, settings = {};

            settings = $.extend({}, defaults, options);
            $.ajax({
                url: window.Misc.urlFull(Route.route('productos.evaluate')),
                type: 'POST',
                data: settings.data,
                beforeSend: function() {
                    window.Misc.setSpinner( settings.wrap );
                }
            })
            .done(function(resp) {
                window.Misc.removeSpinner( settings.wrap );

                // response success or error
                var text = resp.success ? '' : resp.errors;
                if( _.isObject( resp.errors ) ) {
                    text = window.Misc.parseErrors(resp.errors);
                }

                if( !resp.success ) {
                    alertify.error(text);
                    return;
                }

                // return callback
                if( ({}).toString.call(settings.callback).slice(8,-1) === 'Function' )
                    settings.callback( resp.action, resp.tipo, resp.producto );
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( settings.wrap );
                alertify.error(thrownError);
            });
        },

        /**
        * Clone module
        */
        cloneModule: function ( options ) {

            options || (options = {});

            var defaults = {
                'callback': null,
                'wrap': 'body',
                'url': null
            }, settings = {};

            settings = $.extend({}, defaults, options);

            // Clone module
            $.ajax({
                url: settings.url,
                type: 'GET',
                beforeSend: function() {
                    window.Misc.setSpinner( settings.wrap );
                }
            })
            .done(function(resp) {
                window.Misc.removeSpinner( settings.wrap );

                // response success or error
                var text = resp.success ? '' : resp.errors;
                if( _.isObject( resp.errors ) ) {
                    text = window.Misc.parseErrors(resp.errors);
                }

                if( !resp.success ) {
                    alertify.error(text);
                    return;
                }

                // return callback
                if( ({}).toString.call(settings.callback).slice(8,-1) === 'Function' )
                    settings.callback( resp );
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                window.Misc.removeSpinner( settings.wrap );
                alertify.error(thrownError);
            });
        },

        stateProduction: function (value) {
            var response = {
                nombre: 'COTIZACIÓN',
                color: 'success'
            }

            switch (value) {
                case 'PC':
                    response.nombre = 'PRE-COTIZACIÓN';
                    response.color = 'warning';
                    break;
                case 'PF':
                    response.nombre = 'PRE-COTIZACIÓN TERMINADA';
                    response.color = 'warning';
                    break;
                case 'CC':
                    response.nombre = 'COTIZACIÓN';
                    break;
                case 'CF':
                    response.nombre = 'COTIZACIÓN TERMINADA';
                    break;
                case 'CS':
                    response.nombre = 'COTIZACIÓN ENVIADA';
                    break;
                case 'CN':
                    response.nombre = 'COTIZACIÓN (NO ACEPTADA)';
                    break;
                case 'CR':
                    response.nombre = 'COTIZACIÓN (RECOTIZAR)';
                    break;
                case 'CO':
                    response.nombre = 'COTIZACIÓN (AL ABRIR ORDEN)';
                    break;
            }

            return response;
        },

        previewState: function (value, method) {
            var states = ['PC', 'PF', 'CC', 'CF', 'CS'],
                preview = '';

            if (method == 'prev') {
                preview = states[states.indexOf(value)-1];
            } else {
                preview = states[states.indexOf(value)+1];
            }
            
            return _.isUndefined(preview) ? value : preview;
        }
    };

    window.Misc = new Misc();
    window.Misc.initialize();

})( jQuery, this, this.document );
