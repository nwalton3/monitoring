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
      
      // Hide popovers when most things are clicked
      $('table').on('click', 'td', function(){
        var td = $(this);
        var title = td.hasClass('title');
        
        if (!title){
          $('[rel=popover]').popover('hide').removeClass('open');
        }
      });
      
      // Popover functionality
      $('[rel="popover"]').popover().on('click', function(e){
        e.preventDefault();
        $('[rel=popover]').not(this).popover('hide');
        
        var link = $(this);
        var open = link.hasClass('open');
       
        if(!open) {
          $('[rel=popover]').removeClass('open');
          link.addClass('open').popover('show');
        } else {
          link.popover('hide').removeClass('open');
        }
      });
    }
    
  });
  return new LatencyListView;
});