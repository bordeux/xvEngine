/**
 * @package XV-Engine
 * @version <%= pkg.version %>
 * @date <%= grunt.template.today("yyyy-mm-dd") %>
 * @author Krzysztof Bednarczyk
 *
 */
var application = {};
(function (app) {

    /**
     * Create namespace for class
     * @param {String} namespace
     * @returns {Object}
     */
    app.namespace = function (namespace) {
        var nsparts = namespace.split(".");
        var parent = app;

        // we want to be able to include or exclude the root namespace
        // So we strip it if it's in the namespace
        if (nsparts[0] === "app") {
            nsparts = nsparts.slice(1);
        }

        // loop through the parts and create
        // a nested namespace if necessary
        for (var i = 0; i < nsparts.length; i++) {
            var partname = nsparts[i];
            // check if the current parent already has
            // the namespace declared, if not create it
            if (typeof parent[partname] === "undefined") {
                parent[partname] = {};
            }
            // get a reference to the deepest element
            // in the hierarchy so far
            parent = parent[partname];
        }
        // the parent is now completely constructed
        // with empty namespaces and can be used.
        return parent;
    };


    /**
     * Create new class
     * @param {Object} _extendObj
     * @returns {Function}
     */
    app.newClass = function (_extendObj) {
        var buildOnlyValue = "___c4130e7caaf6a2e021562b37c2444607___";
        var constructorMethodName = "__construct";

        return function (arg) {
            var self = this;

            Object.keys(this.__proto__).forEach(function (key) {
                self[key] = self.__proto__[key];
            });

            this.__proto__ = {};

            if (_extendObj && _extendObj.extend) {
                var _class = (_extendObj.extend());
                var _classExecuted = new _class(buildOnlyValue);
                this.__proto__ = _classExecuted;

                var _$$super = {};
                Object.keys(_classExecuted).forEach(function (key2) {
                    _$$super[key2] = _classExecuted[key2].bind ? _classExecuted[key2].bind(self) : _classExecuted[key2];
                    _$$super[key2].execute = function (args) {
                        return _$$super[key2].apply(self, args);
                    };
                });

                this._super = function () {
                    return _$$super;
                };
            }

            if (_extendObj && _extendObj.traits) { //support traits
                _extendObj.traits.forEach(function (callable) {
                    var trait = callable();
                    Object.keys(trait.prototype).forEach(function (key) {

                        self.__proto__[key] =
                            trait.prototype[key].bind ?
                            trait.prototype[key].bind(self) :
                            jQuery.extend({}, trait.prototype[key]);
                    });
                })
            }


            if (arg != buildOnlyValue && this[constructorMethodName]) {
                this[constructorMethodName].apply(this, arguments);
            }
        };
    };


    /**
     * Service list to initialize
     * @type {Array}
     */
    app.servicesInitList = [];


    /**
     * Method to register service
     * @param {Function} callable
     * @param {Number} priority
     */
    app.registerService = function (callable, priority) {
        app.servicesInitList.push({
            init: callable,
            priority: priority | 0
        });
    };


    /**
     * Config loader
     * @param obj
     * @param nms
     * @param defaults
     * @returns {boolean}
     */
    app.configLoader = function (obj, nms, defaults) {
        if (typeof app.services === "undefined") {
            console.error("App:: You cannot use configLoader before services init");
            return false;
        }
        if (typeof defaults === "undefined") {
            defaults = {};
        }

        if (nms.substr(0, 4) == "app.") {
            nms = nms.substr(4);
        }

        var result = app.services.config.get(nms);
        if (!app.utils.isObject(result)) {
            result = {};
        }

        $.extend(defaults, result);
        Object.keys(defaults).forEach(function (key) {
            if (typeof obj[key] === "undefined") {
                return;
            }

            if (typeof obj[key] === "function") {
                obj[key].apply(obj, defaults[key]);
                return;
            }
            obj[key] = defaults[key];
        });

        return true;
    };


    /**
     * do not end this file! look for footer.js
     */



})(x);