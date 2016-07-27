/**
* Class ComponentReportView  of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentReportView = Backbone.View.extend({

      	el: 'body',
		events: {
			'click .btn-export-pdf-koi-component': 'onPdf',
			'click .btn-export-xls-koi-component': 'onXls',
		},

        /**
        * Constructor Method
        */
		initialize: function() {
			// Initialize
		},

		onPdf: function(e) {

            console.log( e );
		},

		onXls: function(e) {

            console.log( e );
		}
    });


})(jQuery, this, this.document);
