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
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p class="erreur">', '</p>');
        
        $this->form_validation->set_rules('name', 'nom', 'required|min_length[3]|max_length[12]|encode_php_tags|xss_clean');
        
        if ( $this->form_validation->run() )
        {
            $name = $this->input->post('name');
            $data = array('nom' => $name, 'date' => time());
        
            if ( $id = $this->M_Quizz->setParticipant($data) )
                $this->quizzGame ($id); 
        }
        else 
        {        
            $dataList['type'] = 'start';
            $dataLayout['titre'] = 'Quizz';
            $dataLayout['vue'] = $this->load->view('quizz', $dataList, true);
            $this->load->view('layout', $dataLayout);
        }
    }
    
    public function quizzGame ( $id = 0 ) {
        
        $this->load->model('M_Quizz');
        $this->load->helper('form');     
        $this->load->library('form_validation');
                
        if ( $id )
            $user_id = $id;
        else 
            $user_id = $this->input->post('user_id');
        
        $questions = $this->M_Quizz->getListQuestion();       
        $this->form_validation->set_rules('choice', 'choix', 'required');
        
        if ( $this->form_validation->run() )
        {
            $numQuest = $this->input->post('numQuest') + 1;
            
            if ( $this->input->post('choice') == $this->input->post('answer') )
                $answer = 1;
            else
                $answer = 0;
            
            if ( count($questions) == $numQuest )
            {
                $status = 'fini';
                
                $goodAnswer = $this->M_Quizz->coundGoodAnswer($user_id);
                $this->M_Quizz->updateParticipant($user_id, $goodAnswer, $numQuest);
                
                $this->endGame($goodAnswer , $this->input->post('numQuest'));
            }
            else
            {
                $status = 'en cours';
            }
                
            $dataList['numQuest'] = $numQuest;
            $data = array('id_question' => $this->input->post('quest_id'), 'id_participant' => $user_id, 'reponse' => $answer, 'status' => $status );
            
            $this->M_Quizz->saveAnswer($data);
        }
        
        $dataList['questions'] = $questions;
        $dataList['user_id'] = $user_id;
        $dataList['type'] = 'quest';
        $dataLayout['titre'] = 'Quizz';
        $dataLayout['vue'] = $this->load->view('quizz', $dataList, true);
        $this->load->view('layout', $dataLayout);
    }
    
    public function endGame ($goodAnswer, $nbQuest) {
        
        $dataList['result'] = array('goodAnswer' => $goodAnswer, 'nbQuestion' => $nbQuest);
        $dataList['type'] = 'end';
        $dataLayout['titre'] = 'Quizz';
        $dataLayout['vue'] = $this->load->view('quizz', $dataList, true);
        $this->load->view('layout', $dataLayout);
    }
        
    public function lastUserQuizz () {
        
        $this->load->model('M_Quizz');
        
        return $this->M_Quizz->getLastUser();
        
    }
    
    // jeu de plateform
    
    public function ecoGame () {
        $dataLayout['titre'] = 'ecoGame';
        $dataList['type'] = 'ecoGame';
        $dataLayout['vue'] = $this->load->view('ecoGame', $dataList, true);
        $this->load->view('layout', $dataLayout);
    }
    
}

