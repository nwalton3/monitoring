// Filename: models/service
define([
  'underscore',
  'backbone'
], function( _, Backbone ){

  var serviceModel = Backbone.Model.extend({
    defaults: {
      reloadID: '',
      title: '',
      requestUrl: '',
      status: '',
      desc: '',
      time: 0,
      server: 0,
      url: 'objects.php'
    },
  
    initialize: function(){
      var newID;
    
      if(this.get("url") === 'objects.php') {
        // Add query string to the end of the url
        var newUrl  = this.get("url") + '?s=' + this.get("title") + "&srv=" + this.get("server");
        this.set({url: newUrl});
      }
      
      newID = "reload-" + this.cid;
      this.set({reloadID: newID});
    },
    
    
        
    /* Func: checkStatus
     * Desc: Send an ajax request to see if the service is running properly
     */
    checkStatus: function() {      
      var startTime, endTime, elapsed;
      
      startTime = new Date().getTime();
      this.set({status: "requesting", time: null});
      
      this.fetch({
        url:this.get('url'),
        async: true,
        success: function(model, response){
          endTime = new Date().getTime();
          elapsed = endTime - startTime;
          model.set({time: elapsed});
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