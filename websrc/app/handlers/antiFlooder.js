(function (namespace, app, globals) {

    var flooders = {};

    namespace.antiFlooder = function (item) {

        clearTimeout(flooders[item.id]);
        flooders[item.id] = setTimeout(function () {
            app.services.handlerParser.parse(item.handlers);
        }, item.timeout);

    };


    return namespace.antiFlooder;
})(__ARGUMENT_LIST__);