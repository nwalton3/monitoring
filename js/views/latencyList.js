// Filename: views/latencyList
define([
  'jquery',
  'underscore',
  'backbone',
  'text',
  'text!templates/latency.mustache',
  'handlebars',
  'collections/titles'
], function($, _, Backbone, Text, Template, Handlebars, servicesCollection){

  var LatencyListView = Backbone.View.extend({
    el: $("#page"),
    collection: servicesCollection,
    
    initialize: function(options){
      //_(this).bindAll('change', 'add', 'remove');
      this.collection.bind('change', this.render, this);
      servicesCollection.update();
    },
    
    events: {
      "click .refresh": "updateItem",
      "click #btn-reload-times": "updateAll"
    },

    updateItem: function(e) {
      var target, match;
      
      target = $(e.currentTarget).attr("id");
      //log(target);
      //log(this.collection.models);
      match = _.find(this.collection.models, function(model){
          return target == model.attributes.reloadID;
        });
      match.checkStatus();
    },
    
    updateAll: function(e) {
      _.each(this.collection.models, function(model){
          model.checkStatus();
        });
    },

    render: function() {
      var source = Template;
      var template = Handlebars.compile(source);
      
      _.each(this.collection.models, function(model){
        var status = model.get("status");
        if(status == 0) {
          status = "error";
        } else if (status == 1) {
          status = "success";
        }
        model.set({"status": status});
      });
      
      var data = {pageTitle:'Load Times', services: this.collection.toJSON()};
      
      $(this.el).html(template(data));
    }
    
  });
  return new LatencyListView;
});