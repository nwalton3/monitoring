define([
  'jquery',
  'underscore',
  'backbone',
  'models/service'
], function($, _, Backbone, serviceModel){
  var servicesCollection = Backbone.Collection.extend({
    model: serviceModel,
    initialize: function(){
      
    }

  });

  return new servicesCollection;
});
