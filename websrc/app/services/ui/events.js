/**
 * Bootstrap class
 * @param {object} namespace
 * @param {object} app
 * @param {window} globals
 * @returns {object}
 */
(function(namespace, app, globals) {

    app.registerService(function() {
        namespace.events = new namespace.events();
    });


    namespace.events = function() {
        this.runElementResizeEvent();
        this.runScrollEvent();
        this.onInsertEvent();
        this.onEscEvent();
    };

    namespace.events.prototype.runElementResizeEvent = function() {
        var self = this;
        app.utils.requestAnimFrame(function(){
            $(".event-resize").each(function(){
                var $this = $(this);
                var oldSizes = $this.data("__events_sizes");
                var currentSizes = {
                    width : $this.width(),
                    height : $this.height()
                };
                if(!(!oldSizes || !(oldSizes.width == currentSizes.width && oldSizes.height == currentSizes.height))){
                    return;
                }
                
                var data = {};
                $this.data("__events_sizes", currentSizes);
                $this.trigger("resize");
                $this.trigger("event-resize", data);
                return;
            });
            self.runElementResizeEvent();
        });
    };
    
    
    namespace.events.prototype.runScrollEvent = function() {
        var self = this;
        $(window).on("scroll", function(){
            $(".event-scroll").each(function(){
                var $this = $(this);
                $this.trigger("event-scroll");
                return;
            });
        });
        
        $(window).on("beforeunload", function() {
            $("body").addClass("unload");
            $(".event-unload").each(function(){
                var $this = $(this);
                $this.trigger("event-unload");
                return;
            });
        });
        
    };

    namespace.events.prototype.onEscEvent = function() {
        $(window).bind('keydown', 'esc', function(){
            $(".event-esc").trigger("event-esc");
        });

    };
    
    namespace.events.prototype.onInsertEvent = function() {
        var observerObject = new MutationObserver(function (mutationRecordsList) {
            mutationRecordsList.forEach(function (item) {
                var $addedNodes = $(item.addedNodes);
                $addedNodes.find(".event-insert").add($addedNodes.filter(".event-insert")).trigger("event-insert");
                
                $addedNodes.find("[controller]").add($addedNodes.filter("[controller]")).each(function(){
                    var controller = $(this).ecik().controller();
                    if(!controller){
                        return;
                    }
                    controller.trigger("onInsert");
                });
                
            });
        });
        observerObject.observe(globals.document, {
            childList: true,
            subtree: true
        });
    };




    return namespace.events;
})(__ARGUMENT_LIST__);