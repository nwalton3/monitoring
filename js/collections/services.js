define([
  'jquery',
  'underscore',
  'backbone',
  'models/service'
], function($, _, Backbone, serviceModel){
  var servicesCollection = Backbone.Collection.extend({
    model: serviceModel,
    url: 'objects.php?s=all',
    
    initialize: function(){
      //this.update();
    },
    
    update: function() {
      this.fetch({
        //async: false,
        success: function(collection, response) {
          console.log('Services Updated');
        },
        error: function(collection, response) {
          console.log('Error updating services collection');
        }
      });
    }

  });

  return new servicesCollection;
});
