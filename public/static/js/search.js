(function () {
    $(document).on('click .js-product-action', function (e) {
        var button = $(e.target);
        var actionUrl = button.data('action');

        button.addClass('disabled');

        $.post(actionUrl)
            .done(function () {
                button.text('Update');
            })
            .always(function () {
                button.removeClass('disabled');
            })
    });
})();
