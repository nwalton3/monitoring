// Filename: views/latencyList
define([
  'jquery',
  'underscore',
  'backbone',
  'text',
  'text!templates/services.mustache',
  'handlebars'
], function($, _, Backbone, Text, Template, Handlebars){

  var latencyListView = Backbone.View.extend({
    el: $("#page"),
    
    initialize: function(){

    },
    
    /* Func: Render 
    */
    render: function() {
      var source = Template;
      var template = Handlebars.compile(source);
      var data = { pageTitle: 'Load Times',
        services: [
        {title: "CAS", status:"success", url:"http://cas.byu.edu"},
        {title: "Person", status:"fail", url:"http://personservice.byu.edu"}, 
        {title:"AIM", status:"success", url:"http://aim.byu.edu"}
      ]};
      $(this.el).html(template(data));
    }
    
  });
  return new latencyListView;
});