// Document ready function using jQuery shorthand
jQuery(document).ready(function ($) {
    // Nonce for security
    let _nonce = ajax._nonce;

    // Inserting products by AJAX
    $('#insertProduct').on('submit', function (e) {
        // Preventing default behavior
        e.preventDefault();

        // Getting input values
        let productName = $('#productName').val();
        let productBrand = $('#productBrand').val();
        let productModel = $('#productModel').val();
        let productPrice = $('#productPrice').val();
        let productStatus = $('#productStatus').val();

        // Sending AJAX request
        $.ajax({
            url: ajax.ajaxurl,
            type: 'post',
            data: {
                action: 'insert_product',
                productName: productName,
                productBrand: productBrand,
                productModel: productModel,
                productPrice: productPrice,
                productStatus: productStatus,
                _nonce: _nonce
            },
            success: function (response) {
                if (response.success) {
                    // SweetAlert library for success message
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: response.message,
                        showConfirmButton: false,
                        timer: 2500
                    });

                    // Appending new product row to the table
                    $('#tableBody').append("<tr><th scope='row'>" + response.data.ID + "</th><td>" + response.data.p_name + "</td><td>" + response.data.p_brand + "</td><td>" + response.data.p_model + "</td><td>" + response.data.p_price + "</td><td>" + ((response.data.p_status == 0) ? ('<span class="badge bg-custom-danger custom-badge">نا موجود</span>') : ('<span class="badge bg-success custom-badge">موجود</span>')) + "</td><td><i title='بارگذاری مجدد' class='fas fa-sync-alt text-custom-primary ps-3 cursor-pointer reload-page'></i></td></tr>");

                    // Reload page functionality
                    $('.reload-page').on('click', function () {
                        location.reload(true);
                    });
                }
            },
            error: function (error) {
                if (error.error) {
                    // SweetAlert library for error message
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: error.responseJSON.message,
                        showConfirmButton: false,
                        timer: 2500
                    });
                }
            },
            complete: function () {
                // Clearing input values after AJAX request
                $('#productName').val(null);
                $('#productBrand').val(null);
                $('#productModel').val(null);
                $('#productPrice').val(null);
                $('#productStatus').val(null);
            }
        });
    });
    //deleting products by ajax
    // Handling click event on elements with the 'delete-product' class
    $('.delete-product').click(function () {
        // Getting the clicked element
        let el = $(this);
        // Getting the product ID from the data-attribute
        let product_id = el.data('id');

        // Using SweetAlert library for a confirmation dialog
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success btn-custom-success mx-2",
                cancelButton: "btn btn-danger btn-custom-danger"
            },
            buttonsStyling: false
        });

        // Displaying a confirmation dialog
        swalWithBootstrapButtons.fire({
            title: "آیا از حذف محصول اطمینان دارید؟",
            text: "در صورت حذف، امکان بازگردانی وجود ندارد",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "بله",
            cancelButtonText: "نه! حذفش نکن",
            reverseButtons: true
        }).then((result) => {
            // If the user confirms the deletion
            if (result.isConfirmed) {
                // AJAX structure for deleting a product
                $.ajax({
                    url: ajax.ajaxurl,
                    type: 'post',
                    data: {
                        action: 'delete_product',
                        product_id: product_id,
                        _nonce: _nonce
                    },
                    beforeSend: function () {
                        // Changing the icon before sending the request
                        el.removeClass('fa-times-circle').addClass('fa-sync fa-spin');
                    },
                    success: function (response) {
                        // If the deletion is successful
                        if (response.success) {
                            // SweetAlert for a success message
                            swalWithBootstrapButtons.fire({
                                title: "حذف شد!", text: response.message, icon: "success"
                            });
                            // Fading out the table row containing the deleted product
                            el.parents('tr').fadeOut();
                        }
                    },
                    error: function (error) {
                        // If there's an error in the AJAX request
                        if (error.error()) {
                            // SweetAlert for an error message
                            Swal.fire({
                                position: "center",
                                icon: "error",
                                title: error.responseJSON.message,
                                showConfirmButton: false,
                                timer: 2500
                            });
                        }
                    },
                    complete: function () {
                        // Changing the icon back after completing the request
                        el.removeClass('fa-sync fa-spin').addClass('fa-times-circle');
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                // If the user cancels the deletion
                swalWithBootstrapButtons.fire({
                    title: "منتفی شد!", text: "محصول شما حذف نشد", icon: "error"
                });
            }
        });
    });

// Reading product details by AJAX when 'update-product' is clicked
    $('.update-product').on('click', function () {
        // Getting the product ID using the 'data-id' attribute
        let product_id = $(this).attr('data-id'); // Second method to get data attribute

        // AJAX request to find product details by ID
        $.ajax({
            url: ajax.ajaxurl,
            type: 'post',
            data: {
                action: 'find_product_by_ID',
                product_id: product_id,
                _nonce: _nonce
            },
            success: function (response) {
                // Parsing JSON response to extract product details
                let data = JSON.parse(response);

                // Setting values in the update form fields
                $('#updateID').val(data.ID);
                $('#updateName').val(data.p_name);
                $('#updateBrand').val(data.p_brand);
                $('#updateModel').val(data.p_model);
                $('#updatePrice').val(data.p_price);
                $('#updateStatus').val(data.p_status);
            },
            error: function (error) {
                // Handling errors, logging to console for now
                console.log(error);
            },
        });
    });


// Updating products by AJAX when the 'updateProduct' form is submitted
    $('#updateProduct').on('submit', function (e) {
        // Preventing the default form submission behavior
        e.preventDefault();
        let el = $(this);

        // Retrieving values from the form fields
        let updateID = $('#updateID').val();
        let updateName = $('#updateName').val();
        let updateBrand = $('#updateBrand').val();
        let updateModel = $('#updateModel').val();
        let updatePrice = $('#updatePrice').val();
        let updateStatus = $('#updateStatus').val();

        // AJAX request to update the product
        $.ajax({
            url: ajax.ajaxurl,
            type: 'post',
            data: {
                action: 'update_product',
                updateID: updateID,
                updateName: updateName,
                updateBrand: updateBrand,
                updateModel: updateModel,
                updatePrice: updatePrice,
                updateStatus: updateStatus,
                _nonce: _nonce
            },
            success: function (response) {
                if (response.success) {
                    // SweetAlert library for displaying success message
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: response.message,
                        showConfirmButton: false,
                        timer: 2500
                    });

                    // Replacing the row with updated product details in the table
                    $('[data-id=' + response.data.ID + ']').parents('tr').replaceWith("<tr><th scope='row'>" + response.data.ID + "</th><td>" + response.data.p_name + "</td><td>" + response.data.p_brand + "</td><td>" + response.data.p_model + "</td><td>" + response.data.p_price + "</td><td>" + ((response.data.p_status == 0) ? ('<span class="badge bg-custom-danger custom-badge">نا موجود</span>') : ('<span class="badge bg-custom-success custom-badge">موجود</span>')) + "</td><td><i title='بارگذاری مجدد' class='fas fa-sync-alt text-custom-primary ps-3 cursor-pointer reload-page'></i></td></tr>");

                    // Adding click event to the reload icon to refresh the page
                    $('.reload-page').on('click', function () {
                        location.reload(true);
                    })
                }
            },
            error: function (error) {
                if (error.error) {
                    // SweetAlert library for displaying error message
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: error.responseJSON.message,
                        showConfirmButton: false,
                        timer: 2500
                    });
                }
            },
            complete: function () {
                // Hiding the 'editProduct' modal after the update
                $('#editProduct').modal('hide');
            },
        });
    });
});