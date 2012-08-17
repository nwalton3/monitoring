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
      //this.update();
    },
    
    update: function() {
      this.fetch({
        async: false,
        success: function(collection, response) {
          //log(collection.length);
        },
        error: function(collection, response) {
          log('Error');
          log(response);
        }
      });
    }

  });

  return new servicesCollection;
});
