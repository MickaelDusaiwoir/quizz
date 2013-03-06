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

    public function callBack($data) {
        $this->load->model('M_Quizz');
        $this->load->helper('form');

        switch ($data['display']) {
            case 'users' :
                $dataListe['donnees'] = $this->M_Quizz->getListUsers();
                break;
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
        $this->load->model('M_Quizz');

        $erreur = FALSE;

        if (!$name = $this->input->post('name'))
            $erreur = TRUE;
        if (!$pwd = sha1($this->input->post('pwd')))
            $erreur = TRUE;

        if ($erreur == FALSE) {
            $dataUser = array('name' => $name, 'pwd' => $pwd);

            if ($res = $this->M_Quizz->checkUser($dataUser)) {
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
        redirect('quizz/afficher');
    }

    // toute les fonctions se rapportant à l'utilisateur

    public function listUsers() {
        if (!$this->session->userdata('logged_in')) {
            redirect('admin/login');
        }

        $this->load->model('M_Quizz');
        $this->load->helper('form');

        $dataListe['donnees'] = $this->M_Quizz->getListUsers();
        $dataLayout['titre'] = 'Administration - Utilisateurs';
        $dataLayout['vue'] = $this->load->view('users', $dataListe, true);
        $this->load->view('layoutAdmin', $dataLayout);
    }

    public function addUser() {
        $data = array('msg' => null, 'display' => 'users', 'title' => 'Utilisateur', 'erreur' => null);

        $this->load->helper('form');
        $this->load->model('M_Quizz');

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

            if ($this->M_Quizz->addUser($dataUser)) {
                $data['msg'] = '<p class="success users">La personne a été ajoutée</p>';
                $this->callBack($data);
            }
        } else {
            $data['erreur'] = $erreur;
            $this->callBack($data);
        }
    }

    public function seeUser() {
        $this->load->helper('form');
        $this->load->model('M_Quizz');

        $id = $this->uri->segment(3);
        $dataListe['donnees'] = $this->M_Quizz->getUser($id);
        $dataLayout['titre'] = 'Administration - Fichie de ' . $dataListe['donnees']->name;
        $dataLayout['vue'] = $this->load->view('user', $dataListe, true);
        $this->load->view('layoutAdmin', $dataLayout);
    }

    public function updateUser() 
    {
        $this->load->model('M_Quizz');
        $this->load->helper('form');
        $data = array('msg' => null, 'display' => 'users', 'title' => 'Utilisateur', 'erreur' => null);
        
        if (!$name = $this->input->post('name'))
            $erreur['name'] = TRUE;

        if (!$pwd = $this->input->post('pwd'))
            $erreur['pwd'] = TRUE;
        else
            $pwd = sha1($pwd);

        if (!$mail = $this->input->post('mail'))
            $erreur['mail'] = TRUE;
        
        $id = $this->input->post('id_user');
        
        if ($name !== '' && $pwd !== '' && $mail !== '') 
        {
            $erreur = FALSE;
            $dataUser = array('name' => $name, 'pwd' => $pwd, 'mail' => $mail, 'id' => $id);

            if ($this->M_Quizz->updateUser($dataUser)) {
                $data['msg'] = '<p class="success users">La modification c\'est bien passée</p>';
                $this->callBack($data);
            }
        } 
        else 
        {
            $saveDataUser = array('name' => $name, 'pwd' => $pwd, 'mail' => $mail); 
            
            $dataListe['erreur'] = $erreur;
            $dataListe['save'] = $saveDataUser;
            $dataListe['donnees'] = $this->M_Quizz->getUser($id);            
            $dataLayout['titre'] = 'Connection à l\'administartion';
            $dataLayout['vue'] = $this->load->view('user', $dataListe, true);
            $this->load->view('layoutAdmin', $dataLayout);
        }
    }

    public function removeUser() {
        $this->load->helper('form');
        $this->load->model('M_Quizz');

        $data = array('msg' => null, 'display' => 'users', 'title' => 'Utilisateur', 'erreur' => null);
        $id = $this->uri->segment(3);

        if ($this->M_Quizz->removeUser($id)) {
            if ($this->session->userdata('id_user') == $id) {
                $this->disconnect();
            }

            $data['msg'] = '<p class="success users">L\'utilisateur a étais supprimer avec success</p>';
            $this->callBack($data);
        } else {
            $data['msg'] = "<p class='erreur users'>Une erreur est survenue, l'utilisateur n'a pas été supprimer</p>";
            $this->callBack($data);
        }
    }

    // Fonction se rapportant au quizz

    public function getListQuestion() {
        $this->load->model('M_Quizz');
        $this->load->helper('form');
        
        if (!$this->session->userdata('logged_in')) {
            redirect('admin/login');
        }

        $dataListe['donnees'] = $this->M_Quizz->getListQuestion();
        $dataLayout['titre'] = 'Administration - Questionnaire';
        $dataLayout['vue'] = $this->load->view('question', $dataListe, true);
        $this->load->view('layoutAdmin', $dataLayout);
    }

}

?>
