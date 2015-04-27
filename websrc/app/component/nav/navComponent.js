/**
 * Bootstrap class
 * @param {object} namespace
 * @param {object} app
 * @param {window} globals
 * @returns {object}
 */
(function (namespace, app, globals) {

    namespace.navComponent = app.newClass({
        extend: function () {
            return app.classes.component.abstractComponent;
        }
    });


    /**
     *
     * @returns {$}
     */
    namespace.navComponent.prototype.getTemplate = function () {
        var tmplString = app.utils.getString(function () {
            /**<string>
             <ul class="nav navbar-nav">
             </ul>
             </string>*/
        });
        return $(tmplString);
    };


    /**
     *
     * @returns {object}
     */
    namespace.navComponent.prototype.getDefaultParams = function () {
        return {
            items: [],
            active : null
        };
    };

    /**
     *
     * @returns {undefined}
     */
    namespace.navComponent.prototype.init = function () {
        this.setItems(this.params.items);
        this.setActive(this.params.active);
    };

    namespace.navComponent.prototype.setItems = function (items) {
        var self = this;
        this.$element.html("");
        items.forEach(function (item) {
            self.addItem(item);
        });
    };

    namespace.navComponent.prototype.addItem = function (item) {
        var $li = $("<li>");
        $li.attr("item-id", item.id);
        var $a = $("<a>");
        $li.html($a);

        $a.attr("href", item.href);
        $a.addClass("xv-request");
        $a.html(item.label);
        this.$element.append($li);
        this.refreshActive();
        return true;
    };


    namespace.navComponent.prototype.setActive = function (active) {
        this._active = active;
        this.refreshActive();
        return true;
    };

    namespace.navComponent.prototype.refreshActive = function () {
        var self = this;
        var $items = this.$element.find("> li");

        $items.removeClass("active");
        $items.filter(function(){
            return $(this).attr("item-id") == self._active
        }).addClass("active");

        return true;
    };


    return namespace.navComponent;
})(__ARGUMENT_LIST__);