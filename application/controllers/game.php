<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Game extends CI_Controller {

    public function index() {
        $this->afficher();
    }
    
    // Global
    
    public function afficher() {

        $dataLayout['titre'] = 'Accueil';
        $dataLayout['vue'] = $this->load->view('home', NULL, true);
        $this->load->view('layout', $dataLayout);
    }
    
     public function callBack($data) 
    {
        $this->load->model('M_Admin');
        $this->load->helper('form');
        
        $dataLayout['titre'] = 'Administration - ' . $data['title'];
        $dataLayout['vue'] = $this->load->view($data['display'], $dataList, true);
        $this->load->view('layout', $dataLayout);
    }
    
    // QUIZZ
    
    public function quizz () {
        
        $this->load->helper('form');
        
        $dataList['type'] = 'start';
        $dataLayout['titre'] = 'Quizz';
        $dataLayout['vue'] = $this->load->view('quizz', $dataList, true);
        $this->load->view('layout', $dataLayout);
    }
    
    public function startQuizz () {
        
        $this->load->model('M_Quizz');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p class="erreur">', '</p>');
        
        $this->form_validation->set_rules('name', 'nom', 'required|min_length[3]|max_length[12]|encode_php_tags|xss_clean');
        
        if ( $this->form_validation->run() )
        {
            $name = $this->input->post('name');
            $data = array('nom' => $name, 'date' => time());
            
            if ( $this->M_Quizz->setParticipant($data) )
            {
                
                $this->quizzGame();
            }   
        }
        else 
        {
            $this->load->helper('form');        
            $dataList['type'] = 'start';
            $dataLayout['titre'] = 'Quizz';
            $dataLayout['vue'] = $this->load->view('quizz', $dataList, true);
            $this->load->view('layout', $dataLayout);
        }
    }
    
        
    
}

