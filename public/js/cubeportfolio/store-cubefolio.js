/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
(function ($, window, document, undefined) {
    'use strict';
    // init cubeportfolio
    var mqrForm = $('#mqr-modal').children('div');
    var mqr = $('#mqr-grid-container');
    mqr.cubeportfolio({  
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
            $('#mrqPopLink').addClass('hide');
            this.updateSinglePage(mqrForm.html());
        },
        close: function(){
            $('#mrqPopLink').removeClass('hide')
        }
    });  
    
})(jQuery, window, document);



