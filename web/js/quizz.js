( function ( $ ) {

    "use strict";

    // -- variables globals

    
	
    // -- methods

    var getChoice = function ( e ) {
        
        var sKey = $(this).attr('for');
        
        var aQuestions = $.parseJSON(sQuestions);
        console.log(aQuestion[0][key]);
        
    }


    $( function () {

        // -- onload routines

        // Cacher les radio
        $('input[type=radio]').hide();
        $('input[type=submit]').hide();
        
        $('label').on('click', getChoice);
        
        

    } );

}( jQuery ) );
