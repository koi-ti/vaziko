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
			'click .btn-export-chart-koi-component': 'onChart',
			'click .btn-export-xls-koi-component': 'onXls',
		},

		onPdf: function (e) {
			this.$("#type-report-koi-component").val('pdf');
		},

		onChart: function (e) {
			this.$("#type-report-koi-component").val('chart');
		},

		onXls: function (e) {
			this.$("#type-report-koi-component").val('xls');
		},
    });
})(jQuery, this, this.document);
