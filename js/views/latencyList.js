// Filename: views/latencyList
define([
  'jquery',
  'underscore',
  'backbone',
  'handlebars',
  'text!templates/latency.mustache'
], function($, _, Backbone, latencyTemplate){

  var latencyListView = Backbone.View.extend({
    el: $("#page"),
    render: function(){
      //this.el.html(mainHomeTemplate);
      
      //var js = this.collection.toJSON();
      var template = Handlebars.compile(latencyTemplate);
      $(this.el).html(template());
      return this;
    }
  });
  return new latencyListView;
});