<?php

    class M_Quizz extends CI_Model 
    {   
        // participant
        
        public function setParticipant ($data)
        {
            $this->db->insert('participants', $data);
            return TRUE;
        }

        // question
        
        public function getListQuestion ()
        {
            $query = $this->db->get('questionnaire');
            return $query->result();
        }        
    }


?>
