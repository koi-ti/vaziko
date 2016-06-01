/**
* Class ComponentDocumentView  of Backbone
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ComponentDocumentView = Backbone.View.extend({
        
      	el: 'body',
		events: {
            'change .select-filter-document-koi-component': 'folderChanged'
		},

        /**
        * Constructor Method
        */
		initialize: function() {
			// Initialize
		},

		folderChanged: function(e) {
			var _this = this;
			
			this.$inputContent = $(e.currentTarget);
			this.$wraperConten = this.$("#"+$(e.currentTarget).attr("data-wrapper"));
			this.$inputDocument = this.$("#"+$(e.currentTarget).attr("data-documents"));

			var folder = this.$inputContent.val();
			
			// Clear items
			this.$inputDocument.find("option:gt(0)").remove();

			if(!_.isUndefined(folder) && !_.isNull(folder) && folder != '') {
				// Get documentos
	            $.ajax({
	                url: window.Misc.urlFull(Route.route('documentos.filter')),
	                type: 'GET',
	                data: { folder: folder },
	                beforeSend: function() {
	                    window.Misc.setSpinner( _this.$wraperConten );
	                }
	            })
	            .done(function(resp) {  
	                window.Misc.removeSpinner( _this.$wraperConten );
	                if(resp.success) {
	                	if( _.isObject( resp.documents ) ) {
							$.each(resp.documents, function(index, doc) {   
								_this.$inputDocument.append($("<option></option>").attr("value",doc.id).text(doc.documento_nombre)); 
							});
							_this.$inputDocument.change();
		                }
	                }
	            })
	            .fail(function(jqXHR, ajaxOptions, thrownError) {
	                window.Misc.removeSpinner( _this.$wraperConten );
	                alertify.error(thrownError);
	            });
	     	}
		}
    });


})(jQuery, this, this.document);
