<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author Windows 10
 */
class User extends CI_Controller {
    private $users;
    private $acceptArray = array("<a href=\"#collapseInfo1\" data-toggle=\"collapse\" class=\"list-group-item list-group-item-action\">
        <div class=\"d-flex w-100 justify-content-between\">
            <h6><label id=\"label","\">", "</label> and you have a cooperation on ", "</h6>
        </div>
    </a>
    <div class=\"collapse\" id=\"collapseInfo1\">
        <div class=\"card card-body\" id=\"textPart","\">", "<div class=\"accrej\">
                <br><button type=\"button\" class=\"btn btn-success btn-sm\" onClick=\"acceptRequest(",")\">Accept</button>
                <button type=\"button\" class=\"btn btn-success btn-sm\" onClick=\"rejectRequest(",")\">Reject</button>
                </div>
            </div>
      </div>");
    private $acceptedArray = array("<a href=\"#collapseInfo1\" data-toggle=\"collapse\" class=\"list-group-item list-group-item-action\">
        <div class=\"d-flex w-100 justify-content-between\">
            <h6><label id=\"label","\">", "</label> and you have a cooperation on", "</h6>
        </div>
    </a>");
    private $rejectedArray = array("<a href=\"#collapseInfo2\" data-toggle=\"collapse\" class=\"list-group-item list-group-item-action\">
            <div class=\"d-flex w-100 justify-content-between\">
        <h6>", " has denied your cooperation request.</h6>
            </div>
      </a>
      <div class=\"collapse\" id=\"collapseInfo2\">
              <div class=\"card card-body\">",
               "</div>
      </div>");
    private $endedArray = array("<a href=\"#collapseInfo3\" data-toggle=\"collapse\" class=\"list-group-item list-group-item-action\">
            <div class=\"d-flex w-100 justify-content-between\">
        <h6>You cooperation with", "has ended. Rate it!</h6>
            </div>
      </a>
      <div class=\"collapse\" id=\"collapseInfo3\">
              <div class=\"card card-body\">
                <!-- <form class=\"formRating\"> -->
                        Rate your cooperation:
                            <div class=\"rating\">
                            <span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span>
                            </div><br>
                            <button class=\"btn btn-primary btn-sm\" type=\"submit\" data-toggle=\"modal\" data-target=\"#exampleModal\">Submit</button>
                    <!-- </form> -->
                    <div class=\"modal fade\" id=\"exampleModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">
                              <div class=\"modal-dialog\" role=\"document\">
                                <div class=\"modal-content\">
                                  <div class=\"modal-header\">
                                    <h5 class=\"modal-title\" id=\"exampleModalLabel\">Cooperation concluded!</h5>
                                  </div>
                                  <div class=\"modal-body\">
                                    <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
                                  </div>
                                </div>
                              </div>
                    </div>
              </div>
      </div>");
    
    public function __construct() {
        parent::__construct();
        $this->load->model("Cooperation");
        $this->load->model("DemoVideos");
        $this->load->model("LocationPictures");
        $this->load->model("Organizer");
        $this->load->model("Users");
    }
    
    public function remapToMusician($param) {
        $user = $this->Users->getOne($param);
        $result = $this->DemoVideos->getUserYoutubeLink($user->IDUser);
        $message=null;
        $page=null;
        if ($user->Username == $_SESSION['user']->Username) {
            $page = "musicianProfile.php";
        }
        else {
            $page = "otherMusicianPage.php";
        }
        $this->load->view("templates/headerGost.php", ["currentPage"=>"musicianPage.css", "message"=>$message, "controller"=>"User", "user"=>$user, "resources"=>$result]);
        $this->load->view($page, ["currentPage"=>"musicianPage.css", "message"=>$message, "controller"=>"User", "user"=>$user, "resources"=>$result]);
        $this->load->view("templates/footer.php");
    }
    
    public function remapToOrganizer($param) {
        $user = $this->Users->getOne($param);
        $result = $this->LocationPictures->getUserPictures($user->IDUser);
        $message=null;
        $page=null;
        if ($user->Username == $_SESSION['user']->Username) {
            $page = "organizerProfile.php";
        }
        else {
            $page = "otherOrganizerPage.php";
        }
        $this->load->view("templates/headerGost.php", ["currentPage"=>"musicianPage.css", "message"=>$message, "controller"=>"User", "user"=>$user, "resources"=>$result]);
        $this->load->view($page, ["currentPage"=>"musicianPage.css", "message"=>$message, "controller"=>"User", "user"=>$user, "resources"=>$result]);
        $this->load->view("templates/footer.php");
    }
    
    public function requestCooperation($param) {
        $user = $this->Users->getOne($param);
        $this->printPage("requestCooperation.php", "cooperationStylesheet.css", $user);
    }
    
    public function sendCoopRequest() {
        $datetime = $this->input->post("Date");
        $text = $this->input->post("Description");
        $username = $this->input->post("userWhich");
        $user = $this->Users->getOne($username);
        $date="";
        for ($i=0; $i<strlen($datetime); $i++) {
            if ($datetime[$i] != 'T') {
                $date.=$datetime[$i];
            }
            else {
                $date.=" ";
            }
        }
        $date.=":00";
        if ($user->TipUser==0) {
            $userFirst=$user;
            $userSecond=$_SESSION['user'];
        }
        else {
            $userFirst=$_SESSION['user'];
            $userSecond=$user;
        }
        $this->Cooperation->addCooperation($userFirst, $userSecond, $date, $text, $_SESSION['user']->IDUser);
        if ($user->TipUser==0) {
            $this->remapToMusician($username);
        }
        else {
            $this->remapToOrganizer($username);
        }
    }
    
    public function openNotificationsPage() {
        $user = $this->Users->getOne($_SESSION['user']->Username);
        $coops = $this->Cooperation->getAll($user->IDUser);
        $resources=array();
        $k=0;   
        foreach ($coops->result() as $a) {
            $fillString="";
            if ($a->Status == "PENDING" && $a->IDReply != $user->IDUser) {
                $fillString = $this->acceptArray[0];
                if ($a->IDUserOrg==$user->IDUser) {
                    $otherUser = $this->Users->dohvatiCelogUseraSaId($a->IDUserMus);
                }
                else {
                    $otherUser = $this->Users->dohvatiCelogUseraSaId($a->IDUserOrg);
                }
                $fillString.=$k.$this->acceptArray[1].$otherUser->Name.$this->acceptArray[2].$a->Date.$this->acceptArray[3].$k.$this->acceptArray[4].$a->proposalDescription.$this->acceptArray[5].$k.$this->acceptArray[6].$k.$this->acceptArray[7];
                $resources[$k++]=$fillString;
            }
            else if ($a->Status == "ACCEPTED") {
                $fillString = $this->acceptArray[0];
                if ($a->IDUserOrg==$user->IDUser) {
                    $otherUser = $this->Users->dohvatiCelogUseraSaId($a->IDUserMus);
                }
                else {
                    $otherUser = $this->Users->dohvatiCelogUseraSaId($a->IDUserOrg);
                }
                $this->Cooperation->getOne($a->IDUserMus, $a->IDUserOrg, $a->Status, $a->IDReply);
                $fillString.=$k.$this->acceptArray[1].$otherUser->Name.$this->acceptArray[2].$a->Date.$this->acceptArray[3];
                $resources[$k++]=$fillString;
            }
            else if ($a->Status == "REJECTED" && $a->IDReply != $user->IDUser) {
                $fillString = $this->rejectedArray[0];
                if ($a->IDUserOrg==$user->IDUser) {
                    $otherUser = $this->Users->dohvatiCelogUseraSaId($a->IDUserMus);
                }
                else {
                    $otherUser = $this->Users->dohvatiCelogUseraSaId($a->IDUserOrg);
                }
                $fillString.=$otherUser->Name.$this->rejectedArray[1].$a->Description.$this->rejectedArray[2];
                $resources[$k++]=$fillString;
            }
        }
        $this->load->view("templates/headerGost.php", ["currentPage"=>"cooperationStylesheet.css", "message"=>null, "controller"=>"User", "user"=>$user, "resources"=>$resources]);
        $this->load->view("notificationsPage.php");
        $this->load->view("templates/footer.php");
    }
    
    public function acceptR() {
        $desc = $_GET["desc"];
        $other = $_GET["other"];
        $this->Cooperation->acceptRequest($desc, $other);
    }
    
    public function searchUsers() {
        $name = $_GET['search'];
        $result = $this->Users->searchDB($name);
        $stringToReturn="";
        $type;
        $i=0;
        foreach ($result->result() as $row) {
            if ($row->TipUser==0) {
                $type="Musician";
            }
            else {
                $type="Organizer";
            }
            $stringToReturn.= "<div class=\"col-lg-3 col-md-4 col-sm-6\">
                <div class=\"card\">
                    <a href=\"".base_url()."index.php/User/remapTo".$type."/".$row->Username."\"><img src=../../".$row->ProfilePicture." class=\"card-img-top\" alt=\"Image Not Found\"></a>
                    <div class=\"card-body\" id=".$i.">
                        <h5 class=\"card-title text-center\">".$row->Name."</h5>
                    </div>
                </div>
            </div>";
            $i++;
        }
        echo $stringToReturn;
    }
    
    public function changeWhichOnes() {
        $this->whichOnes=$_GET['which'];
        $stringToReturn="";
        $result = $this->Users->getAllUsers($this->whichOnes,16);
        $type;
        $i=0;
        foreach ($result->result() as $row) {
            if ($row->TipUser==0) {
                $type="Musician";
            }
            else {
                $type="Organizer";
            }
            $stringToReturn.= "<div class=\"col-lg-3 col-md-4 col-sm-6\">
                <div class=\"card\">
                    <a href=\"".base_url()."index.php/User/remapTo".$type."/".$row->Username."\"><img src=../../".$row->ProfilePicture." class=\"card-img-top\" alt=\"Image Not Found\"></a>
                    <div class=\"card-body\" id=".$i.">
                        <h5 class=\"card-title text-center\">".$row->Name."</h5>
                    </div>
                </div>
            </div>";
            $i++;
        }
        echo $stringToReturn;
    }
    
    public function printPage($page, $cssFile, $user, $message=null) {
        $controller="User";
        $result=null;
        $howMany=16;
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
        if ($result->TipUser===0) {
            $this->printPage("musicianProfile.php", "musicianPage.css", $result);
        }
        else {
            $this->printPage("organizerProfile.php", "musicianPage.css", $result);
        }
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
            $_SESSION['user'] = $this->Users->dohvatiUsera($_SESSION['user']->Username);
        }
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
    
}
