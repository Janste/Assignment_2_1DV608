<?php
require_once('User.php');
require_once("UserArray.php");

/**
 * This class checks if username or password typed by user is correct.
 */
class Authentication {

    private $users = array();
    private $outputMsg = '';
    private $usersArr;

    /**
     * Constructor. It gets the array of users so that this class can
     * later authenticate user credentials.
     */
    public function __construct() {
        $this->usersArr = new UserArray();
    }

    /**
     * This method initializes the rest of the model. It runs methods which later on
     * connect to the DB and create an array of users. If this fails we get the Error message.
     * @return true, if everything ok, false otherwise
     */
    public function initialize() {

        if($this->usersArr->generateArray()) {
            $this->users = $this->usersArr->getUsers();
            return true;
        } else {
            $this->outputMsg = $this->usersArr->getErrorMessage();
            return false;
        }
    }

    /**
     * Returns a message to the user. This can be an error message or
     * information about successful login
     * @param nothing
     * @return $this->outputMsg as string
     */
    public function getOutputMsg() {
        return $this->outputMsg;
    }

    /**
     * Logs in a user
     * @param $username, which is username and $password which is password
     * @return true is credentials are correct and false if otherwise
     */
    public function login($username, $password) {

        if($this->authenticate($username, $password)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Checks if credentials typed by the user are ok.
     * If credentials are incorrect or something is missing it
     * sets proper output message
     * @param $u, which is username and $p which is password
     * @return true is credentials are correct and false if otherwise
     */
    public function authenticate ($u, $p) {

        if(empty($u)) { // Check is username field is empty
            $this->outputMsg = 'Username is missing';
            return false;

        } elseif (empty($p)) { // Check is password field is empty
            $this->outputMsg = 'Password is missing';
            return false;

        }

        $amount = count($this->users);

        // Loop through all users and check if there exists a user with specified username and password
        for($i = 0; $i < $amount; $i++) {
            if($this->users[$i]->getUsername() == $u && $this->users[$i]->getPassword() == $p) {
                $this->outputMsg = 'Welcome';
                return true;
            }
        }
        $this->outputMsg = 'Wrong name or password';
        return false;
    }

}