$(siteWrapper).on('click', '#regions li a', function (e) {
    e.preventDefault();
    var replacementId = "#location-filter";
    var url = $(this).attr('href');
    $(replacementId).prepend(loaderHTML);
    $.get(url, function (html) {
        $(loaderHolder).hide();
        $(replacementId).replaceWith($(html).find(replacementId));
    });
})
$(siteWrapper).on('click', '#town-list a', function (e) {
    $("#filtered-results").prepend(loaderHTML);
    $("#picLocationDlg").modal('hide');
})
var regionSelector = "#store_location_filter_region, #supplier_region, #property_filter_region";
var townSelectorId = "#towns";
$(siteWrapper).delegate('#firm_region', 'change', function (e) {
    // ... retrieve the corresponding form.
    var $form = $(this).closest('form');
    var regionSelectorId = $(this).attr('id');  
    townSelectorId = '#firm_businessLocation';
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
            $(townSelectorId).replaceWith($(html).find(townSelectorId));
        }
    });
});
function updateTownList(html, regionSelectorId) {
    $(townSelectorId).replaceWith($(html).find(townSelectorId));
}
$('#subscribe-module').delegate('a#subscribe-to-equipt-module', 'click', function (e) {
     e.preventDefault();
     $('#subscribe-module').prepend(loaderHTML);
     var url = $(this).attr('href');
    $.get(url, function (html) {
        $(loaderHolder).hide();
        $('#subscribe-module').replaceWith($(html).find('#subscribe-module'));
    });
});

