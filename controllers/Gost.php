<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Gost
 *
 * @author Windows 10
 */
class Gost extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model("Cooperation");
        $this->load->model("DemoVideos");
        $this->load->model("LocationPictures");
        $this->load->model("Organizer");
        $this->load->model("Users");
    }
    
    public function printPage($page) {
        $currentPage="homepageStylesheet.css";
        $this->load->view("templates/headerGost.php", ["currentPage"=>$currentPage]);
        $this->load->view("index.php");
        $this->load->view("templates/footer.php");
    }
    
    public function index() {
        $this->printPage("index.php");
    }
    
    public function registracija() {
        $currentPage="loginStylesheet.css";
        $this->load->view("templates/headerGost.php", ["currentPage"=>$currentPage]);
        $this->load->view("signUpPage.php");
        $this->load->view("templates/footer.php");
    }
    
    public function login($poruka=null) {
        $currentPage="loginStylesheet.css";
        $this->load->view("templates/headerGost.php", ["currentPage"=>$currentPage]);
        $this->load->view("loginPage.php");
        $this->load->view("templates/footer.php");
    }
    
    public function registrujSe() {
        $name=$this->input->post("Name");
        $user=$this->input->post("Username");
        $pass=$this->input->post("Password");
        $radioVal = $_POST["optradio"];
        $tip=2;
        $active=1;
        $tipUser;
        if($radioVal == "musician") {
           $tipUser="Musician";
        }
        else if ($radioVal == "organizer") {
            $tipUser="Organizer";
        }
        $this->Users->newUser($name, $user, $pass, $tip, $tipUser, $active);
        redirect("Gost/index");
    }
    
    //metoda koja se poziva klikom na submit forme za logovanje
    public function ulogujSe(){
        $this->form_validation->set_rules("username", "Korisnicko_ime", "required");
        $this->form_validation->set_rules("password", "Lozinka", "required");
        $this->form_validation->set_message("required","Polje {field} je ostalo prazno.");
        if ($this->form_validation->run()) {
            if (!$this->Users->dohvatiUsera($this->input->post('username'))) {
                $this->login("Neispravno korisnicko ime!");
            } else if (!$this->Users->ispravanPassword($this->input->post('password'))) {
                $this->login("Neispravna lozinka!");
            } else {
                $user=$this->Users->getUser();
                $this->session->set_userdata('user',$user);
                if($user->Tip == 0){
                    redirect("Korisnik/index");
                } else if ($user->Tip == 1) {
                    redirect("Moderator/index");
                }
                else {
                    redirect("Admin/index");
                }
            }
        } else {
            $this->login();
        }
    }
}
