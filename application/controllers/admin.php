<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function connect() {
        if (!$this->session->userdata('logged_in')) {
            $this->load->helper('form');
            $this->load->library('session');

            $dataLayout['titre'] = 'Connection à l\'administartion';
            $dataLayout['vue'] = $this->load->view('login',null, true);
            $this->load->view('layoutAdmin', $dataLayout);
        } else {
            redirect('admin/listUsers');
        }
    }

    public function callBack($data) 
    {
        $this->load->model('M_Admin');
        $this->load->helper('form');

        switch ($data['display']) {
            case 'users' :
                $dataListe['donnees'] = $this->M_Admin->getListUsers();
                break;
            case 'questions' :
                $dataListe['donnees'] = $this->M_Admin->getListQuestion();
        }

        $dataListe['msg'] = $data['msg'];
        $dataListe['erreur'] = $data['erreur'];
        $dataLayout['titre'] = 'Administration - ' . $data['title'];
        $dataLayout['vue'] = $this->load->view($data['display'], $dataListe, true);
        $this->load->view('layoutAdmin', $dataLayout);
    }

    // Login + deconnection

    public function login() {
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->model('M_Admin');

        $erreur = FALSE;

        if (!$name = $this->input->post('name'))
            $erreur = TRUE;
        if (!$pwd = sha1($this->input->post('pwd')))
            $erreur = TRUE;

        if ($erreur == FALSE) {
            $dataUser = array('name' => $name, 'pwd' => $pwd);

            if ($res = $this->M_Admin->checkUser($dataUser)) {
                $this->session->set_userdata('logged_in', true);
                $this->session->set_userdata('id_user', $res->id);
                $this->session->set_userdata('status_user', $res->status);
                redirect('admin/listUsers');
            } else {
                $erreur = TRUE;
            }
        }

        $dataErreur['erreur'] = $erreur;
        $dataLayout['titre'] = 'Connection à l\'administartion';
        $dataLayout['vue'] = $this->load->view('login', $dataErreur, true);
        $this->load->view('layoutAdmin', $dataLayout);
    }

    public function disconnect() {
        $this->session->sess_destroy();
        redirect(base_url());
    }
    
    // Global 
    
    public function seeOne () 
    {       
        if ( $this->session->userdata('logged_in') ) 
        {            
            $this->load->model('M_Admin');
            $this->load->helper('form');
            
            $id = $this->uri->segment(3);
            $content = $this->uri->segment(4);

            switch ($content) 
            {
                case 'question':
                    $dataListe['donnees'] = $this->M_Admin->getOne($id, 'questionnaire');
                    $view = 'question';
                    $display = 'Modification d\'une question';
                    break;

                case 'user':
                    $dataListe['donnees'] = $this->M_Admin->getOne($id, 'users');
                    $view = 'user';
                    $display = 'Modification d\'un utilisateur';
                    break;
            }

            $dataLayout['titre'] = 'Administration - '.$display;
            $dataLayout['vue'] = $this->load->view($view, $dataListe, true);
            $this->load->view('layoutAdmin', $dataLayout);
        }
        else 
        {
            redirect('admin/login');
        }
    }
    
    public function confirme () 
    {
        if ( $this->session->userdata('logged_in') ) 
        {
            $id = $this->uri->segment(3);
            $content = $this->uri->segment(4);
            
            $dataListe['id']      = $id;
            $dataListe['content'] = $content;
            $dataLayout['titre']  = 'Administration - Confirmation';
            $dataLayout['vue']    = $this->load->view('confirme', $dataListe, true);
            $this->load->view('layoutAdmin', $dataLayout);
        }
        else 
        {
            redirect('admin/login');
        }
    }
    
    public function remove () 
    {
        if ( $this->session->userdata('logged_in') ) 
        {
            $id = $this->uri->segment(3);
            $content = $this->uri->segment(4);
            
            $this->load->model('M_Admin');
            
            $data = array('msg' => null, 'display' => '', 'title' => 'Utilisateur', 'erreur' => null);
           
            switch ($content) 
            {
                case 'user':
                    
                    $data['display'] = 'users';
                    
                    if ( $this->M_Admin->remove($id, 'users') ) 
                    {
                        if ( $this->session->userdata('id_user' ) == $id ) 
                            $this->disconnect();
                        
                        $data['msg'] = '<p class="success users">L\'utilisateur a étais supprimer avec success</p>';
                        $this->callBack($data);
                    } 
                    else 
                    {
                        $data['msg'] = "<p class='erreur users'>Une erreur est survenue, l'utilisateur n'a pas été supprimer</p>";
                        $this->callBack($data);
                    }
                    break;

                case 'question':
                    
                    $data['display'] = 'questions';
                    
                    if ( $this->M_Admin->remove($id, 'questionnaire') )
                    {
                        $data['msg'] = '<p class="success question">La question a étais supprimer avec success</p>';
                        $this->callBack($data);
                    }
                    else
                    {
                        $data['msg'] = '<p class="erreur">Une erreur est survenue, la question n\'a pas été supprimer</p>';
                        $this->callBack($data);
                    }                    
                    break;
            }            
        }
        else 
        {
            redirect('admin/login');
        }
    }

    // toute les fonctions se rapportant à l'utilisateur

    public function listUsers() {
        if (!$this->session->userdata('logged_in')) {
            redirect('admin/login');
        }

        $this->load->model('M_Admin');
        $this->load->helper('form');

        $dataListe['donnees'] = $this->M_Admin->getListUsers();
        $dataLayout['titre'] = 'Administration - Utilisateurs';
        $dataLayout['vue'] = $this->load->view('users', $dataListe, true);
        $this->load->view('layoutAdmin', $dataLayout);
    }

    public function addUser() {
        $data = array('msg' => null, 'display' => 'users', 'title' => 'Utilisateur', 'erreur' => null);

        $this->load->helper('form');
        $this->load->model('M_Admin');

        if (!$name = $this->input->post('name'))
            $erreur['name'] = TRUE;

        if (!$pwd = $this->input->post('pwd'))
            $erreur['pwd'] = TRUE;
        else
            $pwd = sha1($pwd);

        if (!$mail = $this->input->post('mail'))
            $erreur['mail'] = TRUE;

        if ($name !== '' && $pwd !== '' && $mail !== '') {
            $erreur = FALSE;
            $dataUser = array('name' => $name, 'pwd' => $pwd, 'mail' => $mail, 'status' => 'moderateur');

            if ($this->M_Admin->addUser($dataUser)) {
                $data['msg'] = '<p class="success users">La personne a été ajoutée</p>';
                $this->callBack($data);
            }
        } else {
            $data['erreur'] = $erreur;
            $this->callBack($data);
        }
    }

    public function updateUser() 
    {
        $this->load->model('M_Admin');
        $this->load->helper('form');
        $data = array('msg' => null, 'display' => 'users', 'title' => 'Utilisateur', 'erreur' => null);
        
        if ( !$name = $this->input->post('name') )
            $erreur['name'] = TRUE;

        if ( !$pwd = $this->input->post('pwd') )
            $erreur['pwd'] = TRUE;
        else
            $pwd = sha1($pwd);

        if ( !$mail = $this->input->post('mail') )
            $erreur['mail'] = TRUE;
        
        $id = $this->input->post('id_user');
        
        if ( $name !== '' && $pwd !== '' && $mail !== '' ) 
        {
            $erreur = FALSE;
            $dataUser = array('name' => $name, 'pwd' => $pwd, 'mail' => $mail, 'id' => $id);

            if ( $this->M_Admin->updateUser($dataUser) ) {
                $data['msg'] = '<p class="success users">La modification c\'est bien passée</p>';
                $this->callBack($data);
            }
        } 
        else 
        {
            $saveDataUser = array('name' => $name, 'pwd' => $pwd, 'mail' => $mail); 
            
            $dataListe['erreur'] = $erreur;
            $dataListe['save'] = $saveDataUser;
            $dataListe['donnees'] = $this->M_Admin->getOne($id, 'users');            
            $dataLayout['titre'] = 'Connection à l\'administartion';
            $dataLayout['vue'] = $this->load->view('user', $dataListe, true);
            $this->load->view('layoutAdmin', $dataLayout);
        }
    }

    // Fonction se rapportant au quizz

    public function getListQuestion() {
        $this->load->model('M_Admin');
        $this->load->helper('form');
        
        if ( !$this->session->userdata('logged_in') ) {
            redirect('admin/login');
        }

        $dataListe['donnees'] = $this->M_Admin->getListQuestion();
        $dataLayout['titre'] = 'Administration - Questionnaires';
        $dataLayout['vue'] = $this->load->view('questions', $dataListe, true);
        $this->load->view('layoutAdmin', $dataLayout);
    }
    
    public function addQuestion ()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('admin/login');
        }
        
        $data = array('display' => 'questions', 'title' => 'Question', 'msg' => null, 'erreur' => null);
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('quest',   ' Question',        'trim|required|encode_php_tags|xss_clean');
        $this->form_validation->set_rules('choice1', ' Proposition N°1', 'trim|required|encode_php_tags|xss_clean');
        $this->form_validation->set_rules('choice2', ' Proposition N°2', 'trim|required|encode_php_tags|xss_clean');
        $this->form_validation->set_rules('choice3', ' Proposition N°3', 'trim|required|encode_php_tags|xss_clean');
        $this->form_validation->set_rules('answer',  ' R&eacute;ponse',  'trim|required|encode_php_tags|xss_clean');
        
        if ( $this->form_validation->run() )
        {
           $this->load->model('M_Admin');
            
           $dataQuestion = array('question'  => $this->input->post('quest'),
                                 'choice_1'  => $this->input->post('choice1'),
                                 'choice_2'  => $this->input->post('choice2'),
                                 'choice_3'  => $this->input->post('choice3'),
                                 'answer'    => $this->input->post('answer')
            ); 
           
            if ( $this->M_Admin->addQuestion($dataQuestion) )
            {
                $data['msg'] = '<p class="success users">La question a été ajoutée</p>';
                $this->callBack($data);
            }
        }
        else
        {
            $this->callBack($data);
        }
    }   

     public function updateQuestion () 
    {
        if ( $this->session->userdata('logged_in') ) 
        {
            $data = array('display' => 'questions', 'title' => 'Questions', 'msg' => null, 'erreur' => null);
            
            $id = $this->input->post('id');
            
            $this->load->library('form_validation');
        
            $this->form_validation->set_rules('quest',   ' question',        'trim|required|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('choice1', ' proposition N°1', 'trim|required|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('choice2', ' proposition N°2', 'trim|required|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('choice3', ' proposition N°3', 'trim|required|encode_php_tags|xss_clean');
            $this->form_validation->set_rules('answer',  ' r&eacute;ponse',  'trim|required|encode_php_tags|xss_clean');
            
            if ( $this->form_validation->run() )
            {
                $this->load->model('M_Admin');
            
                $dataQuestion = array('question'  => $this->input->post('quest'),
                                      'choice_1'  => $this->input->post('choice1'),
                                      'choice_2'  => $this->input->post('choice2'),
                                      'choice_3'  => $this->input->post('choice3'),
                                      'answer'    => $this->input->post('answer'),
                                      'id'        => $id
                ); 
                
                if ( $this->M_Admin->updateQuestion($dataQuestion) )
                {
                    $data['msg'] = '<p class="success users">La question a été modifier</p>';
                    $this->callBack($data);
                }
            }
            else 
            {   
                $dataListe['donnees'] = $this->M_Admin->getUser($id);            
                $dataLayout['titre'] = 'Administartion - Modification d\'une question';
                $dataLayout['vue'] = $this->load->view('question', $dataListe, true);
                $this->load->view('layoutAdmin', $dataLayout);
            }
        }
        else 
        {
            redirect('admin/login');
        }
    }
    
    public function stats () {
        if ( $this->session->userdata('logged_in') ) 
        {
            $this->load->model('M_Admin');
        
            $today = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
            $start = $today - (86400 * 6);
            $end = $start + 86400;

            for ( $i = 0; $i < 7; $i++ )
            {
                $dataList['stats'][$i] = $this->M_Admin->stats($start, $end);
                $dataList['stats'][$i]['date'] = date('d-m-Y ', $start);

                $start += 86400;
                $end += 86400;
            }

            $dataLayout['titre'] = 'Administartion - Statistique';
            $dataLayout['vue'] = $this->load->view('stats', $dataList, true);
            $this->load->view('layoutAdmin', $dataLayout);
        }
        else 
        {
            redirect('admin/login');
        }
        
    }
    
}

?>
