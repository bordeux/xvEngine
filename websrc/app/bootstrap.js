/**
 * Bootstrap class
 * @param {object} namespace
 * @param {object} app
 * @param {window} globals
 * @returns {object}
 */
(function (namespace, app, globals) {

    namespace.bootstrap = function (config) {
        this.config = config;
        app.services.bootstrap = this;
    };

    namespace.bootstrap.prototype.config = {};

    namespace.bootstrap.prototype.init = function () {
        this.initApplicationDomStructure();
        this.initServices();
        this.bindEvents();
        this.loadView();
    };


    /**
     * 
     * @param {type} nodeList
     * 
     */
    namespace.bootstrap.prototype.destroyComponents = function (nodeList) {
        var $nodes = $(nodeList);
        var $collection = $nodes.find("[component]");

        $collection.add($nodes).each(function () {
            var componentInstance = $(this).get(0).component;
            if (!componentInstance) {
                return true;
            }
            componentInstance.trigger("onDestroy");
            if (!componentInstance.destroy) {
                return true;
            }
  
            componentInstance.destroy(this);
        });
    };

    /**
     * 
     * @returns {undefined}
     */
    namespace.bootstrap.prototype.bindEvents = function () {
        var self = this;
        var observerObject = new MutationObserver(function (mutationRecordsList) {
            mutationRecordsList.forEach(function (item) {
                self.destroyComponents(item.removedNodes);
            });
        });
        observerObject.observe(globals.document, {
            childList: true,
            subtree: true
        });


    };
    /**
     * 
     * @returns {undefined}
     */
    namespace.bootstrap.prototype.initServices = function () {
        app.servicesInitList.sort(function(a, b){return a.priority-b.priority;}); //sort by priority
        app.servicesInitList.forEach(function(serviceClass){
            serviceClass.init();
        });
    };
    
    /**
     * 
     * @returns {undefined}
     */
    namespace.bootstrap.prototype.initApplicationDomStructure = function () {
        
        var structure = app.utils.getString(function() {
            /**<string>
                <application>
                        <services>
                                <loading></loading>
                        </services>
                </application>
             </string>*/
        });
        
        $("body").html(structure);
    };
    

    /**
     * 
     * @returns {undefined}
     */
    namespace.bootstrap.prototype.loadView = function () {
        var request = app.services.request.create(globals.location.href);
        request.addHeader("X-XV-First-Request", 1);
        request.addHeader("X-XV-Source", "bootstrap");
        return request.run();
    };
    


    return namespace.bootstrap;
})(__ARGUMENT_LIST__);