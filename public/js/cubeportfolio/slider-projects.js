/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
(function ($, window, document, undefined) {
    'use strict';
    // init cubeportfolio
    var singlePage = $('#js-singlePage-container').children('div');
    var contactFirmForm = $("#contactFirm").children('div');
    var postFormContent = $("#postFormHolder").children('div');
    var singleProduct = $('#js-singleProduct-container').children('div');
    var projectsPhotosHolder = $('#js-grid-slider-projects');
    var productsAdsHolder = $('#js-grid-slider-products');
    var ourServices = $('#service-grid-container');
    var contactFirm = $('#grid-container');
    var postForm = $('#post-grid-container');
    projectsPhotosHolder.cubeportfolio({
        layoutMode: 'slider',
        drag: true,
        auto: true,
        autoTimeout: 5000,
        autoPauseOnHover: true,
        showNavigation: true,
        showPagination: false,
        rewindNav: true,
        scrollByPage: false,
        gridAdjustment: 'responsive',
        mediaQueries: [{
                width: 1500,
                cols: 5
            }, {
                width: 1100,
                cols: 4
            }, {
                width: 800,
                cols: 3
            }, {
                width: 480,
                cols: 2
            }, {
                width: 320,
                cols: 1
            }],
        gapHorizontal: 0,
        gapVertical: 25,
        caption: 'overlayBottomReveal',
        displayType: 'fadeIn',
        displayTypeSpeed: 100,

        // lightbox
        lightboxDelegate: '.cbp-lightbox',
        lightboxGallery: true,
        lightboxTitleSrc: 'data-title',
        lightboxCounter: '<div class="cbp-popup-lightbox-counter">{{current}} of {{total}}</div>',

        // singlePage popup
        singlePageDelegate: '.cbp-singlePage',
        singlePageDeeplinking: true,
        singlePageStickyNavigation: true,
        singlePageCounter: '<div class="cbp-popup-singlePage-counter">{{current}} of {{total}}</div>',
        singlePageAnimation: 'fade',
        singlePageCallback: function (url, element) {
            // to update singlePage content use the following method: this.updateSinglePage(yourContent)
            var indexElement = $(element).parents('.cbp-item').index(),
                    item = singlePage.eq(indexElement);
            this.updateSinglePage(item.html());
        }
    });
    productsAdsHolder.cubeportfolio({
        layoutMode: 'slider',
        drag: true,
        auto: true,
        autoTimeout: 5000,
        autoPauseOnHover: true,
        showNavigation: true,
        showPagination: false,
        rewindNav: true,
        scrollByPage: false,
        gridAdjustment: 'responsive',
        mediaQueries: [{
                width: 1500,
                cols: 5
            }, {
                width: 1100,
                cols: 4
            }, {
                width: 800,
                cols: 3
            }, {
                width: 480,
                cols: 2
            }, {
                width: 320,
                cols: 1
            }],
        gapHorizontal: 0,
        gapVertical: 25,
        caption: 'overlayBottomReveal',
        displayType: 'fadeIn',
        displayTypeSpeed: 100,

        // lightbox
        lightboxDelegate: '.cbp-lightbox',
        lightboxGallery: true,
        lightboxTitleSrc: 'data-title',
        lightboxCounter: '<div class="cbp-popup-lightbox-counter">{{current}} of {{total}}</div>'
       
    });
    ourServices.cubeportfolio({
        layoutMode: 'slider',
        drag: true,
        auto: true,
        autoTimeout: 5000,
        autoPauseOnHover: true,
        showNavigation: true,
        gridAdjustment: 'responsive',
        showPagination: false,
        mediaQueries: [{
                width: 1500,
                cols: 5
            }, {
                width: 1100,
                cols: 4
            }, {
                width: 800,
                cols: 3
            }, {
                width: 480,
                cols: 2
            }, {
                width: 320,
                cols: 1
            }],
        gapHorizontal: 0
    });
    /**contactFirm.cubeportfolio({  
        drag: false,
        auto: false,
        autoTimeout: 5000,
        autoPauseOnHover: false,
        showNavigation: false,
        singlePageDelegate: '.cbp-singlePage',
        singlePageDeeplinking: false,
        singlePageStickyNavigation: true,
        singlePageCounter: '',
        singlePageAnimation: 'slide',
        singlePageCallback: function (url, element) {
            // to update singlePage content use the following method: this.updateSinglePage(yourContent)
            this.updateSinglePage(contactFirmForm.html());
        }
    });  */
    postForm.cubeportfolio({  
        drag: false,
        auto: false,
        autoTimeout: 5000,
        autoPauseOnHover: false,
        showNavigation: false,
        singlePageDelegate: '.cbp-singlePage',
        singlePageDeeplinking: false,
        singlePageStickyNavigation: true,
        singlePageCounter: '',
        singlePageAnimation: 'slide',
        singlePageCallback: function (url, element) {
            // to update singlePage content use the following method: this.updateSinglePage(yourContent)
            this.updateSinglePage(postFormContent.html());
        }
    });  
})(jQuery, window, document);



