/**
* Class FolderModel extend of Backbone Model
* @author KOI || @dropecamargo
* @link http://koi-ti.com
*/

app || (app = {});

(function (window, document, undefined){

    app.FolderModel = Backbone.Model.extend({

        urlRoot: function () {
            return window.Misc.urlFull(Route.route('folders.index')); 
        },
        idAttribute: 'id',
        defaults: {
            'folder_codigo': '',
            'folder_nombre': ''
        }
    });

}) (this, this.document);
