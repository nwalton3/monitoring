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
      time: undefined,
    },

    url: 'object.php',
  
    initialize: function(){
      log('New service: ' + this.title);
  
      this.bind("change", function(){
        // Update the views
      });
    },
    
    
    /* Func: checkStatus
     * Desc: Send an ajax request to see if the service is running properly
     */
    checkStatus: function() {
      var serviceUrl = this.url + '?s=' + this.title;
      var startTime = new Date().getTime();
      var endTime = null;
      
      // The ajax request
      var request = $.ajax({
        url: serviceUrl,
        cache: false
      });
      
      // Success
      request.done(function(msg){
        endTime = new Date().getTime();
        var elapsedTime = endTime - startTime;
        
        log(msg);
        this.update('success', elapsedTime);
      });
      
      // Fail
      request.fail(function(msg){
        
        this.update('requestFail', elapsedTime);
      });
    },
    
    
    /* Func: update
     * Desc: Update the status in the model
     */
     update: function(newStatus, elapsedTime) {
        this.set({ status: newStatus });
        this.set({ time: elapsedTime });
    }
    
  });

  // You usually don't return a model instantiated
  return serviceModel;
});