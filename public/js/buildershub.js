var loaderHTML = "<div class='overlay'><div class='overlay-content'><img src='" + ajaxLoader + "' alt='Loading...'/></div></div>";
var blurredHTML = "<div class='overlay'><div class='overlay-content'></div></div>";

var loaderHolder = ".overlay";
var asynContentHolder = "#asynPageContent";
var closeSmartModal = ".smartforms-modal-close";
var selectedProfessionals = [];
var selectedProfessionalsNames = [];
var selectedArtisans = [];
var selectedArtisansNames = [];
(function ($) {
    "use strict";
//*##################################### START COMPANY RELATED FUNCTIONS #############################
//****************************** Handles Select Company Type Event ******************************
    var siteWrapper = "#site-wrapper";
    $('#companyTypesHolder').on('change', 'input[type="radio"]', function (e) {
        var replacementId = "#serverResponse";
        console.log(e.type);
        var type = $(this).val();
        var url = Routing.generate('add_company', {type: type});
        $(replacementId).prepend(loaderHTML);
        window.location.href = url;
        /**$.get(url, function (html) {
         
         $(loaderHolder).hide();
         $(replacementId).replaceWith($(html).find(replacementId));
         });*/
    });

//********************************* Company Region Change Event -- Fetches towns in region **************
    var regionSelector = "#work_region, #store_location_filter_region, #firm_region, #supplier_region, #project_region, #portal_location_filter_region, #advertiser_region, #user_userProfile_region, #location_filter_region, #app_user_user_profile_region";
    $(siteWrapper).delegate(regionSelector, 'change', function (e) {
        // ... retrieve the corresponding form.
        var $form = $(this).closest('form');
        var regionSelectorId = $(this).attr('id');
        // Simulate form data, but only include the selected sport value.
        var data = {};
        data[$(this).attr('name')] = $(this).val();
        //var data = new FormData($form);
        // Submit data via AJAX to the form's action path.
        console.log('URL: ' + $form.attr('action'));

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
        townSelectorId = "";
        switch (regionSelectorId) {
            case 'firm_region':
                townSelectorId = "#firm_businessLocation";
                break;
            case 'supplier_region':
                var townSelectorId = "#supplier_businessLocation";         
                break;
            case 'advertiser_region':
                var townSelectorId = "#advertiser_businessLocation";
                break;
            case 'store_location_filter_region':
                var townSelectorId = "#store_location_filter_businessLocation";
                break;
            default:
                var selector = regionSelectorId.replace('region', 'town');
                var townSelectorId = "#" + selector;              
                break;
        }
        $(townSelectorId).replaceWith($(html).find(townSelectorId));
    }
//##################################### START PUBLIC PROFILE PAGE FUNCTIONS #################################
    var headerPanel = '#coverPicturePanel';
    $(headerPanel).on('submit', '#profilePictureForm, #coverPictureForm, #locationForm', function (e) {
        $(headerPanel).prepend(loaderHTML);
    });

    //++++++++++++++++++++++++++++++++++++++++ Project Photos ++++++++++++++++++++++++++++++++++++
    $(siteWrapper).delegate('.projectPhotoLink', 'click', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var workTitle = $(this).attr('id');
        console.log("--------------------- projectPhotoLink clicked for " + workTitle + ' with Url: ' + url + " -----------------------");
        $('form.projectPhotoForm').attr('action', url);
        $('#projectTitle').text(workTitle);
        $('#projectPhotoDlg').modal('show');
    });
//##################################### END PUBLIC PROFILE PAGE FUNCTIONS ###################################
    var replacementId = "#signupForm";
    $(siteWrapper).on("change", '#userType', function (e) {
        var type = $(this).val();
        if (type !== "NA") {
            switch (type) {
                case 'supplier':
                    $("#signupForm").prepend(blurredHTML);
                    $("#supplier-dialog-btn").click();
                    return;
                case 'property':
                    $("#signupForm").prepend(blurredHTML);
                    $("#property-dialog-btn").click();
                    return;
                case 'firm':
                    $("#signupForm").prepend(blurredHTML);
                    $("#firm-dialog-btn").click();
                    return;
            }
            var url = Routing.generate('signup', {type: type});
            $(replacementId).prepend(loaderHTML);
            $.get(url, function (html) {
                $(loaderHolder).hide();
                $(replacementId).replaceWith($(html).find(replacementId));
            });
        } else {
            alert("Please select a registration type to continue");
             $("#signupForm").prepend(blurredHTML);
             return;
        }
    });

    //################################ Profile Engage ######################
    var collapsedText = "Show <i class='fa fa-angle-right' ></i>";
    var expandedText = "Hide <i class='fa fa-angle-down' ></i>";
    $(siteWrapper).delegate("a#showCommentsLink", 'click', function (e) {
        e.preventDefault();
        var linkText = $(this).text();
        $('#commentsPanel').toggle('slow');
        if (linkText === "Show ") {
            $(this).html(expandedText);
        } else {
            $(this).html(collapsedText);
        }
    });
    //+++++++++++++++++++++++++++++++++ User Personal Details Form Toggle +++++++++++++++++++++++++++++++++++++   
    $(siteWrapper).delegate("a#showFormLink", 'click', function (e) {
        e.preventDefault();
        var linkLabel = $(this).attr('href');
        var linkText = $(this).text();
        $('#formPanel').toggle('slow');
        if (linkText === linkLabel) {
            $(this).html("Hide Form <i class='fa fa-angle-down'></i>");
        } else {
            $(this).html(linkLabel + "<i class='fa fa-angle-right'></i>");
        }
    });
    $(siteWrapper).delegate("a#editPersonalData", 'click', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        $("#personalDataPanel").prepend(loaderHTML);
        $.get(url, function (html) {
            $(loaderHolder).hide();
            $("#formPanel").replaceWith($(html).find("#formPanel"));
            $("a#showFormLink").click();
        });
    });

    $(siteWrapper).delegate("#followLinks a", 'click', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        $("#engage-stats").prepend(loaderHTML);
        $.get(url, function (html) {
            $(loaderHolder).hide();
            $("#engage-stats").replaceWith($(html).find("#engage-stats"));
            $("#followLinks").replaceWith($(html).find("#followLinks"));
        });
    });

    //+++++++++++++++++++++++++++++++++++++++ Like Posts +++++++++++++++++++++++++++
    $(siteWrapper).delegate(".engageLikeLinks a", 'click', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var entityId = $(this).attr('id');
        var replacementId = "#engagePanel" + entityId;
        if ($.isNumeric(entityId) && entityId > 0) {
            $(replacementId).prepend(loaderHTML);
            $.get(url, function (html) {
                $(loaderHolder).hide();
                $(replacementId).replaceWith($(html).find(replacementId));
            });
        } else {
            return;
        }
    });
