( function ( $ ) {

    "use strict";

    // -- variables globals

    var aKey = new Array('question', 'choice_1', 'choice_2', 'choice_3', 'answer'),
        nNumQuest = 0;      
	
    // -- methods

    var getChoice = function ( e ) {
        
        var sChoice = $(this).attr('for'),
            aQuestions = JSON.parse(sQuestions),
            nAnswer,
            sStatus;
            
        // user_id id_quest reponse status
            
            
        if ( aQuestions[nNumQuest][aKey[4]] == aQuestions[nNumQuest][sChoice] ) 
            nAnswer = 1;
        else
            nAnswer = 0;
        
        if ( aQuestions.length == nNumQuest ) 
        {
            sStatus = 'fini';
            callAjax( aQuestions[nNumQuest]['id'], nAnswer, sStatus );
            endGame();
        }
        else
        {
            sStatus = 'en cours';
            callAjax( aQuestions[nNumQuest]['id'], nAnswer, sStatus );
            nextQuestion( aQuestions );
        }        
    }

    var callAjax = function ( id_quest, nAnswer, sStatus ) {
        
        jQuery.ajax({
		type: "POST",
		url: url_quizz,
		data: {"user_id" : nUser, "id_quest" : id_quest, "answer" : nAnswer, "status" : sStatus},
		success: function (data) {
			console.log(data);
		}
	});        
    }

    var nextQuestion = function ( aQuestions ) {
        
        nNumQuest = nNumQuest + 1;
        
        $('#quest span').text(nNumQuest + 1);
        $('#quest p').text( aQuestions[nNumQuest][aKey[0]] );
        $('#choice_1').prev().text( aQuestions[nNumQuest][aKey[1]] );
        $('#choice_2').prev().text( aQuestions[nNumQuest][aKey[2]] );
        $('#choice_3').prev().text( aQuestions[nNumQuest][aKey[3]] );  
    }
    
     var endGame = function () {
         
         
     }

    $( function () {

        // -- onload routines

        // Cacher les radio sauf celui qui sert pour entrer dans le jeu
        $('input[type=radio]').hide();
        $('input[type=submit]').hide();
        $('#start input[type=submit]').show();
        
        $('label').on('click', getChoice);

    } );

}( jQuery ) );
