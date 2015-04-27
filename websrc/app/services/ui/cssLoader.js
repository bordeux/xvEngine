/**
 * Bootstrap class
 * @param {object} namespace
 * @param {object} app
 * @param {window} globals
 * @returns {object}
 */
(function(namespace, app, globals) {

    app.registerService(function() {
        namespace.cssLoader = new namespace.cssLoader();
    });


    /**
     * 
     * @returns {undefined}
     */
    namespace.cssLoader = function() {
        app.configLoader(this, __PATH__.className, {
        });
    };




    /**
     * 
     * @returns {String}
     */
    namespace.cssLoader.prototype.load = function(files){
        var self = this;
        if(typeof files == "string"){
            files = [files];
        }
        
        var worker = Q.fcall(function(){
            return true;
        });
        
        files.forEach(function(file){
            worker = worker.then(function(){
                return self._load(file);;
            });
            
        });
        
        return worker;
    };


    namespace.cssLoader.prototype._load = function (file) {
        var css = globals.document.createElement("link");
        css.setAttribute("rel", "stylesheet");
        css.setAttribute("type", "text/css");
        css.setAttribute("href", file);
        document.getElementsByTagName("head")[0].appendChild(css);
        return true;
    };


    
    
    
    return namespace.cssLoader;
})(__ARGUMENT_LIST__);