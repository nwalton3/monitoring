define([
  'jquery',
  'underscore',
  'backbone',
  'models/service'
], function($, _, Backbone, serviceModel){
  var titlesCollection = Backbone.Collection.extend({
    model: serviceModel,
    url: 'objects.php?s=titles',
    
    initialize: function(){
      //this.update();
    },
    
    update: function() {
      this.fetch({
        async: false,
        success: function(collection, response) {          
          collection.checkStatus();
        },
        error: function(collection, response) {
          collection.throwError();
        }
      });        
    },
    
    checkStatus: function() {
      _.each(this.models, function(model){
        model.checkStatus();
      });
    },
    
    throwError: function() {
      log('titlesCollection update error');
    }

  });

  return new titlesCollection;
});
