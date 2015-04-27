/**
 * Bootstrap class
 * @param {object} namespace
 * @param {object} app
 * @param {window} globals
 * @returns {object}
 */
(function (namespace, app, globals) {



    app.registerService(function () {
        namespace.ajax = new namespace.ajax();
    });


    namespace.ajax = function () {
        this.bindEvents();
    };

    namespace.ajax.prototype.bindEvents = function () {
        var $application = $("application");
        $application.on("click", "a.xv-request", function () {
            var url = $(this).attr('href');
            var request = app.services.request.create(url);
            request.addHeader("X-XV-Source", "services.ui.ajax");
            request.run();
            return false;
        });

        $application.on("click", "a.xv-request-reload", function () {
            var url = $(this).attr('href');
            var request = app.services.request.create(url);
            request.addHeader("X-XV-First-Request", 1);
            request.addHeader("X-XV-Source", "bootstrap");
            request.run();
            return false;
        });

    };





    return namespace.ajax;
})(__ARGUMENT_LIST__);