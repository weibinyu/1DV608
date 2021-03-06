<?php

class LoginView {
    private static $login = 'LoginView::Login';
    private static $logout = 'LoginView::Logout';
    private static $name = 'LoginView::UserName';
    private static $password = 'LoginView::Password';
    private static $cookieName = 'LoginView::CookieName';
    private static $cookiePassword = 'LoginView::CookiePassword';
    private static $keep = 'LoginView::KeepMeLoggedIn';
    private static $messageId = 'LoginView::Message';
    private $AccountModel;

    //pass accoutmodel to loginView so it can use the info for model
    public function __construct(AccountModel $model){
        $this->AccountModel = $model;
    }
    /**
     * Create HTTP response
     *
     * Should be called after a login attempt has been determined
     *
     * @return  void BUT writes to standard output and cookies!
     */
    public function response() {
        //get user input name and pass
        $name = $this->getRequestUserName();
        $pass = $this->getRequestPassword();
        //check if user are inlogged or not by using session
        if($_SESSION['LoggedIn'] == true){
            //if user logged in and press logout set loggedin to false and destory this session,if user don't press
            //logout then just show logout form
            if(isset($_POST[self::$logout])){
                $_SESSION["LoggedIn"] = false;
                $message = "Bye bye!";
                $response = $this->generateLoginFormHTML($message,$name);
                session_destroy();
            }else{
                $message = "";
                $response = $this->generateLogoutButtonHTML($message);
            }
        }elseif($_SESSION['LoggedIn'] == false) {
            //if user not inlogged and press login check if user has the right account from model, if not get Error
            //message if is the right account show welcome and set session to loggedin and show logout form
            if ($this->AccountModel->check($name,$pass)==false) {
                $message = $this->getErrorMessage();
                $response = $this->generateLoginFormHTML($message, $name);
            } else {
                $message = "Welcome";
                $_SESSION["LoggedIn"] = true;
                $response = $this->generateLogoutButtonHTML($message);
            }
        }
        //return to layoutview;
        return $response;
    }

    /**
     * Generate HTML code on the output buffer for the logout button
     * @param $message, String output message
     * @return  void, BUT writes to standard output!
     */
    private function generateLogoutButtonHTML($message) {
        return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
    }

    /**
     * Generate HTML code on the output buffer for the logout button
     * @param $message, String output message
     * @return  void, BUT writes to standard output!
     */
    private function generateLoginFormHTML($message,$user) {
        return '
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="'.$user.'" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
    }

    //CREATE GET-FUNCTIONS TO FETCH REQUEST VARIABLES
    private function getRequestUserName() {
        //RETURN REQUEST VARIABLE: USERNAME
        if(isset($_POST[self::$name])){
            return $_POST[self::$name];
        }
    }
    private function getRequestPassword() {
        //RETURN REQUEST VARIABLE: Password
        if(isset($_POST[self::$password])){
            return $_POST[self::$password];
        }
    }

    //generate different error messages in different cases
    private function getErrorMessage(){
        if(isset($_POST[self::$login])){
            if(empty($_POST[self::$password])&&empty($_POST[self::$name])){
                return 'Username is missing';
            }elseif(empty($_POST[self::$name])){
                return 'Username is missing';
            }elseif(empty($_POST[self::$password])){
                return 'Password is missing';
            }elseif($_POST[self::$name] == "Admin"&&empty($_POST[self::$password])){
                return 'Password is missing';
            }elseif($_POST[self::$password] == "Password"&&empty($_POST[self::$name])){
                return 'Username is missing';
            }elseif($this->check($_POST[self::$name],$_POST[self::$password]) == false){
                return 'Wrong name or password';
            }
            return '';
        }
    }

}