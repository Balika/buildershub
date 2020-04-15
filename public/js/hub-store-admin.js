var loaderHTML = "<div class='overlay'><div class='overlay-content'><img src='" + ajaxLoader + "' alt='Loading...'/></div></div>";
var loaderHolder = ".overlay";
var asynContentHolder = "#asynPageContent";
var siteWrapper = "#backend-content";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var selectedCategories = [];
var selectedProducts = [];

var regionSelector = "#property_region";
var townSelectorId = "#towns";
$(siteWrapper).delegate(regionSelector, 'change', function (e) {
    // ... retrieve the corresponding form.
    var $form = $(this).closest('form');
    var regionSelectorId = $(this).attr('id');
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
     // Simulate form data, but only include the selected sport value.
    if (regionSelectorId === "propety_region") {
        console.log('Selected ID: ' + regionSelectorId);
        townSelectorId = '#propety_town';
    }
    $(townSelectorId).replaceWith($(html).find(townSelectorId));
}
$('#selectAll').on('ifChanged', function (event) {//Check and uncheck all products for price list request
    if (event.target.checked) {
        selectedCategories.length = 0;
        $("form#categoriesForm input").each(function () {
            $(this).iCheck('check');
        });
        $("#add-categories-btn").removeClass("hide");
    } else {
        selectedCategories.length = 0;
        $("#supplierCategoriesDlg input").each(function () {
            $(this).iCheck('uncheck');
        });
        $("#add-categories-btn").addClass('hide');
    }
});
$('form#categoriesForm input').on('ifChanged', function (event) {//Check and uncheck all products for price list request
    if (event.target.checked) {
        var item = $(this).attr('value');
        selectedCategories.push(item);
    } else {
        var item = $(this).attr('value');
        var index = selectedCategories.indexOf(item);
        selectedCategories.splice(index, 1);
        
    }
    if (selectedCategories.length > 0) {
        $("#add-categories-btn").removeClass("hide");
    } else {
        $("#add-categories-btn").addClass('hide');
    }
});
$('#categoriesForm, #promotedProductListForm').on('submit', function (e) {
    e.preventDefault();
    var formId = $(this).attr('id');
    var selectedIds = '';
    if (formId === 'categoriesForm') {
        selectedIds = selectedCategories.toString();
        $('input[name="selectedCategories"]').val(selectedIds);
        $("#supplierCategoriesDlg").modal('hide');
    } else {
        selectedIds = selectedProducts.toString();
        $('input[name="selectedProducts"]').val(selectedIds);
        $("#promotedProductListDlg").modal('hide');
    }
    console.log("selectedIds: " + selectedIds);
    showLoader();
    $.ajax({
        type: $(this).attr('method'),
        url: $(this).attr('action'),
        data: $(this).serialize()
    })
            .done(function (data) {
                // $('#vendorCategories').replaceWith($(data).find('#vendorCategories'));
                location.reload();
            });
});
//#################### Start Top Supplier Bid Functions ###########################
$('#topSupplierAllCategories').on('ifChanged', function (event) {//Check and uncheck all products for price list request
    if (event.target.checked) {
        selectedCategories.length = 0;
        $("form#topSupplierForm input").each(function () {
            $(this).iCheck('check');
        });
    } else {
        selectedCategories.length = 0;
        $("form#topSupplierForm input").each(function () {
            $(this).iCheck('uncheck');
        });
    }
    var selectedIds = selectedCategories.toString();
    $('input[name="selectedCategories"]').val(selectedIds);

});
$('form#topSupplierForm input').on('ifChanged', function (event) {//Check and uncheck all products for price list request
    if (event.target.checked) {
        var item = $(this).attr('value');
        selectedCategories.push(item);
    } else {
        var item = $(this).attr('value');
        var index = selectedCategories.indexOf(item);
        selectedCategories.splice(index, 1);
    }
    var selectedIds = selectedCategories.toString();
    $('input[name="selectedCategories"]').val(selectedIds);

});
//#################### End Top Supplier Bid Functions ###########################
/**
 * Select products for promotion
 */
$('#selectAllProducts').on('ifChanged', function (event) {//Check and uncheck all products for price list request   
    if (event.target.checked) {
        selectedProducts.length = 0;
        $("form#promotedProductListForm input").each(function () {
            $(this).iCheck('check');
        });
        $("#promote-products-btn").removeClass("hide");
    } else {
        selectedProducts.length = 0;
        $("form#promotedProductListForm input").each(function () {
            $(this).iCheck('uncheck');
        });

        $("#promote-products-btn").addClass('hide');
    }
});
$('form#promotedProductListForm input').on('ifChanged', function (event) {//Check and uncheck all products for price list request
    if (event.target.checked) {
        var item = $(this).attr('value');
        selectedProducts.push(item);
    } else {
        var item = $(this).attr('value');
        var index = selectedProducts.indexOf(item);
        selectedProducts.splice(index, 1);
    }
    if (selectedProducts.length > 0) {
        $("#promote-products-btn").removeClass("hide");
    } else {
        $("#promote-products-btn").addClass('hide');
    }
});
$('#entityForm').on('submit', 'form#optionsForm', function (e) {
    e.preventDefault();
    showLoader();
    $.ajax({
        type: $(this).attr('method'),
        url: $(this).attr('action'),
        data: $(this).serialize()
    })
            .done(function (data) {
                hideLoader();
                $('#feedbackDiv').replaceWith($(data).find('#feedbackDiv'));
                $('#feedback').fadeIn(3000, function () {});
                $('#feedbackDiv').fadeOut(5000, function () {});
            });
});
$('#entityForm').on('submit', 'form#equipmentForm, form#rentalAdForm', function (e) {
    e.preventDefault();
    showLoader();
    $.ajax({
        type: $(this).attr('method'),
        url: $(this).attr('action'),
        data: new FormData(this), //necessary to transport images via ajax
        processData: false,
        contentType: false
    })
            .done(function (data) {
                hideLoader();
                $('#feebackDlg').modal('show');
            });
});
var listingTypeHolder = "#property_listingTypeHolder";
$('.nav-tabs').on('click', 'a', function (e) {
    var clicked = $(this).attr('id');   
    if(clicked === "forSaleTab"){
        $(listingTypeHolder).val("For Sale");
    }else if(clicked === "forRentTab"){
         $(listingTypeHolder).val("For Rent");
    }  
});

//################################################ START BID PLACEMENT METHODS ####################################
/**var replacementId = "#response";
$('#bids').on('click', '#editBidLink', function (e) {
    e.preventDefault();
    $('#placeBidDlg').modal('show');
    $(replacementId).html('');
    $(replacementId).prepend(loaderHTML);
    var url = $(this).attr('href');   
    $.get(url, function (html) {
        $(loaderHolder).hide();
        $(replacementId).replaceWith($(html).find(replacementId));
    });
});*/
//################################################ END BID PLACEMENT METHODS ######################################
function showLoader() {
    $('#backendLoader').removeClass('hide');
}
function hideLoader() {
    $('#backendLoader').addClass('hide');
}
