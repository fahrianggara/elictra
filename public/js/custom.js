$("[data-coreui-toggle='unfoldable']").on("click", function () {
    $(".body .container-fluid, .breadcrumb-container").toggleClass("override-padding");
});

$(document).on("mouseenter", ".sidebar.sidebar-narrow-unfoldable", function () {
    $(this).find("[data-coreui-toggle='unfoldable']").show();
});

$(document).on("mouseleave", ".sidebar.sidebar-narrow-unfoldable", function () {
    $(this).find("[data-coreui-toggle='unfoldable']").hide();
});
