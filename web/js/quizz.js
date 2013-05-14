( function ( $ ) {

    "use strict";

    // -- variables globals

    var aKey = new Array('question', 'choice_1', 'choice_2', 'choice_3', 'answer'),
        nNumQuest = 0,
        nResult = 0;   
        
    var soundUrl = urlSite + 'web/sound/quizz.wav',
        son = new Audio();             
        son.src = soundUrl;
        
    var repeatSong = 0;
    
    var cloud_1 = $('#nuage_1'),
        cloud_2 = $('#p_nuage'),
        cloudWay = $('#quizz').width(),
        cloud_1_Pos = 0,
        cloud_2_Pos = 165;
    
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
         
        if ( (nbQuestion - 1) == nNumQuest ) 
        {
            sStatus = 'fini';
            saveAnswerAjax( aQuestions[nNumQuest]['id'], nAnswer, sStatus );
            endGame();
        }
        else
        {
            sStatus = 'en cours';
            saveAnswerAjax( aQuestions[nNumQuest]['id'], nAnswer, sStatus );
            nextQuestion( aQuestions );
        }        
    }

    var saveAnswerAjax = function ( id_quest, nAnswer, sStatus ) {
        
        jQuery.ajax({
		type: "POST",
		url: url_quizz,
		data: {"user_id" : nUser, "id_quest" : id_quest, "answer" : nAnswer, "status" : sStatus, "type" : "answer"},
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
         
         var msg;
         
         if ( nResult > '10' )
             msg = "Félicitation tu as terminer le quizz avec un total de ";
         else 
             msg = "Désole mais tu as terminer le quizz avec un total de ";
         
         $('#quizz form').remove();
         $('<p></p>').text(msg).appendTo('#quizz').append('<em>'+ ( nResult - 1 ) + "/" + nNumQuest +'</em>');
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
         
        var i = 0;
        repeatSong = setInterval(function(){
                  console.log(i);
                  i = i + 1;                      
                  son.play();
        }, 315000 );
        
        son.play();
         
     }
 
     function animeCloud () {
         
         /*var tmp = 0 - cloud_1.width();
         
         if ( tmp == cloud_1_Pos )
             console.log('connerie');
         else
             console.log('c\'est bon');*/
         
         if ( cloud_1_Pos < cloudWay )
         {
            cloud_1_Pos = cloud_1_Pos + 5;
            cloud_1.animate({"left": cloud_1_Pos, "top" : "0"}, "slow");
         }
         else
         {
             cloud_1_Pos = 0 - cloud_1.width();
             cloud_1.animate({"top": "-100"}, "fast", function () {
                cloud_1.animate({"left": cloud_1_Pos}, "fast");
             });
         }
         
         if ( cloud_2_Pos < cloudWay )
             cloud_2_Pos = cloud_2_Pos + 4;
         else
             cloud_2_Pos = 0 - cloud_2.width();
             
         
         cloud_2.animate({"left": cloud_2_Pos}, "slow");
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
        
        animeCloud();   
        
        setInterval(animeCloud, 1);

    } );

}( jQuery ) );
