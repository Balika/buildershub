/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
(function ($, window, document, undefined) {
    'use strict';
    // init cubeportfolio   
    var allServicesContent = $("#allServices").children('div');        
    var allServices = $('#all-services-grid-container');   
    allServices.cubeportfolio({  
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
            this.updateSinglePage(allServicesContent.html());
        }
    });  
})(jQuery, window, document);



