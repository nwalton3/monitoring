// Filename: views/latencyList
define([
  'jquery',
  'underscore',
  'backbone',
  'text',
  'text!templates/services.mustache',
  'handlebars',
  'collections/titles'
], function($, _, Backbone, Text, Template, Handlebars, servicesCollection){

  var latencyListView = Backbone.View.extend({
    el: $("#page"),
    collection: servicesCollection,
    
    initialize: function(){
      servicesCollection.update();
      
      this.collection.model.bind('change', this.render, this);
    },
    
    /* Func: Render 
    */
    render: function() {
      var source = Template;
      var template = Handlebars.compile(source);
      var data = {pageTitle:'Load Times', services: this.collection.toJSON()};
      
      $(this.el).html(template(data));
    }
    
  });
  return new latencyListView;
});