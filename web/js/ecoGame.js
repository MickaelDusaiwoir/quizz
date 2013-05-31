( function ( $ ) {

    "use strict";

    // -- variables globals
    
    var canvas = document.getElementById('canvas'),
        context = canvas.getContext('2d'),
        canvasWidth = canvas.width,
        canvasHeight = canvas.height,
        posRight = true,   // regarde vers la droite   default  true
        posLeft = false,   // regarde vers la gauche   default  false
        running = false,   // ne court pas             default  false
        runRight = false,  // court vers la droite     default  false
        runLeft = false,   // court vers la gauche     default  false
        posX = 50,
        posY = 50,
        timer,
        jump = false,
        jumpSize = 100,
        initPosY = null,
        posFloorY = 50;
    
    // url 

    var path = 'web/img/ecoGame/';
    
    // wait sprite right
    
    var waitRight = new Image();
    waitRight.src = urlSite + path + 'waitRight.png';
    var waitRightTab = new Array(0,56,112,168,226,286,343,399,455,512,572,628,683,738,794);
    var waitRight_img = 0;
    
    // run sprite right
    
    var spriteRunRight = new Image();
    spriteRunRight.src = urlSite + path + 'runRight.png';
    var spriteRunRightTab = new Array(0,88,172,260,356,444,536,624);
    var spriteRunRight_img = 0;
    
    // wait sprite left
    
    var waitLeft = new Image();
    waitLeft.src = urlSite + path + 'waitLeft.png';
    var waitLeftTab = new Array(0,55,111,166,221,277,337,394,450,506,563,623,681,737,793);
    var waitLeft_img = 0;
    
    // run sprite right
    
    var spriteRunLeft = new Image();
    spriteRunLeft.src = urlSite + path + 'runLeft.png';
    var spriteRunLeftTab = new Array(0,84,166,256,350,442,528,620);
    var spriteRunLeft_img = 0;
	
    // -- methods
    
    function canvasSupport(){
        return Modernizr.canvas;  
    }

    function canvasApp(){

        if(!canvasSupport()){
            return;
        }
        
        // key down for move
        
        $(window).keydown(move);
        
        // key up for stopping move
        
        $(window).keyup(stopMove);
        
        // set timer animation
        
        timer = setInterval(animate, 100);
        
        // move 
        
        function move ( e ) {
            
            switch( e.keyCode )
            {
                // Arrow Left 
                
                case 37 :
                    posRight = false;
                    runRight = false;
                    posLeft = true;
                    runLeft = true;
                    running = true;
                    
                    if ( posX <= 50 )
                        posX = 50;
                    else
                        posX = posX - 6;
                        
                    break;
                    
                // Arrow Top
                
                case 38 :
                    
                    if ( initPosY == null )
                    {
                        initPosY = posY;
                        console.log(initPosY);
                    }
                    else 
                    {
                        console.log('erreur');
                    }
                    
                    break;
                    
                // Arrow Right
                
                case 39 :
                    posLeft = false;
                    runLeft = false;
                    posRight = true;
                    runRight = true;
                    running = true;
                    
                    if ( posX >= (canvasWidth - 100) )
                        posX = canvasWidth - 100;
                    else
                        posX = posX + 6;
                    
                    break; 
            }  
        }
        
        function stopMove ( e ) {
            
            switch( e.keyCode )
            {
                // Arrow Left 
                
                case 37 :
                    posRight = false;
                    runRight = false;
                    posLeft = true;
                    runLeft = false;
                    running = false;
                    break;
                    
                // Arrow Right
                
                case 39 :
                    posLeft = false;
                    runLeft = false;
                    posRight = true;
                    runRight = false;
                    running = false;
                    break;
            }   
        }
        
        function animate () {
            
            context.clearRect(0, 0, canvasWidth, canvasHeight);

            if ( posRight && running == false ) // anime wait right
            {
                if ( waitRight_img < waitRightTab.length ) 
                {
                    context.drawImage(waitRight, waitRightTab[waitRight_img], 0, 60, 88 , posX , canvasHeight -100 , 60 , 88);
                    waitRight_img = waitRight_img + 1;
                }
                else 
                {
                    context.drawImage(waitRight, waitRightTab[0], 0, 60, 88 , posX , canvasHeight -100 , 60 , 88);
                    waitRight_img = 1;
                }                
            }
            else if ( runRight && running ) // anime run right
            {
                if ( spriteRunRight_img < spriteRunRightTab.length ) 
                {
                    context.drawImage(spriteRunRight, spriteRunRightTab[spriteRunRight_img], 0, 82, 88 , posX , canvasHeight -100 , 82 , 88);
                    spriteRunRight_img = spriteRunRight_img + 1;
                }
                else 
                {
                    context.drawImage(spriteRunRight, spriteRunRightTab[0], 0, 82, 88, posX , canvasHeight -100 , 82 , 88);
                    spriteRunRight_img = 1;
                }  
            }            
            else if ( posLeft && running == false ) // anime wait left
            {
                if ( waitLeft_img < waitLeftTab.length ) 
                {
                    context.drawImage(waitLeft, waitLeftTab[waitLeft_img], 0, 60, 88 , posX , canvasHeight -100 , 60 , 88);
                    waitLeft_img = waitLeft_img + 1;
                }
                else 
                {
                    context.drawImage(waitLeft, waitLeftTab[0], 0, 60, 88 , posX , canvasHeight -100 , 60 , 88);
                    waitLeft_img = 1;
                }                
            }
            else if ( runLeft && running ) // anime run Left
            {
                if ( spriteRunLeft_img < spriteRunLeftTab.length ) 
                {
                    context.drawImage(spriteRunLeft, spriteRunLeftTab[spriteRunLeft_img], 0, 82, 88 , posX , canvasHeight -100 , 82 , 88);
                    spriteRunLeft_img = spriteRunLeft_img + 1;
                }
                else 
                {
                    context.drawImage(spriteRunLeft, spriteRunLeftTab[0], 0, 82, 88, posX , canvasHeight -100 , 82 , 88);
                    spriteRunLeft_img = 1;
                }  
            }    
        }
    }
    
    var loadSprite = function() {
        
        $(waitRight).load();
        $(spriteRunRight).load();
        $(waitLeft).load();
        $(spriteRunLeft).load();
    }

    $( function () {

        // -- onload routines
        loadSprite();
        canvasApp();
			
    } );

}( jQuery ) );
