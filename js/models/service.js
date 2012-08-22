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
      url: 'objects.php'
    },
  
    initialize: function(){
      this.attributes.url = this.attributes.url + '?s=' + this.attributes.title;
  
      this.bind("change", function(){
        // Update the views
        log(this);
      });
    },
    
    
    /* Func: checkStatus
     * Desc: Send an ajax request to see if the service is running properly
     */
    checkStatus: function() {
      //log('Checking status: ' + this.attributes.title);
      
      var startTime = new Date().getTime();
      var endTime = null;
      
      this.attributes.status = "checking";
      
      this.fetch({
        success: function(model, response){
          endTime = new Date().getTime();
          model.time = endTime - startTime;
          log(model.attributes.title + ' load time: ' + model.time + 'ms');
        },
        error: function(model, response){
          //log('error: ' + model.title);
        }
      });
    }
    
  });

  // You usually don't return a model instantiated
  return serviceModel;
});