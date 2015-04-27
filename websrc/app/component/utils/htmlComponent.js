(function(namespace, app, globals) {


    namespace.htmlComponent = app.newClass({
        extend: function () {
            return app.classes.component.abstractComponent;
        }
    });
    
    


    /**
     * 
     * @returns {$}
     */
    namespace.htmlComponent.prototype.getTemplate = function() {
        var tmplString = app.utils.getString(function() {
            /**<string>
                    <xv-html>
                    </xv-html>
             </string>*/
        });
        return $(tmplString);
    };
    

    /**
     * 
     * @returns {object}
     */
    namespace.htmlComponent.prototype.getDefaultParams = function() {
        return {
            html : "",
            items : []

        };
    };

  
    /**
     * 
     * @returns {undefined}
     */
    namespace.htmlComponent.prototype.init = function() {
        this.setHTML(this.params.html);
        this.setComponents(this.params.items);

        this.initEvents();
    };
  
    /**
     * 
     * @returns {undefined}
     */
    namespace.htmlComponent.prototype.setHTML = function(html, selector) {
        var $element = this.$element;

        if(selector){
            $element = $element.find(selector);
        }

        $element.html(html);
        return this;
    };


    namespace.htmlComponent.prototype.setComponents = function(components) {
        var self = this;
        var worker = app.utils.getResolved();
        components.forEach(function(item){
            worker = worker.then(function(){
                return self.addItem(item);
            });
        });

        return worker;
    };

    namespace.htmlComponent.prototype.addItem = function(item) {
        var self = this;
        return app.utils.buildComponent(item.component).then(function($html){
            var $el = self.$element.find(item.selector);
            $el[app.utils.ifsetor(item.replace, false) ? 'replaceWith' : 'html']($html);
            return true;
        });
    };

    namespace.htmlComponent.prototype.addComponent = function(item) {
        return this.addItem(item);
    };


    /**
     * 
     * @returns {undefined}
     */
    namespace.htmlComponent.prototype.initEvents = function() {
        var self = this;
        
        this.$element.on("click", "[xv-html-click]", function(){
            var eventName = $(this).attr("xv-html-click");
            self.trigger(eventName ? eventName : 'onClick');
            return false;
        });
        
        return this;
    };
    
    
    
  
    return namespace.htmlComponent;
})(__ARGUMENT_LIST__);