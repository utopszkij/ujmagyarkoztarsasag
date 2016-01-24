window.addEvent('domready', function() {
        document.formvalidator.setHandler('name',
                function (value) {
                        regex=/com_.*/;
                        return regex.test(value);
        });
});
