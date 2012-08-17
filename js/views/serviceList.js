// Filename: views/servicesList
define([
  'jquery',
  'underscore',
  'backbone',
  'text',
  'text!templates/services.mustache',
  'handlebars',
  'collections/services'
], function($, _, Backbone, Text, Template, Handlebars, servicesCollection){

  var latencyListView = Backbone.View.extend({
    el: $("#page"),
    collection: servicesCollection,
    
    initialize: function(){
      servicesCollection.update();
    },
    
    /* Func: Render 
    */
    render: function() {
      var source = Template;
      var template = Handlebars.compile(source);
      var data = {pageTitle:'Status', services: servicesCollection.toJSON()};
      
      $(this.el).html(template(data));
    }
    
  });
  return new latencyListView;
});