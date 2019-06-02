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
    private $whichOnes=0;
    
    public function __construct() {
        parent::__construct();
        $this->load->model("Cooperation");
        $this->load->model("DemoVideos");
        $this->load->model("LocationPictures");
        $this->load->model("Organizer");
        $this->load->model("Users");
    }
    
    public function searchUsers() {
        $name = $_GET['search'];
        $result = $this->Users->searchDB($name);
        $stringToReturn="";
        foreach ($result->result() as $row) {
            $stringToReturn.= "<div class=\"col-lg-3 col-md-4 col-sm-6\">
                <div class=\"card\">
                    <a href=\"musicianPage.html\"><img src=".$row->ProfilePicture." class=\"card-img-top\" alt=\"Image Not Found\"></a>
                    <div class=\"card-body\">
                        <h5 class=\"card-title text-center\">".$row->Name."</h5>
                    </div>
                </div>
            </div>";
        }
        echo $stringToReturn;
    }
    
    public function changeWhichOnes() {
        $this->whichOnes=$_GET['which'];
        $stringToReturn="";
        $result = $this->Users->getAllUsers($this->whichOnes,16);
        foreach ($result->result() as $row) {
            $stringToReturn.= "<div class=\"col-lg-3 col-md-4 col-sm-6\">
                <div class=\"card\">
                    <a href=\"musicianPage.html\"><img src=".$row->ProfilePicture." class=\"card-img-top\" alt=\"Image Not Found\"></a>
                    <div class=\"card-body\">
                        <h5 class=\"card-title text-center\">".$row->Name."</h5>
                    </div>
                </div>
            </div>";
        }
        echo $stringToReturn;
    }
    
    public function printPage($page, $cssFile, $message=null) {
        $controller="Gost";
        $result=null;
        $howMany=16;
        $this->load->view("templates/headerGost.php", ["currentPage"=>$cssFile, "message"=>$message, "controller"=>$controller, "resources"=>$result]);
        $this->load->view($page);
        $this->load->view("templates/footer.php");
    }
    
    public function index() {
        $currentPage="homepageStylesheet.css";
        $this->printPage("index.php", $currentPage);
    }
    
    public function registracija($message=null) {
        $currentPage="loginStylesheet.css";
        $this->printPage("signUpPage.php", $currentPage, $message);
    }
    
    public function login($message=null) {
        $currentPage="loginStylesheet.css";
        $this->printPage("loginPage.php", $currentPage, $message);
    }
    
    public function registrujSe() {
        $name=$this->input->post("Name");
        $user=$this->input->post("Username");
        $pass=$this->input->post("Password");
        $radioVal = $_POST["optradio"];
        $confirmed=$this->input->post("Confirmed");
        $tip=2;
        $active=1;
        $tipUser;
        if($radioVal == "musician" && $pass==$confirmed) {
           $tipUser="Musician";
           $this->Users->newUser($name, $user, $pass, $tip, $tipUser, $active);
            redirect("Gost/index");
        }
        else if ($radioVal == "organizer" && $pass==$confirmed) {
            $tipUser="Organizer";
            $this->Users->newUser($name, $user, $pass, $tip, $tipUser, $active);
            redirect("Gost/index");
        }
        else {
            $this->registracija("Lozinka neispravno potvrdjena");
        }
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
                    redirect("User/index");
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
