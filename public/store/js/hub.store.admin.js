//############################ Process PriceList request on Cipron Social ############################
$('#priceList').on('click', "#categories a", function (e) {
    e.preventDefault();
    var url = $(this).attr('href');
    $("#itemList").LoadingOverlay("show",
            {
                image: "",
                fontawesome: "fa fa-spinner fa-spin"
            });
    $.get(url, function (data) {
        if (typeof data.response !== 'undefined') {
            $('#priceList').html(data.response);
            $("#itemList").LoadingOverlay("hide");
        } else
            console.log('An error occured');
    });
});
$('#categories').on('click', "a", function (e) {//Only intercepted to display page loader
    //e.preventDefault();
    var url = $(this).attr('href');
    showLoader();
    /**$.get(url, function (data) {
     renderServerResponse(data);
     hideLoader();
     });*/
});
$('#productForm').on('submit', function (e) {
    var selectedCategories = [];
    $('#productCategories input:checked').each(function () {
        var item = $(this).attr('value');
        selectedCategories.push(item);
    });

    $('input[name="selectedCategories"]').val(selectedCategories);
});

//######################## Processes PriceList on Merchant Specific page ###########################
var selectedProducts = [];
$('#selectAll').on('ifChanged', function (event) {//Check and uncheck all products for price list request
    if (event.target.checked) {
        $("#productListDlg input").each(function () {
            $(this).iCheck('check');
            var item = $(this).attr('value');
            selectedProducts.push(item);
        });
        $("#price-list-request-btn").removeClass("hide");
    } else {
        selectedProducts.length = 0;
        $("#productListDlg input").each(function () {
            $(this).iCheck('uncheck');
        });
        $("#price-list-request-btn").addClass('hide');
    }
});
$('#productListDlg input').on('ifChanged', function (event) {//Check and uncheck all products for price list request   
    if (event.target.checked) {
        var item = $(this).attr('value');
        selectedProducts.push(item);
    } else {
        var item = $(this).attr('value');
        var index = selectedProducts.indexOf(item);
        selectedProducts.splice(index, 1);
    }
    if (selectedProducts.length > 0) {
        $("#price-list-request-btn").removeClass("hide");
    } else {
        $("#price-list-request-btn").addClass('hide');
    }
    
});

//############################ Handles Pricelist and Price Quotation form submissions
$('#priceListForm, #quotationForm').on('submit', function (e) {
    e.preventDefault();
    var formId = $(this).attr('id');
    console.log('Items Selected: ' + selectedProducts.toString());
    console.log('FormID: ' + formId);
    if (formId === 'priceListForm') {
        $('#priceListRequestDlg').modal("hide");
        /** var selectedproducts = [];
         $('#productListDlg input:checked').each(function () {
         var item = $(this).attr('value');
         selectedproducts.push(item);
         });*/

        $('input[name="selectedProducts"]').val(selectedProducts);
    } else if (formId === 'quotationForm') {
        $('#quotaionRequestDlg').modal("hide");
    }
    showLoader();
    $.ajax({
        type: $(this).attr('method'),
        url: $(this).attr('action'),
        data: $(this).serialize()
    })
            .done(function (data) {
                hideLoader();
                $('#feedback').fadeIn(3000, function () {});
                $('#message').html(data.message);
                $('#feedback').fadeOut(5000, function () {});
                selectedProducts.length = 0;
                $("#productListDlg input").each(function () {
                    $(this).iCheck('uncheck');
                });
                $("#price-list-request-btn").addClass('hide');
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                if (typeof jqXHR.responseJSON !== 'undefined') {
                    if (jqXHR.responseJSON.hasOwnProperty('form')) {
                        $('#form_body').html(jqXHR.responseJSON.form);
                    }
                } else {
                    alert('Error! ' + errorThrown);
                }
                hideLoader();
            });
});
$('.wrapper').delegate('a#addToCart', 'click', function (e) {
    e.preventDefault();
    var url = $(this).attr('href');
    console.log('Addingg to cart: ' + url);
    showLoader();
    $.get(url, function (data) {
        if (typeof data.response !== 'undefined') {
            $('#shoppingCart').html(data.response);
            $('#cartActionDlg').modal('show');
            $('#message').html(data.message);
            hideLoader();
        } else
            console.log('An error occured');
    });
});
$('#merchantList').on('click', '#merchantLink a', function (e) {
    e.preventDefault();
    var url = $(this).attr('href');
    console.log('loading merchant products: ' + url);

    showLoader();
    $.get(url, function (data) {
        if (typeof data.response !== 'undefined') {
            $('#productList').html(data.response);
            hideLoader();
        } else
            console.log('An error occured');
    });
});
$('#region').change(function () {
    var slug = $(this).attr('value').val();
    alert('Selected RegionId: ' + slug);
    var url = Routing.generate('single_store_action', {slug: slug});
    $.get(url, function (html) {
        $('#merchantList').replaceWith(
                $(html).find('#merchantList')
                );
    });

});
//#######################  REMOVE ITEM FROM CART ############################
$('#cart-page').delegate('a.removeItem', 'click', function (e) {
    e.preventDefault();
    var url = $(this).attr('href');
    console.log('removing product from cart: ' + url);
    showLoader();
    $.get(url, function (data) {
        refreshCart(data);
    });
});
//######################## UPDATE CART FORM SUBMIT ACTION ######################
function refreshCart(data) {
    if (typeof data.response !== 'response') {
        $('#shoppingCart').html(data.response);//Update top header cart
        if (typeof data.response !== 'cartView') {//Update the view cart page
            $("#cartView").html(data.cartView);
            $('#cart-feedback').fadeIn(3000, function () {});
            $('#cart-feedback').html(data.message);
            $('#cart-feedback').fadeOut(2000, function () {});
        }
        hideLoader();
    } else
        alert('An error occured');

}

