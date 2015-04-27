/**
 * Bootstrap class
 * @param {object} namespace
 * @param {object} app
 * @param {window} globals
 * @returns {object}
 */
(function (namespace, app, globals) {

    app.registerService(function () {
        namespace.history = new namespace.history();
    });



    namespace.history = app.newClass();


    /**
     * Constructor
     * @private
     */
    namespace.history.prototype.__construct = function(){
        this.state = globals.history;
        this.$title = $("head title");
        this.stack = [];
        this.bindEvents();
    };


    /**
     * Set page title
     * @param {String} title
     * @returns {namespace.history}
     */
    namespace.history.prototype.setTitle = function (title) {
        this.$title.text(title);
        return this;
    };


    /**
     * Push new state of window
     * @param {String} title
     * @param {String} path
     * @returns {namespace.history}
     */
    namespace.history.prototype.push = function (title, path) {
        this.stack.push({
            "method" : "stack",
            "title" : title,
            "path" : path
        });
        this.setTitle(title);
        this.state.pushState({}, title, path);
        return this;
    };

    /**
     * Replace current state of window
     * @param {String} title
     * @param {String} path
     * @returns {namespace.history}
     */
    namespace.history.prototype.replace = function (title, path) {
        this.stack.push({
            "method" : "replace",
            "title" : title,
            "path" : path
        });
        this.setTitle(title);
        this.state.replaceState({}, title, path);
        return this;
    };


    /**
     * Back state
     * @returns {namespace.history}
     */
    namespace.history.prototype.back = function () {
        this.state.back();
        return this;
    };
    

    
    
    namespace.history.prototype.getStack = function () {
        return this.stack;
    };


    /**
     * Remove last state
     * @returns {namespace.history}
     */
    namespace.history.prototype.pop = function () {
        this.stack.pop(); //remove current route
        var last = this.stack.pop();

        if(!last){
            return this;
        }

        this.replace(last.title, last.path);
        return this;
    };


    /**
     * Event when user click back
     */
    namespace.history.prototype.bindEvents = function () {
        var lastXHR = null;
        globals.onpopstate = function (event) {
            if(lastXHR){
                //lastXHR.abort();
            }
            var request = app.services.request.create(globals.document.location);
            request.addHeader("X-XV-History-Request", 1);
            request.run();
            lastXHR = request.getXHR();
        };
    };




    return namespace.history;
})(__ARGUMENT_LIST__);