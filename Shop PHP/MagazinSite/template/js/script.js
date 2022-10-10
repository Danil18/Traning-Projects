$(document).ready(function () {
    $(".add-to-cart, .btn-add-to-cart").click(function () {
        var id = $(this).attr("data-id");
        $.post("/MagazinSite/cart/addAjax/" + id, {}, function (data) {
            $("#cart-count").html('('+data+')');
        });
        return false;
    });
});
