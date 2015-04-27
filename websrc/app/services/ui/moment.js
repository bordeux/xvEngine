/**
 * Bootstrap class
 * @param {object} namespace
 * @param {object} app
 * @param {window} globals
 * @returns {object}
 */
(function (namespace, app, globals) {



    app.registerService(function () {
        namespace.moment = new namespace.moment();
    });


    namespace.moment = function () {
        this.init();
    };

    namespace.moment.prototype.init = function () {
        var self = this;
        this.intercal = globals.setInterval(function(){
            self.refresh();
        }, 1000);
        this.bindEvents();
    };

    namespace.moment.prototype.refresh = function () {
        var self = this;
        $("moment, time").each(function(){
            self.refreshItem($(this));
        });
    };

    namespace.moment.prototype.refreshItem = function ($element) {
        var momentDate = $element.data("date");
        if(!momentDate){
            var orgDate = $element.text();
            $element.attr("datetime" , orgDate);
            momentDate = globals.moment(orgDate);
            $element.data("date", momentDate);

            $element.attr("title", momentDate.format('YYYY-MM-DD HH:mm:ss'));
            $element.addClass("loaded");
        }
        
        $element.text(momentDate.fromNow());
    };

 
    namespace.moment.prototype.bindEvents = function () {
        
        var self = this;
        var observerObject = new MutationObserver(function (mutationRecordsList) {
            mutationRecordsList.forEach(function (item) {
                $(item.addedNodes).find("moment, time").each(function(){
                    self.refreshItem($(this));
                });
            });
        });
        
        observerObject.observe(globals.document, {
            childList: true,
            subtree: true,
            attributes : false
        });
    };
    

    return namespace.moment;
})(__ARGUMENT_LIST__);