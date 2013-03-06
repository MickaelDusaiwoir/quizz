<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Quizz extends CI_Controller {

    public function index() {
        $this->afficher();
    }

    public function afficher() {

        $dataLayout['titre'] = 'Accueil';
        $dataLayout['vue'] = $this->load->view('home');

        $this->load->view('layout', $dataLayout);
    }
}

