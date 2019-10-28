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

		folderChanged: function (e) {
            e.preventDefault();

            // Reference selecte
            var selected = this.$(e.currentTarget).val(),
                _this = this;

            // Reference wrappers contenxt
            this.$wraperConten = this.$( $(e.currentTarget).attr("data-wrapper") );
            this.$inputDocument = this.$("#" + $(e.currentTarget).attr("data-documents"));

            // Clear items
			this.$inputDocument.find("option:gt(0)").remove();

            // If exists value in selected
            if (selected) {
                window.Misc.setSpinner(this.$wraperConten);
                $.get(window.Misc.urlFull(Route.route('documentos.filter', {folder: selected})), function (resp) {
                    window.Misc.removeSpinner(_this.$wraperConten);
                    if (resp.success) {
                        if (resp.documents.length) {
                            _this.$inputDocument.prop('disabled', false);
                            $.each(resp.documents, function(index, doc) {
                        		_this.$inputDocument.append($("<option></option>").attr("value", doc.id).text(doc.documento_nombre));
                        	});
                        	_this.$inputDocument.change();
                        } else {
                            _this.$inputDocument.prop('disabled', true);
                        }
                    }
                });
            }
		}
    });

})(jQuery, this, this.document);
