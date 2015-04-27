(function (namespace, app, globals) {

    namespace.colorInputComponent = app.newClass({
        extend: function () {
            return app.classes.component.abstractInputComponent;
        }
    });

    namespace.colorInputComponent.prototype.validators = {};

    namespace.colorInputComponent.prototype.getTemplate = function () {
        var tmplString = app.utils.getString(function () {
            //@formatter:off
            /**<string>
             <xv-color-input>
                <label>
                    <span class="label fcolor-after"></span>
                    <input type="text" class="input" value="">
                </label>
             </xv-color-input>
             </string>*/
            //@formatter:on
        });
        return $(tmplString);
    };

    namespace.colorInputComponent.prototype.getDefaultParams = function () {
        return {
            "inline" : false,
            "defaultValue" : "",
            "control" : "hue",
            "position" : "bottom left"

        };
    };


    /**
     *
     */
    namespace.colorInputComponent.prototype.prepare = function () {
        this.loaded = false;
        this.setPosition(this.params.position);
        this.setControl(this.params.control);
        this.setInline(this.params.inline);
        this.setDefaultValue(this.params.defaultValue);

        this.initMiniColors();
    };


    /**
     *
     * @param position
     * @returns {namespace.colorInputComponent}
     */
    namespace.colorInputComponent.prototype.setPosition = function (position) {
        this._position = position;
        return this;
    };

    /**
     *
     * @param ctrl
     * @returns {namespace.colorInputComponent}
     */
    namespace.colorInputComponent.prototype.setControl = function (ctrl) {
        this._control = ctrl;
        return this;
    };

    /**
     *
     * @param inline
     * @returns {namespace.colorInputComponent}
     */
    namespace.colorInputComponent.prototype.setInline = function (inline) {
        this._inline = !!inline;
        return this;
    };

    /**
     *
     * @param value
     * @returns {namespace.colorInputComponent}
     */
    namespace.colorInputComponent.prototype.setDefaultValue = function (value) {
        this._defalutValue = value;
        return this;
    };


    /**
     *
     * @param value
     * @returns {namespace.colorInputComponent}
     */
    namespace.colorInputComponent.prototype.setValue = function (value) {
        this._value = value;
        if(this.loaded){
            this.$input.minicolors('value', [value]);
        }
        return this;
    };


    /**
     *
     * @returns {namespace.colorInputComponent}
     */
    namespace.colorInputComponent.prototype.initMiniColors = function () {
        if(this.loaded){
            return this;
        }
        var self = this;
        this.$input.minicolors({
            control: this._control,
            defaultValue: this._defalutValue || '',
            inline: this._inline,
            letterCase: 'uppercase',
            position: this._position,
            value : this._value,
            change: function(hex, opacity) {
                self._value = hex;
                self.onInput();
            },
            theme: 'default'
        });

        this.loaded = true;

        return this;
    };


    namespace.colorInputComponent.prototype.initEvents = function () {
        var self = this;
        this.$element.on("event-insert", function(){
           self.initMiniColors();
        });
        

        return this;
    };



    return namespace.colorInputComponent;
})(__ARGUMENT_LIST__);