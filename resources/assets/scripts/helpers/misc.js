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

            form.find(':input').each(function(){
                field_type = $(this);

                // Inputmask data-currency
                if ( field_type.attr('data-currency') == '' || field_type.attr('data-currency-negative') == ''){
                    field_type.val('');
                }

                // Checkbox && radiobutton
                if( field_type.attr('checked') ){
                    field_type.iCheck('check');
                }else{
                    field_type.iCheck('uncheck');
                }

                // Select2
                if( field_type.hasClass('select2-default-clear') || field_type.hasClass('select2-default') ){
                    field_type.select2('destroy').val('').select2();

                    // Select2 with ajax
                }else if( field_type.hasClass('choice-select-autocomplete') ){
                    field_type.empty();
                    id = field_type.attr('id');
                    $('#select2-'+id+'-container').removeAttr('title');
                }

            });
            form.trigger('reset');
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
        * Evaluate actions accounts
        */
        cloneOrden: function ( options ) {

            options || (options = {});

            var defaults = {
                'callback': null,
                'wrap': 'body',
                'data': null
            }, settings = {};

            settings = $.extend({}, defaults, options);

            // Clone orden
            $.ajax({
                url: window.Misc.urlFull( Route.route('ordenes.clonar', { ordenes: settings.data.orden_codigo }) ),
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
    };

    window.Misc = new Misc();
    window.Misc.initialize();

})( jQuery, this, this.document );
