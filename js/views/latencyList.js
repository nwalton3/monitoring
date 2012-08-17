// Filename: views/latencyList
define([
  'jquery',
  'underscore',
  'backbone',
  'text!templates/home/main.html'
], function($, _, Backbone, mainHomeTemplate){

  var latencyListView = Backbone.View.extend({
    el: $("#page"),
    render: function(){
      this.el.html(mainHomeTemplate);
    }
  });
  return new latencyListView;
});