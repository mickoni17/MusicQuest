<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Users
 *
 * @author Windows 10
 */
class Users extends CI_Model {
    private $user;
    
    public function __construct() {
        parent::__construct();
    }
    
    public function dohvatiUsera($username){
        $result=$this->db->where('Username',$username)->get('user');
        $user=$result->row();
        if ($user!=NULL) {
            $this->user=$user;
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function getUser() {
        return $this->user;
    }
    
    public function ispravanPassword($pass){
        if ($this->user->Password == $pass) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function newUser($name, $user, $pass, $tip, $tipUser, $active) {
        $query = $this->db->from("user")->select("MAX(IDUser) as maks")->get();
        $row = $query->row();
        $maks = $row->maks+1;
        $this->db->set("IDUser", $maks);
        $this->db->set("Username", $user);
        $this->db->set("Password", $pass);
        $this->db->set("Name",$name);
        $this->db->set("Tip", $tip);
        $this->db->set("TipUser", $tipUser);
        $this->db->set("Active", $active);
        $this->db->insert("user");
        if ($tipUser == "Musician") {
            $this->db->query("INSERT INTO `musician`(`IDUserMus`) VALUES (".$maks.")");
            $this->db->query("INSERT INTO `demovideos`(`IDUserMus`) VALUES (".$maks.")");
        }
        else {
            $this->db->query("INSERT INTO `organizer`(`IDUserOrg`) VALUES (".$maks.")");
            $this->db->query("INSERT INTO `locationpictures`(`IDUserOrg`) VALUES (".$maks.")");
        }
    }
}
