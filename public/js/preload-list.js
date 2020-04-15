/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function () {   
    var institutionsUrl = Routing.generate('fetch_institutions');
    $.get(institutionsUrl, function (data) {              
        $("#education_institution").autocomplete({
            source: data.institutions
        });
        $("#education_certificateAwarded").autocomplete({
            source: data.diplomas
        });
        $("#education_programmeOfStudy").autocomplete({
            source: data.programmes
        });  
       /** $("#specialty_name").autocomplete({
            source: data.specialties
        });  */
    });
    
    var smartTags = [
        "ActionScript",
        "AppleScript",
        "Asp",
        "BASIC",
        "C",
        "C++",
        "Clojure",
        "COBOL",
        "ColdFusion",
        "Erlang",
        "Fortran",
        "Groovy",
        "Haskell",
        "Java",
        "JavaScript",
        "Lisp",
        "Perl",
        "PHP",
        "Python",
        "Ruby",
        "Scala",
        "Scheme"
    ];
    function split(val) {
        return val.split(/,\s*/);
    }
    function extractLast(term) {
        return split(term).pop();
    }
    $("#multipleTags")
            .bind("keydown", function (event) {
                if (event.keyCode === $.ui.keyCode.TAB &&
                        $(this).autocomplete("instance").menu.active) {
                    event.preventDefault();
                }
            })
            .autocomplete({
                minLength: 0,
                source: function (request, response) {
                    response($.ui.autocomplete.filter(
                            smartTags, extractLast(request.term)));
                },
                focus: function () {
                    return false;
                },
                select: function (event, ui) {
                    var terms = split(this.value);
                    terms.pop();
                    terms.push(ui.item.value);
                    terms.push("");
                    this.value = terms.join(", ");
                    return false;
                }
            });


});


