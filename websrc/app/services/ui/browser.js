/**
 * Bootstrap class
 * @param {object} namespace
 * @param {object} app
 * @param {window} globals
 * @returns {object}
 */
(function(namespace, app, globals) {

  
    
    app.registerService(function() {
        namespace.browser = new namespace.browser();
    });


    namespace.browser = function() {
        this.initHTMLClasses();
    };

    namespace.browser.prototype.initHTMLClasses = function() {
        var $html = $("html");
        $html.addClass($.browser.platform);
        $html.addClass($.browser.name);
        
        if($.browser.webkit){
            $html.addClass("webkit");
        }
        
        if($.browser.win){
            $html.addClass("win");
        }
        
        if($.browser.desktop){
            $html.addClass("desktop");
        }
        if($.browser.mobile){
            $html.addClass("mobile");
        }
        if(!!globals.navigator.platform.match(/iPhone|iPod|iPad/)){
            $html.addClass("ios");
        }
        
        if('ontouchstart' in globals.document.documentElement){
            $html.addClass("touch");
        }
        
    };



    return namespace.browser;
})(__ARGUMENT_LIST__);