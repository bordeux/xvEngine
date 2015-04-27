(function (namespace, app, globals) {


    namespace.abstractComponent = app.newClass({
        traits: [function () {
            return app.classes.events;
        }]
    });


    /**
     * Constructor
     * @param options
     * @private
     */
    namespace.abstractComponent.prototype.__construct = function (options) {
        this.$element = $("<div>");
        this.disableEvents(false);
        this.events = {};
        this.setId(options.id);
        this.setParams(options.params);
        this.setEventsList(options.events);
        this.initView();
        this.addClass(this.params.classes);
        this.setAttrs(this.params.attrs);
    };


    /**
     * Setting component name
     * @param {String} name
     * @returns {namespace.abstractComponent}
     */
    namespace.abstractComponent.prototype.setComponentName = function (name) {
        this.$element.attr("component", name);
        this.componentName = name;
        return this;
    };


    /**
     * Getting component name
     * @returns {String}
     */
    namespace.abstractComponent.prototype.getComponentName = function () {
        return this.componentName;
    };


    /**
     * Set view to component
     * @param $element
     * @returns {namespace.abstractComponent}
     */
    namespace.abstractComponent.prototype.setElement = function ($element) {
        this.$element = $element;
        return this;
    };

    //noinspection JSValidateJSDoc
    /**
     * Getting component view
     * @param $element
     * @returns {jQuery}
     */
    namespace.abstractComponent.prototype.getElement = function ($element) {
        return this.$element;
    };


    /**
     * Initialize view
     * @returns {namespace.abstractComponent}
     */
    namespace.abstractComponent.prototype.initView = function () {
        this.$element = this.replaceWith();
        this.$element.attr({
            "id": this.getId(),
            "component": "undefined"
        });
        this.$element.data("component", this);
        this.$element.get(0).component = this;
        return this;
    };

    //noinspection JSValidateJSDoc
    /**
     * Getting template of component
     * @returns {jQuery}
     */
    namespace.abstractComponent.prototype.replaceWith = function () {
        return this.getTemplate();
    };


    //noinspection JSValidateJSDoc
    /**
     * Component template
     * @returns {jQuery}
     */
    namespace.abstractComponent.prototype.getTemplate = function () {
        return $("<div>");
    };


    /**
     * Default params to component. This method should be overwrited by other components
     * @returns {{classes: string}}
     */
    namespace.abstractComponent.prototype.getDefaultParams = function () {
        return {
            classes: ""
        };
    };

    /**
     * Settings params to constructor
     * @param {Object} params
     * @returns {namespace.abstractComponent}
     */
    namespace.abstractComponent.prototype.setParams = function (params) {
        this.params = $.extend(true, this.getDefaultParams(), params);
        return this;
    };


    /**
     * Setting id of current component
     * @param {String} id
     * @returns {namespace.abstractComponent}
     */
    namespace.abstractComponent.prototype.setId = function (id) {
        this.id = id;
        return this;
    };

    /**
     * Set id of current component
     * @returns {String}
     */
    namespace.abstractComponent.prototype.getId = function () {
        return this.id;
    };


    /**
     * Getting height of current component
     * @returns {Number}
     */
    namespace.abstractComponent.prototype.height = function () {
        return this.$element.height();
    };

    /**
     * Getting width of current component
     * @returns {Number}
     */
    namespace.abstractComponent.prototype.width = function () {
        return this.$element.width();
    };


    /**
     * Constructor for other components
     */
    namespace.abstractComponent.prototype.init = function () {

    };


    /**
     * Triggered when component is created
     */
    namespace.abstractComponent.prototype.create = function () {
        this.init();
        this.trigger("create");
    };


    /**
     * Method is called, when component is destroyed
     */
    namespace.abstractComponent.prototype.destroy = function () {

    };


    /**
     * Hide current component
     * @returns {namespace.abstractComponent}
     */
    namespace.abstractComponent.prototype.hide = function () {
        this.$element.addClass("dnone");
        return this;
    };


    /**
     * Show current component
     * @returns {namespace.abstractComponent}
     */
    namespace.abstractComponent.prototype.show = function () {
        this.$element.removeClass("dnone");
        return this;
    };


    /**
     * Add css class to current component
     * @param {String} classes
     * @returns {namespace.abstractComponent}
     */
    namespace.abstractComponent.prototype.addClass = function (classes) {
        this.$element.addClass(classes);
        return this;
    };


    /**
     * Set attributes to current component
     * @param {Object} attrs
     * @returns {namespace.abstractComponent}
     */
    namespace.abstractComponent.prototype.setAttrs = function (attrs) {
        if (!attrs) {
            return this;
        }
        var self = this;
        Object.keys(attrs).forEach(function (key) {
            self.setAttr(key, attrs[key]);
        });
        return this;
    };


    /**
     * Set attribute to current component
     * @param {String} attr
     * @param {String} value
     * @returns {namespace.abstractComponent}
     */
    namespace.abstractComponent.prototype.setAttr = function (attr, value) {
        this.$element.attr(attr, value);
        return this;
    };


    /**
     * Get attribute from current component
     * @param {String} attr
     * @returns {String}
     */
    namespace.abstractComponent.prototype.getAttr = function (attr) {
        return this.$element.attr(attr);
    };


    /**
     * Setting events
     * @param events
     * @returns {namespace.abstractComponent}
     */
    namespace.abstractComponent.prototype.setEventsList = function (events) {
        var self = this;
        Object.keys(events).forEach(function (eventName) {
            events[eventName].forEach(function(event){
                self.on(eventName, event);
            })
        });

        return this;
    };


    namespace.abstractComponent.prototype.removeClass = function(classes) {
        this.$element.removeClass(classes);
        return this;
    };


    return namespace.abstractComponent;
})(__ARGUMENT_LIST__);