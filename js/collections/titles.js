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
      
    },
    
    update: function() {
      this.fetch({
        async: false,
        success: function(collection, response) {          
          collection.getLoadTimes();
        },
        error: function(collection, response) {
          collection.throwError();
        }
      });        
    },
    
    getLoadTimes: function() {
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
