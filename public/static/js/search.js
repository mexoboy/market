(function () {
    $(document).on('click', '.js-product-action', function (e) {
        var button = $(e.target);
        var actionUrl = button.data('action');

        button.addClass('disabled');

        $.post(actionUrl)
            .done(function () {
                button.text('Update');
            })
            .fail(function(response) {
                console.error(response.responseJSON)
                alert(response.responseJSON.error || 'Some error happen! Please try later.');
            })
            .always(function () {
                button.removeClass('disabled');
            })
    });
})();