//############################################## START  USER ACCOUNT SETTINGS##########################################
    //++++++++++++++++++++++++++++++++++++++++ Password Reset Form Submit ++++++++++++++++++++++++++++++++++++
    $(siteWrapper).on('submit', 'form#passwordResetForm', function (e) {
        e.preventDefault();
        $('#password-reset').prepend(loaderHTML);
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: $(this).serialize()
        }).done(function (html) {
            $(loaderHolder).hide();
            $('#password-reset').replaceWith($(html).find("#password-reset"));
        });
    });
    //++++++++++++++++++++++++++++++++++++++++ User Personal Details Update - Specialty and Profession Category ++++++++++++++++++++++++++++++++++++
    $(siteWrapper).on('submit', 'form#specialtyForm', function (e) {
        e.preventDefault();
        $('#specialtyPanel').prepend(loaderHTML);
        $('#specialtyDlg').modal('hide');
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: $(this).serialize()
        }).done(function (html) {
            $(loaderHolder).hide();
            $('#specialtyPanel').replaceWith($(html).find("#specialtyPanel"));
        });
    });
    
    //+++++++++++++++++++++++++++++++++++++++++++ Builder Specialty Selections ++++++++++++++++++++++++++++++
    var selectedSpecialties = [];
    $('form#builderExpertiseForm input[type="checkbox"]').change(function () {//Check and uncheck all specialties of professional work
        if ($(this).is(':checked')) {
            var item = $(this).attr('value');
            selectedSpecialties.push(item);
        } else {
            var item = $(this).attr('value');
            var index = selectedSpecialties.indexOf(item);
            selectedSpecialties.splice(index, 1);
        }
        $('input[name="selectedSpecialties"]').val(selectedSpecialties.toString());
         
    });
    
    //+++++++++++++++++++++++++++++++++++++++++++ Builder Servcies Selections ++++++++++++++++++++++++++++++
    var selectedServiceCategories = [];
    $('form#builderExpertiseForm div#builderServicePanel input[type="checkbox"]').change(function () {//Check and uncheck all specialties of professional work
        if ($(this).is(':checked')) {
            var item = $(this).attr('value');
            selectedServiceCategories.push(item);
        } else {
            var item = $(this).attr('value');
            var index = selectedServiceCategories.indexOf(item);
            selectedServiceCategories.splice(index, 1);
        }
        $('input[name="selectedServiceCategories"]').val(selectedServiceCategories.toString());
        
    });
    /** ++++++++++++++++++++++++++++++ Project related events +++++++++++++++++++++++++++++++++++++++**/
    $(siteWrapper).on('change', '#artisanPanel input[type="checkbox"]', function () {//Check and uncheck all specialties of professional work
        if ($(this).is(':checked')) {
            var item = $(this).attr('value');
            selectedArtisans.push(item);
            selectedArtisansNames.push($(this).attr('class'));
        } else {
            var item = $(this).attr('value');
            var index = selectedArtisans.indexOf(item);
            selectedArtisans.splice(index, 1);
            selectedArtisansNames.splice(index, 1);
        }
        $('input[name="artisanCategories"]').val(selectedArtisans.toString());
    });
    $(siteWrapper).on('change', '#professionalPanel input[type="checkbox"]', function () {//Check and uncheck all specialties of professional work
        if ($(this).is(':checked')) {
            var item = $(this).attr('value');
            selectedProfessionals.push(item);
            selectedProfessionalsNames.push($(this).attr('class'));
        } else {
            var item = $(this).attr('value');
            var index = selectedProfessionals.indexOf(item);
            selectedProfessionals.splice(index, 1);
            selectedProfessionalsNames.splice(index, 1);
        }
        $('input[name="professionalCategories"]').val(selectedProfessionals.toString());
    });
    $(siteWrapper).on('click', '#inpage-login-dialog-trigger', function (e) {
        e.preventDefault();
        $('#inpage-login-dialog-btn').click();
    });
    $(siteWrapper).on('submit', 'form#inpageLoginForm', function (e) {
        e.preventDefault();
        $('#inpageLoginForm').prepend(loaderHTML);
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: $(this).serialize()
        }).done(function (html) {
            $(loaderHolder).hide();
            $(closeSmartModal).click();
            $('#user-details').replaceWith($(html).find("#user-details"));
        });
    });
    //################################################ START COMPANY ACCOUNT EVENTS #####################################
    //++++++++++++++++++++++++++++++++++++++++++++++++ View Comapny Page: Company Panel Info link click events. This shows a textarea for input+++++++++++++
    hideInputPanels('#none');
    $('#companyInfoPanel').delegate('a', 'click', function (e) {
        e.preventDefault();
        var linkId = $(this).attr('id');
        switch (linkId) {
            case 'editSummary':
                hideInputPanels('#summaryPanel');
                break;
            case 'editHistory':
                hideInputPanels('#historyPanel');
                break;
            case 'editVision':
                hideInputPanels('#visionPanel');
                break;
            case 'editMission':
                hideInputPanels('#missionPanel');
                break;
            default:
                hideInputPanels('#none');
                break;
        }

    });
    $('#companyInfoPanel').delegate('.frm-row a', 'click', function (e) {
        e.preventDefault();
        var formRow = $(this).parent('div').parent('div');
        cancelForm(formRow);
    })
    function hideInputPanels(exception) {
        $('#companyInfoPanel').find('div.frm-row').addClass('hide');
        $(exception).removeClass('hide');
        $('.acc_content').find('p').removeClass('hide');
        $(exception).parent('div').find('p').addClass('hide');
    }
    function cancelForm(formRow) {
        formRow.addClass('hide');
        formRow.parent('div').find('p').removeClass('hide');
    }
    $(siteWrapper).on('submit', 'form#firmForm', function (e) {
        e.preventDefault();
        $('.frm-row').prepend(loaderHTML);
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: $(this).serialize()
        }).done(function (html) {
            $(loaderHolder).hide();
            hideInputPanels('#none');//hide form input panels without exception           
            if (html.response !== undefined) {
                $(html.activeAccordion).html(html.response);
            } else {
                $(html.activeAccordion).replaceWith($(html).find(html.activeAccordion));
            }
        });
    });

