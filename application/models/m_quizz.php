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
        
        
        
        // question
        
        public function getListQuestion ()
        {
            $query = $this->db->get('questionnaire');
            return $query->result();
        }
        
    }


?>
