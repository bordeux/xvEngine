/**
 * Bootstrap class
 * @param {object} namespace
 * @param {object} app
 * @param {window} globals
 * @returns {object}
 */
(function(namespace, app, globals) {

    app.registerService(function() {
        namespace.opener = new namespace.opener();
    });


    /**
     * 
     * @returns {undefined}
     */
    namespace.opener = function() {

    };




    /**
     * 
     * @returns {String}
     */
    namespace.opener.prototype.openPopUp = function(url, windowName, options){
        window.open(url, windowName, options);
    };

    
    return namespace.opener;
})(__ARGUMENT_LIST__);