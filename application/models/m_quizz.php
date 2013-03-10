<?php

    class M_Quizz extends CI_Model {
        
        // users 
        
        public function checkUser ($data) 
        {            
            $query = $this->db->get_where('users', array('name' => $data['name'], 'pwd' =>$data['pwd']));            
            return $query->row();            
        }
        
        public function removeUser ( $id ) {

        if ( $this->db->delete('users', array('id' => $id)) )
            return TRUE;
        }
        
        public function addUser ($data)
        {
            $this->db->insert('users', $data);
            return true;
        }
        
        public function getListUsers () 
        {
            $query = $this->db->get('users');
            return $query->result();
        }
        
        public function getUser($id) 
        {
            $query = $this->db->get_where('users', array('id' => $id));
            return $query->row();
        }  
        
        public function updateUser ($data) 
        {
            $this->db->where('id', $data['id']);
            $this->db->update('users', array('name' => $data['name'], 'mail' => $data['mail'], 'pwd' => $data['pwd']));
            return TRUE;
        }        
        
        // question
        
        public function getListQuestion ()
        {
            $query = $this->db->get('questionnaire');
            return $query->result();
        }
        
        public function addQuestion ($data)
        {
            $this->db->insert('questionnaire', $data);
            return true;
        }
        
        public function updateQuestion ($data) {
            $this->db->where('id', $data['id']);
            $this->db->update('questionnaire', array('question' => $data['question'], 'choice_1' => $data['choice1'], 'choice_2' => $data['choice2'], 'choice_3' => $data['choice3'], 'answer' => $data['answer']));
            return TRUE;
        }
        
    }


?>
