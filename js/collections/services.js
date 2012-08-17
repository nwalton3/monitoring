define([
  'jquery',
  'underscore',
  'backbone',
  'models/service'
], function($, _, Backbone, serviceModel){
  var servicesCollection = Backbone.Collection.extend({
    model: serviceModel,
    url: 'objects.php',
    initialize: function(){
      servicesCollection.fetch();
    }

  });

  return new servicesCollection;
});
