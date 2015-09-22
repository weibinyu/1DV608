<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2015/9/23
 * Time: 0:20
 */

//require all views and model
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('model/AccountModel.php');
class ViewController{
    // basicly do same thing as index did before
    private $AccountModel;
    private $v;
    private $dtv;
    private $lv;

    public function __construct(){
        //CREATE OBJECTS OF THE VIEWS
        $this->AccountModel = new AccountModel();
        $this->v = new LoginView($this->AccountModel);
        $this->dtv = new DateTimeView();
        $this->lv = new LayoutView();
    }
    public function run(){
        $this->SessionInit();
        $this->lv->render($_SESSION['LoggedIn'], $this->v, $this->dtv);
    }

    //check if session already set, if not set it to false
    public function SessionInit(){
        if(!isset($_SESSION['LoggedIn'])){
            $_SESSION['LoggedIn'] = false;
        }
    }
}