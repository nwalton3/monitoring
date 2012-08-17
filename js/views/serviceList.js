// Filename: views/serviceList
define([
  'jquery',
  'underscore',
  'backbone',
  'handlebars',
  // Pull in the Service module from above
  'collections/services',
  'text!templates/projects/list.html'

], function($, _, Backbone, Handlebars, servicesCollection, projectListTemplate){
  var serviceListView = Backbone.View.extend({
    el: $("#page"),
    initialize: function(){
      this.collection = servicesCollection;
    },
    exampleBind: function( model ){
      //console.log(model);
    },
    render: function(){
      var data = {
        projects: this.collection.models,
        _: _
      };
      var compiledTemplate = _.template( projectListTemplate, data );
      $("#page").html( compiledTemplate );
    }
  });
  return new serviceListView;
});
