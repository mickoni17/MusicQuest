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
    
    public function printPage($page, $cssFile, $user, $message=null) {
        $controller="Admin";
        $result=null;
        if ($page == "musicianProfile.php") {
            $iduser = $_SESSION['user']->IDUser;
            $result = $this->DemoVideos->getUserYoutubeLink($iduser);
        }
        else if ($page == "organizerProfile.php") {
            $iduser = $_SESSION['user']->IDUser;
            $result = $this->LocationPictures->getUserPictures($iduser);
        }
        $this->load->view("templates/headerGost.php", ["currentPage"=>$cssFile, "message"=>$message, "controller"=>$controller, "user"=>$user, "resources"=>$result]);
        $this->load->view($page);
        $this->load->view("templates/footer.php");
    }
    
    public function index() {
        $currentPage="homepageStylesheet.css";
        $user=$_SESSION['user'];
        $this->printPage("index.php", $currentPage, $user);
    }
    
    public function profile() {
        $username=$_SESSION['user']->Username;
        $result=$this->Users->getOne($username);
        if ($result->TipUser==0) {
            $this->printPage("musicianProfile.php", "musicianPage.css", $result);
        }
        else {
            $this->printPage("organizerProfile.php", "musicianPage.css", $result);
        }
    }
    
    public function logOut() {
        $this->session->unset_userdata('user');
        redirect("Gost/index");
    }
    
    public function updateDescription() {
        $username=$_SESSION['user']->Username;
        $newDescription=$_GET["newDesc"];
        $this->Users->updateUserDescription($username, $newDescription);
    }
    
    public function getDescription() {
        $username = $_SESSION['user']->Username;
        $result = $this->Users->getUserDescription($username);
        return $result;
    }
    
    public function openPicUpload() {
        $target_dir = "images/".$_SESSION['user']->IDUser."/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir);
        }
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        if(isset($_POST["submitProfile"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
            }
        }
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $uploadOk = 0;
        }
        if ($uploadOk == 0) {
            return;
        // if everything is ok, try to upload file
        } else {
            if (file_exists($target_file)) {
                $this->Users->savePicPath($_SESSION["user"]->Username, $target_file);
                $this->Users->dohvatiUsera($_SESSION["user"]->Username);
                $user = $this->Users->getUser();
                unset($_SESSION["user"]);
                $_SESSION["user"]=$user;
                if ($user->TipUser==0) {
                    $this->printPage("musicianProfile.php", "musicianPage.css", $user);
                }
                else {
                    $this->printPage("organizerProfile.php", "musicianPage.css", $user);
                }
            }
            else if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $this->Users->savePicPath($_SESSION["user"]->Username, $target_file);
                $this->Users->dohvatiUsera($_SESSION["user"]->Username);
                $user = $this->Users->getUser();
                unset($_SESSION["user"]);
                $_SESSION["user"]=$user;
                if ($user->TipUser==0) {
                    $this->printPage("musicianProfile.php", "musicianPage.css", $user);
                }
                else {
                    $this->printPage("organizerProfile.php", "musicianPage.css", $user);
                }
            } else {
                return;
            }
        }
    }
    
    public function openPicUpload2() {
        $target_dir = "images/".$_SESSION['user']->IDUser."/";
        $which=$_POST["whichWindow"];
        if (!is_dir($target_dir)) {
            mkdir($target_dir);
        }
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        if(isset($_POST["submitProfile"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
            }
        }
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $uploadOk = 0;
        }
        if ($uploadOk == 0) {
            return;
        // if everything is ok, try to upload file
        } else {
            if (file_exists($target_file)) {
                $this->LocationPictures->savePicPath2($_SESSION["user"]->IDUser, $target_file,$which);
                $this->Users->dohvatiUsera($_SESSION["user"]->Username);
                $user = $this->Users->getUser();
                unset($_SESSION["user"]);
                $_SESSION["user"]=$user;
                if ($user->TipUser==0) {
                    $this->printPage("musicianProfile.php", "musicianPage.css", $user);
                }
                else {
                    $this->printPage("organizerProfile.php", "musicianPage.css", $user);
        }
            }
            else if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $this->LocationPictures->savePicPath2($_SESSION["user"]->IDUser, $target_file, $which);
                $this->Users->dohvatiUsera($_SESSION["user"]->Username);
                $user = $this->Users->getUser();
                unset($_SESSION["user"]);
                $_SESSION["user"]=$user;
                if ($user->TipUser==0) {
                    $this->printPage("musicianProfile.php", "musicianPage.css", $user);
                }
                else {
                    $this->printPage("organizerProfile.php", "musicianPage.css", $user);
                }
            } else {
                return;
            }
        }
    }
    
    public function addYoutubeLink() {
        $iduser = $_SESSION['user']->IDUser;
        if (isset($_POST['submitLink'])) {
            $which=$_POST["whichWindow"];
            $youtube=$_POST['youtubeLink'];
            $youtube=str_replace("watch?v=", "embed/", $youtube);
            $this->DemoVideos->addYoutubeLinkToDB($iduser,$youtube,$which);
        }
        $this->printPage("musicianProfile.php", "musicianPage.css", $_SESSION["user"]);
    }
    
    public function removeLink() {
        $iduser = $_SESSION['user']->IDUser;
        $which = $_GET['which'];
        $this->DemoVideos->removeUserLink($iduser, $which);
    }
    
    public function removePictureCont() {
        $iduser = $_SESSION['user']->IDUser;
        $which = $_GET['which'];
        $this->LocationPictures->removeUserPicture($iduser,$which);
    }
    
    public function changePasswordOpenPage() {
        $username=$_SESSION['user']->Username;
        $result=$this->Users->getOne($username);
        $this->printPage("changePassword.php", "loginStylesheet.css", $result); 
    }
    
    public function updatePassword() {
        $newPass = $this->input->post("newPass");
        $iduser = $_SESSION['user']->IDUser;
        $this->Users->updatePass($iduser, $newPass);
        $this->index();
    }
}
