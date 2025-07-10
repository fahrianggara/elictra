$("[data-coreui-toggle='unfoldable']").on("click", function () {
    $(".body .container-fluid, .breadcrumb-container").toggleClass("override-padding");
});

$(document).on("mouseenter", ".sidebar.sidebar-narrow-unfoldable", function () {
    $(this).find("[data-coreui-toggle='unfoldable']").show();
});

$(document).on("mouseleave", ".sidebar.sidebar-narrow-unfoldable", function () {
    $(this).find("[data-coreui-toggle='unfoldable']").hide();
});

/**
 * description: Show a toast notification with custom options.
 *
 * @param {Object} fireOptions - Custom options for the toast notification.
 * @param {Object} mixinOptions - Custom options for the Swal mixin.
 */
function toast(fireOptions = {}, mixinOptions = {}) {
    const defaultMixinOptions = {
        toast: true,
        position: 'bottom-end',
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        },
    };

    const defaultFireOptions = {
        icon: 'success',
        title: '',
    };

    const Toast = Swal.mixin({ ...defaultMixinOptions, ...mixinOptions });

    return Toast.fire({ ...defaultFireOptions, ...fireOptions });
}

/**
 * description: Show a confirmation dialog with custom options.
 *
 * @param {Object} options - Custom options for the confirmation dialog.
 */
function swal(options = {}) {
    const defaultOptions = {
        title: 'Apakah Anda yakin?',
        text: 'Tindakan ini tidak bisa dibatalkan.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal',
    };

    return Swal.fire({ ...defaultOptions, ...options });
}
