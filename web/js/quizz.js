( function ( $ ) {

    "use strict";

    // -- variables globals

    var aKey = new Array('question', 'choice_1', 'choice_2', 'choice_3', 'answer'),
        nNumQuest = 0,
        nResult = 0,
        nTotalQuest = 0;   
        
    var soundUrl = urlSite + 'web/sound/quizz.wav',
        son = new Audio();             
        son.src = soundUrl;
        
    var repeatSong = 0;
    
    var cloud_1 = $('#nuage_1'),
        cloud_2 = $('#p_nuage'),
        cloudWay = $('#quizz').width(),
        cloud_1_Pos = 0,
        cloud_2_Pos = 165;
        
    var cloud_1_visible = true,
        cloud_2_visible = true;
    
    // -- methods

    var getChoice = function ( e ) {
        
        var sChoice = $(this).attr('for'),
            aQuestions = JSON.parse(sQuestions),
            nAnswer,
            sStatus;
            
        // user_id id_quest reponse status
            
            
        if ( aQuestions[nNumQuest][aKey[4]] == aQuestions[nNumQuest][sChoice] ) 
        {
            nAnswer = 1;
            nResult ++;
        }
        else
        {
            nAnswer = 0;
        }
        
        var i = 0;
        var nbQuestion = 0;
        
        for ( i; i < i + 1; i++ )
        {
            if ( aQuestions[i] )
                nbQuestion = nbQuestion + 1;
            else
                break;
        }
        
        nTotalQuest = nbQuestion;
         
        if ( (nbQuestion - 1) == nNumQuest ) 
        {
            sStatus = 'fini';
            saveAnswerAjax( aQuestions[nNumQuest]['id'], nAnswer, sStatus );
            updateUser( nbQuestion, nResult, sStatus );
            endGame();
        }
        else
        {
            sStatus = 'en cours';
            saveAnswerAjax( aQuestions[nNumQuest]['id'], nAnswer, sStatus );
            nextQuestion( aQuestions );
        }        
    }

    var updateUser = function ( nQuest, nResult, sStatut ) {
        
        jQuery.ajax({
                type: "POST",
		url: url_quizz,
		data: { "user_id" : nUser, "num_quest" : nQuest, "result" : nResult, "status" : sStatut, "dir" : "update"},
		success: function (data) {
			console.log(data);
		}
        });
        
    }

    var saveAnswerAjax = function ( id_quest, nAnswer, sStatus ) {
        
        jQuery.ajax({
		type: "POST",
		url: url_quizz,
		data: {"user_id" : nUser, "id_quest" : id_quest, "answer" : nAnswer, "status" : sStatus, "dir" : "answer"},
		success: function (data) {
			console.log(data);
		}
	});        
    }

    var nextQuestion = function ( aQuestions ) {
        
        nNumQuest = nNumQuest + 1;
        
        $('#num_quest').text(nNumQuest + 1);
        $('#quest p').text( aQuestions[nNumQuest][aKey[0]] );
        $('#choice_1').prev().text( aQuestions[nNumQuest][aKey[1]] );
        $('#choice_2').prev().text( aQuestions[nNumQuest][aKey[2]] );
        $('#choice_3').prev().text( aQuestions[nNumQuest][aKey[3]] );  
    }
    
     var endGame = function () {
         
         var msg, sId;
         
         if ( nResult > '10' )
         {
             msg = "Félicitation tu as terminé le quizz avec un total de ";
             sId = 'good';
         }
         else 
         {
             msg = "Désole mais tu as terminé le quizz avec un total de ";
             sId = 'bad';
         }
         
         if ( nResult < 0 ) 
             nResult = 0;
         
         $('#quizz form').remove();
         $('<p></p>').attr('id', 'endQuizz').text(msg).appendTo('#quizz').append('<em id="'+sId+'">'+ nResult + "/" + nTotalQuest +'</em>');
     }
     
     var controlSound = function ( e ) {
         
         if ( $(this).attr('data-son') == 'play' )
         {
             $(this).attr('class','icon-volume-off').attr('data-son','stop');
             son.pause();
             son.currentTime = 0;
             clearInterval(repeatSong);
         }
         else
         {
              $(this).attr('class','icon-volume-up').attr('data-son','play'); 
              playedSound();
         }
         
     }
 
     var playedSound = function () {
         
        repeatSong = setInterval( playedSound, 240000 );
        
        console.log('son');
        
        son.play();
         
     }
 
     function animeCloud () {
                  
         if ( cloud_1_Pos < cloudWay )
         {
            if ( cloud_1_visible == true )
            {
                cloud_1_Pos = cloud_1_Pos + 5;
                cloud_1.animate({"left": cloud_1_Pos, "top" : "0"}, "slow");
            }
            else
            {
                cloud_1_Pos = cloud_1_Pos + 5;
                cloud_1.animate({"left": cloud_1_Pos, "top" : "-100"}, "slow");
                cloud_1_visible = true; 
            }
         }
         else
         {
             cloud_1_Pos = (0 - cloud_1.width()) -20 ;
             cloud_1.animate({"top": "-100"}, "fast", function () {
                cloud_1.animate({"left": cloud_1_Pos}, "fast");
             });
             
             cloud_1_visible = false;
         }
         
         
         if ( cloud_2_Pos < cloudWay )
         {
            if ( cloud_2_visible == true )
            {
                cloud_2_Pos = cloud_2_Pos + 4;
                cloud_2.animate({"left": cloud_2_Pos, "top" : "270"}, "slow");
            }
            else
            {
                cloud_2_Pos = cloud_2_Pos + 4;
                cloud_2.animate({"left": cloud_2_Pos, "top" : "600"}, "slow");
                cloud_2_visible = true; 
            }
         }
         else
         {
             cloud_2_Pos = (0 - cloud_2.width()) - 20 ;
             cloud_2.animate({"top": "600"}, "fast", function () {
                cloud_2.animate({"left": cloud_2_Pos}, "fast");
             });
             
             cloud_2_visible = false;
         }
     }
       
    $( function () {

        // -- onload routines

        // Cacher les radio sauf celui qui sert pour entrer dans le jeu
        $('input[type=radio]').hide();
        $('input[type=submit]').hide();
        $('#start input[type=submit]').show();
        $('label').on('click', getChoice);
        
        if ( playSound )
            playedSound();
              
        $('#son').on('click', controlSound);

        setInterval(animeCloud, 1);

    } );

}( jQuery ) );
