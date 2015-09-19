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

	

	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response() {
		$message = $this->getErrorMessage();
		$user = $this->getRequestUserName();
		$response = $this->generateLoginFormHTML($message,$user);
		//$response .= $this->generateLogoutButtonHTML($message);
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
			}
			return '';
		}
	}

	private function check(){
		if($_POST[self::$name] == "Admin"&&$_POST[self::$name] == "Password"){
			return true;
		}else{
			return false;
		}
	}
}