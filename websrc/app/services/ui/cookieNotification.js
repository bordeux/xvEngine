/**
 * Bootstrap class
 * @param {object} namespace
 * @param {object} app
 * @param {window} globals
 * @returns {object}
 */
(function(namespace, app, globals) {


    
    app.registerService(function() {
        namespace.cookieNotification = new namespace.cookieNotification();
    });


    /**
     * 
     * @returns {undefined}
     */
    namespace.cookieNotification = function() {
        var cookieValue =  $.cookie('xv_cookies')|0;
        if(cookieValue){
            return;
        }
        
        this.init();
    };

    /**
     * 
     * @returns {$}
     */
    namespace.cookieNotification.prototype.getTemplate = function() {
        var tmplString = app.utils.getString(function () {
            /**<string>
                <xv-cookie-alert class="cookie-alert cookie-notification cookies">
                    <span class="text">
                       
                    </span>
                    <a href="#" class="btn small-btn bgcolor" >OK</a>
                </xv-cookie-alert>
             </string>*/
        });
        return $(tmplString);
    };
    
    /**
     * 
     * @returns {undefined}
     */
    namespace.cookieNotification.prototype.init = function() {
        var self = this;
        this.$element = this.getTemplate();
        this.$element.appendTo("application > services");
        this.setText("This site uses cookies. By continuing to browse the site, you are agreeing to our use of cookies.");
        this.$element.on("click", function(){
            self.hide();
            return false;
        });
    };

    /**
     * 
     * @param {String} text
     * @returns {cookieNotification_L8.namespace.cookieNotification.prototype}
     */
    namespace.cookieNotification.prototype.setText = function(text) {
        if(!this.$element){
            return this;
        }
        
        this.$element.find(".text").html(text);
        return this;
    };
    
    
   
    /**
     * 
     * @param {String} text
     * @returns {cookieNotification_L8.namespace.cookieNotification.prototype}
     */
    namespace.cookieNotification.prototype.hide = function(text) {
        $.cookie('xv_cookies', '1', { expires: 99999, path: '/' });
        this.$element.addClass("hide");
        return this;
    };
    
    
   




    return namespace.cookieNotification;
})(__ARGUMENT_LIST__);