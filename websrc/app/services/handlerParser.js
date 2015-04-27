(function(namespace, app, globals) {


    app.registerService(function () {
        namespace.handlerParser = new namespace.handlerParser();
    }, -1000);


    namespace.handlerParser = app.newClass();


    /**
     * Constructor
     * @param handlers
     * @private
     */
    namespace.handlerParser.prototype.__construct = function(){

    };



    /**
     *
     * @returns {Q.promise}
     */
    namespace.handlerParser.prototype.parse = function(handlers) {
        var worker = app.utils.getResolved(true);
        if(!handlers.length){
            return worker;
        }

        handlers.forEach(function(item) {
            var handlerName = item.name;
            if(!app.handlers[handlerName]){
                console.error("app::handlerParser: Not found  handler "+handlerName);
                return true;
            }
            worker = worker.then(function(){
                var event = new app.handlers[handlerName](item);
                return event.promise ? event.promise : true;
            });
        });
        
        worker.fail(function(){
            console.error(arguments);
        });
        
        return worker;
    };
    

    return namespace.handlerParser;
})(__ARGUMENT_LIST__);