<?php
class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieID = 'LoginView::CookieID';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';
	private static $username = '';

	private $message = '';
	private $loggedIn = false;

    // If user inserted username then get that username
    // so that it can be displayed on the form
	public function __construct() {
		self::$username = $this->getUserName();
	}

    /**
     * Get the username from the form.
     * @param nothing
     * @return false, or $username if user typed in it to the form
     */
    public function getUserName() {
        if(isset($_POST[self::$name])) {
            $username = $_POST[self::$name];
            return $username;
        } else {
            return false;
        }

    }

    /**
     * Get the password from the form.
     * @param nothing
     * @return false, or $password if user typed in it to the form
     */
    public function getPassword() {
        if(isset($_POST[self::$password])) {
            $password = $_POST[self::$password];
            return $password;
        } else {
            return false;
        }
    }

    /**
     * Sets a message that will be displayed to the user
     * @param nothing
     * @return void
     */
	public function setMessage($m) {
		$this->message = $m;
	}

    /**
     * Sets the boolean value. True is user logged in, false otherwise.
     * @param $logged, which is a boolean value
     * @return void
     */
	public function setUserLoggedIn($logged) {
		$this->loggedIn = $logged;
	}

    /**
     * Check if a cookie is set on user's computer
     * @param nothing
     * @return true or false
     */
	public function checkCookieSet() {
		if(isset($_COOKIE[self::$cookieID])) {
			return true;
		} else {
			return false;
		}
	}

    /**
     * Set a cookie on user's computer
     * @param nothing
     * @return void
     */
	public function setCookie() {
		setcookie(self::$cookieID, self::$cookiePassword, 0 , "/");
	}

    /**
     * Removes a cookie from user's computer
     * @param nothing
     * @return void
     */
	public function logout() {
		if ($this->checkCookieSet()) {
			$this->setMessage('Bye bye!');
			setcookie(self::$cookieID, self::$cookiePassword, time() - 100000, "/");
		}
	}

    /**
     * Checks if user clicked on log in button
     * @param nothing
     * @return true or false
     */
    public function checkLogInButtonClicked() {
        if(isset($_POST[self::$login])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Checks if user clicked on log out button
     * @param nothing
     * @return true or false
     */
    public function checkLogoutButtonClicked() {
        if(isset($_POST[self::$logout])) {
            return true;
        } else {
            return false;
        }
    }

	/**
	 * Create HTTP response
	 * Should be called after a login attempt has been determined
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response() {

		if (!$this->loggedIn) {
			$response = $this->generateLoginFormHTML($this->message);
		} else {
			$response = $this->generateLogoutButtonHTML($this->message);
		}

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
	private function generateLoginFormHTML($message) {
		return '
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . self::$username . '" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}
}