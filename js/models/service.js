// Filename: models/service
define([
  'underscore',
  'backbone',
], function( _, Backbone ){

  var serviceModel = Backbone.Model.extend({
    defaults: {
      title: '',
      requestUrl: '',
      status: '',
      time: 0,
    },

    url: 'objects.php',
  
    initialize: function(){
      this.url = this.url + '?s=' + this.title;
  
      this.bind("change", function(){
        // Update the views
      });
    },
    
    
    /* Func: checkStatus
     * Desc: Send an ajax request to see if the service is running properly
     */
    checkStatus: function() {
      
      var startTime = new Date().getTime();
      var endTime = null;
      
      this.status = "checking";
      
      this.fetch({
        success: function(model, response){
          this.update();
          endTime = new Date().getTime();
          this.time = endTime - startTime;
        },
        error: function(model, response){
          log('error: ' + this.title);
        }
      });
    }
    
  });

  // You usually don't return a model instantiated
  return serviceModel;
});