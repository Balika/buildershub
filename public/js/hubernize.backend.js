jQuery(function ($) {
    /** ###################################### START EQUIPMENT ACTION RELATED EVENTS ######################## **/
    var backendContent = "#backend-content";
    /**$(backendContent).on('click', '.equipment-table-actions a', function (e) {
     e.preventDefault();
     var url = $(this).attr('href');
     $('#advertiseForRentDlg').modal('show');
     $('#feedback-spinner').removeClass('hide');
     $.get(url, function (html) {
     $('#feedback-spinner').addClass('hide');
     $('#loaded-ad-form').replaceWith($(html).find('#loaded-ad-form'));
     });
     });*/
    /** ######################################### START REGION CHANGE EVENT ############################## **/
    var regionSelector = "#rental_ad_region";
    var townHolder = "#towns";
    $(backendContent).delegate(regionSelector, 'change', function (e) {
        // ... retrieve the corresponding form.
        e.preventDefault();
        var regionSelectorId = $(this).attr('id');
        var $form = $(this).closest('form');
        var data = {};
        data[$(this).attr('name')] = $(this).val();
        //var data = new FormData($form);
        // Submit data via AJAX to the form's action path.
        $(townHolder).prepend(loaderHTML);
        $.ajax({
            url: $form.attr('action'),
            type: $form.attr('method'),
            data: data,
            success: function (html) {
                $(loaderHolder).hide();
                updateTownList(html, regionSelectorId);
            }
        });
    });
    function updateTownList(html, regionSelectorId) {
        var selector = regionSelectorId.replace('region', 'town');
        var townSelectorId = "#" + selector;
        $(townSelectorId).replaceWith($(html).find(townSelectorId));
    }
    $('#rentalAdsTable').delegate('a#disable-ad-link, a#enable-ad-link', 'click', function (e) {
        e.preventDefault();
        var replacementId = '#rentalAdsData';
        var url = $(this).attr('href');
        var spinnerElement = $(this).find('i#spinner');
        showButtonLoader(spinnerElement);
        $.get(url, function (html) {
            hideButtonLoader(spinnerElement);
            $(replacementId).replaceWith($(html).find(replacementId));
        });

    })
    function showButtonLoader(element) {
        element.parent().addClass('disabled');
        element.addClass("fa-spinner fa-spin");
    }
    function hideButtonLoader(element) {
        element.removeClass("fa-spinner fa-spin");
        element.parent().removeClass('disabled');
    }
    //################################################ RENTAL REQUEST RELATED EVENTS ############################
    //+++++++++++++++++++++++++++++++++ Requests Accordion Paginated Events +++++++++++++++++++++++++++++++++++++
    var requestsHolderId = '#requestsAccordion';
    var selectedRequestHolder = '#selectedRequestHolder';
    $('#incomingRequests').delegate('div#requestsPaginator ul li a', 'click', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        showOverlay(requestsHolderId);
        $.get(url, function (html) {
            hideOverlay();
            $(requestsHolderId).replaceWith($(html).find(requestsHolderId));
        });
    });
    $('#incomingRequests, #requestDetailsPanel').delegate('p.requestDetailsHolder a, .request-list a', 'click', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        showOverlay(selectedRequestHolder);
        $.get(url, function (html) {
            hideOverlay();
            $(selectedRequestHolder).replaceWith($(html).find(selectedRequestHolder));
        });
    });
    $('#requestDetailsPanel').delegate('div#request-action p.action-list a', 'click', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        showOverlay(selectedRequestHolder);
        $.get(url, function (data) {
            hideOverlay();     
            $('#honourRentalRequestDlg').modal('show');
            $('#response').html('');
            $('#response').html(data.response);
        });
    });

    function hideOverlay() {
        $(loaderHolder).hide();
    }
    function showOverlay(selector) {
        $(selector).append(loaderHTML);
    }
});



