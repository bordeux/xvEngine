(function(namespace, app, globals) {

    namespace.multi = function(item) {
        this.item = item;
        this.promise = this.parseHandlers(item.handlers);
    };


    namespace.multi.prototype.parseHandlers = function(handlers){
        return app.services.handlerParser.parse(handlers);
    };
    

    return namespace.multi;
})(__ARGUMENT_LIST__);