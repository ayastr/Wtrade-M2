require(["jquery", "mage/url", "Magento_Customer/js/customer-data"], function ($, urlBuilder, customerData) {
    $(document).ready(function () {
        $("#post-btn").on('click', function (e) {
            e.preventDefault();
            var addToCartRoute = urlBuilder.build("checkout/cart/add");
            var formData = $("#add-product").serialize();

            $.post(addToCartRoute, formData)
                .done(function (result) {
                    customerData.reload(['cart'], true);
                    if (result.length != 0) {
                        customerData.invalidate(['messages']);
                        customerData.reload(['messages'], true);
                    }
                });
        });
    });
});