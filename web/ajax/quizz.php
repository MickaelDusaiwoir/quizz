<?php

    // on inclut les informations relatives à la base de données.
    include('../../application/config/database.php');
    
    if ( !isset($_POST['user_id']) )
    {
        echo 'ERROR: No user_id';
        exit(0);
    }
    
    if ( !isset($_POST['id_quest']) )
    {
        echo 'ERROR: No id_quest';
        exit(0);
    }
    
    if ( !isset($_POST['answer']) )
    {
        echo 'ERROR: No answer';
        exit(0);
    }
    
    if ( !isset($_POST['status']) )
    {
        echo 'ERROR: No status';
        exit(0);
    }
        
    $options = array (
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
	);

	try 
	{
		$connex = new PDO('mysql:host='.$db['default']['hostname'].';dbname='.$db['default']['database'], $db['default']['username'], $db['default']['password'], $options);
		$connex->query('SET CHARACTER SET UTF8');
		$connex->query('SET NAMES UTF8');

		// On ajout dans la base de donnée le concours qui vient d'être regarder en le liant à l'utilisateur par son id.
		$req = "INSERT INTO reponses (`id_participant`, `id_question`, `reponse`, `status`) ".
                       "VALUES(".$_POST['user_id'].", ".$_POST['id_quest'].", ".$_POST['answer'].", '".$_POST['status']."');";		
		
		if ( $connex->query($req) !== false )
			echo "SUCCESS";
		else
			echo 'ERROR:QUERY_FAILED';
	}
	catch (PDOException $e) 
	{
		die($e->getMessage());

		echo 'ERROR:NO_DATABASE';
	}    

?>
