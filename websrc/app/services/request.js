(function (namespace, app, globals) {

    app.registerService(function () {
        namespace.request = new namespace.request();
    });

    namespace.request = app.newClass();


    /**
     * Constructor
     * @private
     */
    namespace.request.prototype.__construct = function(){
        this.headers = {};
    };


    /**
     * Set global header to request. After setting some header, any request will be have this header.
     * @param {String}key
     * @param {*} value
     * @returns {namespace.request}
     */
    namespace.request.prototype.setHeader = function (key, value) {
        this.headers[key] = value;
        return this;
    };


    /**
     * Create new request instance
     * @param url
     * @returns {__ARGUMENT_LIST__.request}
     */
    namespace.request.prototype.create = function (url) {
        var self = this;
        var request = new app.classes.request(url);
        Object.keys(this.headers).forEach(function(key){
            request.addHeader(key, self.headers[key]);
        });
        return request;
    };


    return namespace.history;
})(__ARGUMENT_LIST__);