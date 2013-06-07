<?php

    class M_Quizz extends CI_Model 
    {   
        // participant
        
        public function setParticipant ($data)
        {
            $this->db->insert('participants', $data);
            return $this->db->insert_id();;
        }

        // question
        
        public function getListQuestion ()
        {
            $query = $this->db->get('questionnaire');
            return $query->result_array();
        }        
        
        public function saveAnswer ($data) 
        {
            $this->db->insert('reponses', $data);
        }        
        
        public function coundGoodAnswer ($user_id)
        {
            $req = "SELECT count(id) FROM reponses WHERE id_participant = ".$user_id." AND reponse = 1 ;";
            $query = $this->db->query($req);
            $nb = $query->result_array();
            
            return $nb[0]['count(id)'];
        }
        
        public function updateParticipant ($user_id, $goodAnswer, $numQuest)
        {
            $this->db->where('id', $user_id);
            $this->db->update('participants', array('bonne_reponse' => $goodAnswer, 'total_quest' => $numQuest));
        }
        
        public function getLastUser () {
            
            $req = "SELECT * FROM participants WHERE `bonne_reponse` != NULL ORDER BY `id` DESC LIMIT 0 , 5;";
            $query = $this->db->query($req);
            $lastUser = $query->result_array();            
            
            return $lastUser;
            
        }
        
    }

?>
