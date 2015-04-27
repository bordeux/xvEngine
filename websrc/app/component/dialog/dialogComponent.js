(function(namespace, app, globals) {


    namespace.dialogComponent = app.newClass({
        extend: function () {
            return app.classes.component.abstractComponent;
        }
    });
    
   
    /**
     * 
     * @returns {$}
     */
    namespace.dialogComponent.prototype.getTemplate = function() {
        var tmplString = app.utils.getString(function() {
            /**<string>
                    <xv-dialog class="event-insert event-esc" tabindex="-1">
                        <div class="closable">
                            <div class="closable">
                                <div class="window">
                                    <a href="#close">
                                        <i class="glyphicon glyphicon-remove-circle"></i>
                                    </a>
                                    <header></header>
                                    <section></section>
                                    <footer></footer>
                                </div>
                            </div>
                        </div>
                    </xv-dialog>
             </string>*/
        });
        return $(tmplString);
    };


    /**
     * 
     * @returns {object}
     */
    namespace.dialogComponent.prototype.getDefaultParams = function() {
        return {
            width: "60vw",
            height: "auto",
            headerComponent : null,
            contentComponent : null,
            footerComponent : null,
            manualClose : false
        };
    };

  
    /**
     * 
     * @returns {undefined}
     */
    namespace.dialogComponent.prototype.init = function() {
        this.$dialogWindow = this.$element.find(">div > div > div");
        this.$close = this.$dialogWindow.find("> a");
        
        this.setWidth(this.params.width);
        this.setHeight(this.params.height);
        
        this.$header =  this.$dialogWindow.find("> header");
        this.$content =  this.$dialogWindow.find("> section");
        this.$footer =  this.$dialogWindow.find("> footer");
        
        this.setManualClose(this.params.manualClose);
        this.params.headerComponent && this.setHeaderComponent(this.params.headerComponent);
        this.params.contentComponent && this.setContentComponent(this.params.contentComponent);
        this.params.footerComponent && this.setFooterComponent(this.params.footerComponent);
        this.createScrollRule();
        this.bindEvents();
        

        this.show(); //this should be manual triggered!
    };

    namespace.dialogComponent.prototype.createScrollRule = function () {
        //@todo : this should be do better
        app.services.ui.css.addRule("html.dialog-displayed .xv-site-layout header.xv-header > .fixed", {
            "padding-right": app.utils.getScrollBarWidth()+"px"
        });
    };


    namespace.dialogComponent.prototype.setManualClose = function(value) {
        this._manualClose = !!value;
        return this;
    };
    
    namespace.dialogComponent.prototype.setWidth = function(value) {
        this.$dialogWindow.width(value);
        return this;
    };
    
    namespace.dialogComponent.prototype.setHeight = function(value) {
        this.$dialogWindow.height(value);
        return this;
    };
    
    
    namespace.dialogComponent.prototype.show = function() {
        $("html").addClass("dialog-displayed");
        app.services.ui.tips.hideAll();
        return this;
    };
    
  
    
    
    
    namespace.dialogComponent.prototype.close = function() { 
        var self = this;
        this.$element.addClass("closing");
        var $application = app.utils.getApplication();
        
        if($application.find("xv-dialog:not(.closing)").length == 0){
            $("html").removeClass("dialog-displayed");
        }
        
        
        var timeout = app.utils.getTranistionDuration(this.$element) + app.utils.getTranistionDelay(this.$element);
        self.$element.addClass("remove-animation");
        setTimeout(function(){
            self.$element.remove();
        }, timeout);
  
        return this;
    };
    
    
    namespace.dialogComponent.prototype.setHeaderComponent = function(component) {
        var self = this;
        return app.utils.buildComponent(component).then(function ($html) {
            self.$header.html($html);
            return true;
        });
    };
    
    namespace.dialogComponent.prototype.setContentComponent = function(component) {
        var self = this;
        return app.utils.buildComponent(component).then(function ($html) {
            self.$content.html($html);
            return true;
        });
    };
    
    namespace.dialogComponent.prototype.setFooterComponent = function(component) {
        var self = this;
        return app.utils.buildComponent(component).then(function ($html) {
            self.$footer.html($html);
            return true;
        });
    };
    
    
    
    
    namespace.dialogComponent.prototype.bindEvents = function() {
        var self = this;
        
        this.$close.on("click", function(){
            self.trigger("onClose");
            if(!self._manualClose){
                self.close();
            }
            
            return false;
        });
 
        
        this.$element.on("click", function(e){
            if($(e.target).is(".closable")){
                self.$close.trigger("click");
                return false;
            }
        });
        
        this.$element.on("event-esc", function () {
            if($("xv-shared-place > xv-dialog:last").is(self.$element)){ //@todo: here should be better solution
                self.$close.trigger("click");
            }
        });

        this.$element.on('event-insert', function(){
            self.$element.focus();
            setTimeout(function(){
                self.$element.focus();
            }, 100);
        });
    };
    
    
   
    
    return namespace.dialogComponent;
})(__ARGUMENT_LIST__);