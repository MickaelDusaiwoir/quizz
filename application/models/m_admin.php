<?php

    class M_Admin extends CI_Model {        
        
        // Global
            
        public function getOne ($id, $table)
        {
            $query = $this->db->get_where($table, array('id' => $id));
            return $query->row();
        }
        
        public function remove ($id, $table)
        {
            if ( $this->db->delete($table, array('id' => $id) ) )
                return TRUE;
            else
                return false;
        }     
        
        
        // users 
        
        public function checkUser ($data) 
        {            
            $query = $this->db->get_where('users', array('name' => $data['name'], 'pwd' =>$data['pwd']));            
            return $query->row();            
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
            $this->db->update('questionnaire', array('question' => $data['question'], 'choice_1' => $data['choice_1'], 'choice_2' => $data['choice_2'], 'choice_3' => $data['choice_3'], 'answer' => $data['answer']));
            return TRUE;
        }
        
        public function stats ($start, $end) 
        {
            // Nombre de joueur par jour.
            $req = 'SELECT count(id) FROM participants WHERE `date`>="'.$start.'" AND `date`<="'.$end.'";';
            $query = $this->db->query($req);
            $nbPlayer = $query->result_array();

            // Nombre de vues par jour.
            $req = 'SELECT count(id) FROM participants WHERE `date`>="'.$start.'" AND `date`<="'.$end.'" AND `status`="fini";';
            $query = $this->db->query($req);
            $nbFini = $query->result_array();
            
            // Score moyen
            $req = 'SELECT AVG(bonne_reponse) FROM participants WHERE `date`>="'.$start.'" AND `date`<="'.$end.'" AND `status`="fini";';
            $query = $this->db->query($req);
            $avgRep = $query->result_array();

            return array(
                'nbPlayer' => $nbPlayer[0]['count(id)'], 
                'nbFini' => $nbFini[0]["count(id)"],
                'avgRep' => $avgRep[0]['AVG(bonne_reponse)']
            ); 
        }       
        
    }


?>