//+++++++++++++++++++++++++++ Submit Company Service Form +++++++++++++++++++++++++++++++++++
    $(siteWrapper).on('submit', 'form#serviceForm', function (e) {
        e.preventDefault();
        $('#serviceForm').prepend(loaderHTML);
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: $(this).serialize()
        }).done(function (html) {
            $(loaderHolder).hide();
            $('#serviceOfferingHolder').replaceWith($(html).find('#serviceOfferingHolder'));
        });
    });

//################################################## END COMPANY ACCOUNT EVENTS ######################################
    //++++++++++++++++++++++++++++++ Invitation Response Events ++++++++++++++++++++++++++++++++++++
    $('form#responseForm input[type="radio"]').change(function () {//Check and uncheck all products for price list request
        var userType = $(this).attr('value');
        switch (userType) {
            case 'supplier':
                $("#responseFormPanel").addClass('hide');
                $("#supplier-dialog-btn").click();
                break;
            case 'property':
                $("#responseFormPanel").addClass('hide');
                $("#property-dialog-btn").click();
                break;
            default:
                $("#responseFormPanel").removeClass('hide');
                var title = "";
                if (userType === 'artisan') {
                    title = "Artisans / Draftmen Registration";
                } else if (userType === 'professional') {
                    title = "Technical Experts & Professionals Registration";
                } else if (userType === 'student') {
                    title = "Students in Construction Registration";
                } else if (userType === 'guest') {
                    title = "Property Owners & General Public  Registration";
                } else if (userType === 'firm') {
                    title = "Construction & Consulting Firms Registration";
                }
                $('#userTypeTitle').html(title);
                break;
        }
    });
    //++++++++++++++++++++++++++++++++++++++ Friends Invitation Form Submission ++++++++++++++++++++++++++++++++++
    $(siteWrapper).on('submit', 'form#inviteFriendsForm', function (e) {
        e.preventDefault();
        $('#inviteFriendsForm').prepend(loaderHTML);
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: $(this).serialize()
        }).done(function (html) {
            $(loaderHolder).hide();
            $(closeSmartModal).click();
            alert(html.message);
        });
    });
//############################################## UTIL EVENTS ###############################################################
    //+++++++++++++++++++++++++++++++++++ This code block will trigger the smart form close event+++++++++++++++++++++++++++
    $(siteWrapper).on('click', '#cancelSmartModal', function (e) {
        $(closeSmartModal).click();
    });

//############################################# END ACCOUNT SETTINGS ################################################
})(jQuery);



    