$('#cartView').delegate('#updateCartForm', 'submit', function (e) {
    e.preventDefault();
    showLoader();
    $.ajax({
        type: $(this).attr('method'),
        url: $(this).attr('action'),
        data: $(this).serialize()
    })
            .done(function (data) {
                refreshCart(data);
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                if (typeof jqXHR.responseJSON !== 'undefined') {
                    if (jqXHR.responseJSON.hasOwnProperty('form')) {
                        $('#form_body').html(jqXHR.responseJSON.form);
                    }
                } else {
                    alert('Error! ' + errorThrown);
                }
                hideLoader();
            });
});

//#################################### Single Store View Sidebar Region Filter ############################
$("#regionList").on('change', '#region', function (e) {
    var slug = $(this).val();
    var url = Routing.generate('single_store_action', {slug: slug});
    showLoader();
    $.get(url, function (html) {
        $('#merchantsDiv').replaceWith($(html).find('#merchantsDiv'));
        hideLoader();
    });
});
//######################## Location Filter Region Value Chanage ########################################
$("#productList, .sidebar").on('change', '#app_location_filter_region', function (e) {
    // When category gets selected ...      
    // ... retrieve the corresponding form.
    var $form = $(this).closest('form');
    // Simulate form data, but only include the selected category value.
    var data = {};
    data[$(this).attr('name')] = $(this).val();
    // Submit data via AJAX to the form's action path.
    showLoader();
    $.ajax({
        url: $form.attr('action'),
        type: $form.attr('method'),
        data: data,
        success: function (html) {
            // Replace current town field ...            
            $('#app_location_filter_businessLocation').replaceWith(
                    // ... with the returned one from the AJAX response.
                    $(html).find('#app_location_filter_businessLocation')
                    );
            hideLoader();
        }
    });
});
$(".container").on('change', '#app_product_filter_region', function (e) {
    // When category gets selected ...      
    // ... retrieve the corresponding form.
    var $form = $(this).closest('form');
    // Simulate form data, but only include the selected category value.
    var data = {};
    data[$(this).attr('name')] = $(this).val();
    // Submit data via AJAX to the form's action path.
    showLoader();
    $.ajax({
        url: $form.attr('action'),
        type: $form.attr('method'),
        data: data,
        success: function (html) {
            // Replace current town field ...            
            $('#app_product_filter_businessLocation').replaceWith(
                    // ... with the returned one from the AJAX response.
                    $(html).find('#app_product_filter_businessLocation')
                    );
            hideLoader();
        }
    });
});
$('#productList,.sidebar').delegate('#locationFilterForm, #productFilterForm', 'submit', function (e) {
    e.preventDefault();
    showLoader();
    $.ajax({
        type: $(this).attr('method'),
        url: $(this).attr('action'),
        data: $(this).serialize()
    })
            .done(function (data) {
                renderServerResponse(data);
                hideLoader();
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                if (typeof jqXHR.responseJSON !== 'undefined') {
                    if (jqXHR.responseJSON.hasOwnProperty('form')) {
                        $('#form_body').html(jqXHR.responseJSON.form);
                    }
                } else {
                    alert('Error! ' + errorThrown);
                }
                hideLoader();
            });
});


function renderServerResponse(data) {
    $('#serverResponse').replaceWith($(data).find('#serverResponse'));
}
function showLoader() {
    $('#global-spinner').removeClass('hide');
}
function hideLoader() {
    $('#global-spinner').addClass('hide');
}
$('.search-button').on('click', '', function (e) {
    e.preventDefault();
    $('#searchForm').submit();
});
$(".breadcrumb-nav-holder, .animate-dropdown, .yamm megamenu-horizontal").on('click', 'a', function (e) {
    if ($(this).attr('href') !== "#")
        showLoader();
});
