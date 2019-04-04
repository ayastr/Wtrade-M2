require(["jquery", "jquery/ui"], function ($) {
    $(document).ready(function () {
        $("#sku").autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "/ayastrwtrade_router/product/autocomplete",
                    dataType: "json",
                    data: {
                        sku: request.term
                    },
                    complete: function (data) {
                        var formattedArray = [];
                        $.each(data.responseJSON, function (sku, name) {
                            formattedArray.push({
                                'label': name,
                                'value': sku
                            });
                        });
                        response(formattedArray);
                    }
                });
            },
            messages: {
                noResults: '',
                results: function () {
                }
            },
            minLength: 1,
            select: function (event, ui) {

                console.log(ui.item);
            }
        });
    });
});
