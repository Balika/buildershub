/** Non- Location Value Change events */
$(siteWrapper).delegate('#topLevelCategory', 'change', function (e) {
    e.preventDefault();
    var entityId = $(this).val();
    var route = $(this).attr('class');
    if (entityId > 0) {
        var replacementId = '.vertical-menu-list';
        var url = Routing.generate(route, {id: entityId});
        $(replacementId).prepend(loaderHTML);
        $.get(url, function (html) {
            $(loaderHolder).hide();
            $(replacementId).replaceWith($(html).find(replacementId));
        });
    }
});

$('.krystal-nav').delegate('#suppliersCombo', 'change',  function (e) {
    e.preventDefault();
    var entityId = $(this).val();
    var route = 'supplier_store_view';
    if (entityId !== 0) {
        var replacementId = '.block-section-1';
        var url = Routing.generate(route, {slug: entityId});
        $(replacementId).prepend(loaderHTML);
        window.location.href = url;
    }
});
var regionSelector = "#store_location_filter_region, #supplier_region, #firm_region, #property_filter_region";
var townSelectorId = "#towns";
$(siteWrapper).delegate(regionSelector, 'change', function (e) {
    // ... retrieve the corresponding form.
    var $form = $(this).closest('form');
    var regionSelectorId = $(this).attr('id');
    
    switch(regionSelectorId){
        case "supplier_region":
            townSelectorId = '#supplier_businessLocation';
            break;
        case "firm_region":
            townSelectorId = '#firm_businessLocation';
            break;
        case "property_filter_region":
            townSelectorId = '#property_filter_town';
            break;
        default:
            townSelectorId = "#towns";
    }
    
    var data = {};
    data[$(this).attr('name')] = $(this).val();
    //var data = new FormData($form);
    // Submit data via AJAX to the form's action path.
    //$(townSelectorId).prepend(loaderHTML);
    $.ajax({
        url: $form.attr('action'),
        type: $form.attr('method'),
        data: data,
        success: function (html) {
            updateTownList(html, regionSelectorId);
        }
    });
});
function updateTownList(html, regionSelectorId) {

    /**switch (regionSelectorId) {
     case 'firm_region':
     townSelectorId = "#firm_businessLocation";
     break;
     case 'supplier_region':
     var townSelectorId = "#supplier_businessLocation";
     break;
     case 'advertiser_region':
     var townSelectorId = "#advertiser_businessLocation";
     break;
     default:
     var selector = regionSelectorId.replace('region', 'businessLocation');
     console.log('selector: ' + selector);
     var townSelectorId = "#" + selector;
     break;
     }*/
    $(townSelectorId).replaceWith($(html).find(townSelectorId));
}
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
//################################### START SHOPPING CART RELATED REQUESTS ##########################
var cartContainer = "#cartContainer";
var shoppingCart = "#shoppingCart";
var headerCart = '#headerCart';
$(cartContainer).on('click', '.cart-actions a, .order-summary a, .tb-remove a', function (e) {
    e.preventDefault();
    var id = $(this).attr('id');
    var url = $(this).attr('href');
    
    if (id === 'confirm-empty') {
        $('#confirmEmpty').attr('href', url);
        return;
    } else if (id === 'confirm-checkout') {
        $('#confirmCheckout').attr('href', url);
        return;
    }
    if (id === 'confirmCheckout' || id === 'confirmEmpty' || id === 'removeItem') {
        $(shoppingCart).prepend(loaderHTML);
        switch (id) {
            case 'confirmCheckout':
                window.location.href=url;
                //location.reload();                
                break;
            case 'confirmEmpty':
            case 'updateCart':
            case 'removeItem':
                $.get(url, function (html) {
                    $(loaderHolder).hide();
                    $(shoppingCart).replaceWith($(html).find(shoppingCart));
                    updateHeaderCart(html);
                });
                break;
            default:
                break;
        }
    } else {
        return;
    }
});
/** +++++++++++++++++++++++++++++++++++++++++++++++  Submit Shopping Cart Form +++++++++++++++++++++++++++++++++*/
$(cartContainer).on('submit', 'form#cartForm', function (e) {
    e.preventDefault();
    $(shoppingCart).prepend(loaderHTML);
    $.ajax({
        type: $(this).attr('method'),
        url: $(this).attr('action'),
        data: $(this).serialize()
    })
            .done(function (data) {
                $(loaderHolder).hide();
                $(shoppingCart).replaceWith($(data).find(shoppingCart));
                updateHeaderCart(data);
            });
});
$(siteWrapper).on('submit', 'form.mqr-form', function (e) {
    $('#mqrDlg').modal('hide');
});

/** +++++++++++++++++++++++++++++++++++++ For all add to cart events accross the site +++++++++++++++++++++++++++++++++*/
$(siteWrapper).on('click', 'a.add-to-cart', function (e) {
    e.preventDefault();
    var url = $(this).attr('href');
    var spinnerElement = $(this).find('i#spinner');
    showButtonLoader(spinnerElement);
    $.get(url, function (html) {
        hideButtonLoader(spinnerElement);
        updateHeaderCart(html);
        $('#addToCartDlg').modal('show');
    });
});
function updateHeaderCart(html) {
    $(headerCart).replaceWith($(html).find(headerCart));
}
//################################### END SHOPPING CART RELATED REQUESTS ############################
//################################### ESTATE SEARCH FORM #################################
var collapsedText = "<strong><i class='fa fa-angle-right' ></i> Expand Search Form</strong>";
var expandedText = "<strong><i class='fa fa-angle-down' ></i> Collapse Search Form</strong>";
$(siteWrapper).on('click', '#toggleSearchForm', function (e) {
    var linkText = $(this).text();
    $('#searchForm').toggle('slow');
    if (linkText === ' Collapse Search Form') {
        $(this).html(collapsedText);
    } else {
        $(this).html(expandedText);
    }
});

$(siteWrapper).on('submit', '.mqr-form', function (e) {
    $('#mqr-form').prepend(loaderHTML);
});

/**
 * 
 * Product Comparison Scripts
 */
$('#headerCart').on('click', 'a#compare-products', function (e) {
    e.preventDefault();
    $('#productComparisonDlg').modal('show');
});
$('#supplier-call-to-action').on('click', 'a#send-message-link', function (e) {
    e.preventDefault();
    $('#supplierMessageDlg').modal('show');
});


function showButtonLoader(element) {
    element.addClass("fa-spinner fa-spin");
}
function hideButtonLoader(element) {
    element.removeClass("fa-spinner fa-spin");
}