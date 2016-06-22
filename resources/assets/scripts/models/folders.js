/**
* Class DocumentoModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

app || (app = {});

(function (window, document, undefined){
    
    app.FoldersModel = Backbone.Model.extend({
        
        urlRoot: function () {
            return window.Misc.urlFull (Route.route('folders.index') ); 
        },
        idAttribute: 'id',
        defaults: {
            
        }
    });
    
}) (this, this.document);