// Filename: router.js
define([
  'jquery',
  'underscore',
  'backbone',
  'plugins',
  'views/latencyList',
  'views/serviceList'
], function($, _, Backbone, Plugins, latencyListView, serviceListView ){
  var AppRouter = Backbone.Router.extend({
    routes: {
      // Define some URL routes
      'status': 'showStatus',

      // Default
      '*actions': 'defaultAction'
    },
    showStatus: function(){
      // Call render on the module we loaded in via the dependency array
      // 'views/projects/list'
      serviceListView.render();
    },
      // As above, call render on our loaded module
      // 'views/users/list'
    defaultAction: function(actions){
      // We have no matching route, lets display the home page
      latencyListView.render();
    }
  });

  var initialize = function(){
    var app_router = new AppRouter;
    Backbone.history.start();
  };
  return {
    initialize: initialize
  };
});
