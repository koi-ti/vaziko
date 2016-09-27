/**
* Class ShowTerceroView
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ShowTerceroView = Backbone.View.extend({

        el: '#terceros-main',

        /**
        * Constructor Method
        */
        initialize : function() {
            // Model exist
            if( this.model.id != undefined ) {

                this.contactsList = new app.ContactsList();
                this.facturaptList = new app.FacturaptList();

                // Reference views
                this.referenceViews();
            }
        },

        /**
        * reference to views
        */
        referenceViews: function () {
            // Contact list
            this.contactsListView = new app.ContactsListView( {
                collection: this.contactsList,
                parameters: {
                    dataFilter: {
                        'tercero_id': this.model.get('id')
                    }
               }
            });

            // Facturap list
            this.facturaptListView = new app.FacturaptListView( {
                collection: this.facturaptList,
                parameters: {
                    dataFilter: {
                        'tercero_id': this.model.get('id')
                    }
               }
            });
        }
    });

})(jQuery, this, this.document);
