<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Admin
 *
 * @author Windows 10
 */
class Admin extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model("Cooperation");
        $this->load->model("DemoVideos");
        $this->load->model("LocationPictures");
        $this->load->model("Organizer");
        $this->load->model("Users");
    }
    
    public function printPage() {
        $currentPage="homepageStylesheet.css";
        $this->load->view("templates/headerGost.php", ["currentPage"=>$currentPage]);
        $this->load->view("index.php");
        $this->load->view("templates/footer.php");
    }
    
    public function index() {
        $this->printPage();
    }
}
