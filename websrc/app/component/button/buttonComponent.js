/**
 * Bootstrap class
 * @param {object} namespace
 * @param {object} app
 * @param {window} globals
 * @returns {object}
 */
(function(namespace, app, globals) {

    namespace.buttonComponent = app.newClass({
        extend: function () {
            return app.classes.component.abstractComponent;
        }
    });
    
    

    /**
     * 
     * @returns {$}
     */
    namespace.buttonComponent.prototype.getTemplate = function() {
        var tmplString = app.utils.getString(function() {
            /**<string>
                    <a href="#" target="_blank" class="btn btn-default">
                    
                    </a>
             </string>*/
        });
        return $(tmplString);
    };


    /**
     * 
     * @returns {object}
     */
    namespace.buttonComponent.prototype.getDefaultParams = function() {
        return {
            url : "about:blank",
            text : "",
            disable : false,
            stopPropagation : true
        };
    };

    /**
     * 
     * @returns {undefined}
     */
    namespace.buttonComponent.prototype.init = function() {
        this.setText(this.params.text);
        this.disable(this.params.disable);
        this.setUrl(this.params.url);
        this.stopPropagation(this.params.stopPropagation);
        this.initEvents();
    };
    
    
    /**
     * 
     * @param {Bollean} disable
     * @returns {_L8.namespace.buttonWithConfirmController.prototype}
     */
    namespace.buttonComponent.prototype.disable = function(disable) {
        this.$element[disable ? 'addClass' : 'removeClass']("disabled");
        this.trigger(disable ? 'onDisable' : 'onEnable');
        return this;
    };

    namespace.buttonComponent.prototype.isDisabled = function(disable) {
        return this.$element.is(".disabled");
    };



    namespace.buttonComponent.prototype.initEvents = function() {
        var self = this;
        this.$element.on("click", function(){
                self.trigger("click");
                
            return !self._stopPropagation;
        });
        
        return this;
    };
    
    
    namespace.buttonComponent.prototype.stopPropagation = function(val) {
        this._stopPropagation = !!val;
        return this;
    };
    
    
/**
     * 
     * @param {String} text
     * @returns {_L8.namespace.buttonController.prototype}
     */
    namespace.buttonComponent.prototype.setText = function(text) {
        this.$element.html(text);
        return this;
    };
    
    /**
     * 
     * @param {String} url
     * @returns {_L8.namespace.buttonController.prototype}
     */
    namespace.buttonComponent.prototype.setUrl = function(url) {
        this.$element.attr("href", url);
        return this;
    };
    
    
 
    return namespace.buttonComponent;
})(__ARGUMENT_LIST__);