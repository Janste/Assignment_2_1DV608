<?php

// Include files and classes needed
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('model/Authentication.php');

class Controller {

    private $loginV;
    private $dateV;
    private $layoutV;
    private $authenticate;
    private $messageToUser = '';

    // Constructor
    public function __construct() {
        $this->layoutV = new LayoutView();
        $this->loginV = new LoginView();
        $this->dateV = new DateTimeView();
        $this->authenticate = new Authentication();
    }

    // Main method
    public function run() {

        // This method initializes the model.
        if(!$this->authenticate->initialize()) { // If something went wrong then show the error message
            $this->layoutV->showError($this->authenticate->getOutputMsg());
        }

        // Check if cookie is set. If yes then user is logged in
        if ($this->loginV->checkCookieSet()) {

            // Create view for logged in page
            $this->loginV->setMessage('');
            $this->loginV->setUserLoggedIn(true);
            $this->layoutV->render(true, $this->loginV, $this->dateV);

            // Check if user clicked on log out button
            if ($this->loginV->checkLogoutButtonClicked()) {

                // Logging out user, display proper view
                $this->loginV->logout();
                $this->loginV->setUserLoggedIn(false);
                $this->layoutV->clearView();
                $this->layoutV->render(false, $this->loginV, $this->dateV);

            }

        } else { // User not logged in

            // Set proper view for the logged out page
            $this->loginV->setMessage('');
            $this->loginV->setUserLoggedIn(false);
            $this->layoutV->render(false, $this->loginV, $this->dateV);

            // Check if log in button clicked
            if ($this->loginV->checkLogInButtonClicked()) {

                // Get username and password from the form in view
                $username = $this->loginV->getUserName();
                $password = $this->loginV->getPassword();

                // Authenticate user credentials
                if ($this->authenticate->login($username, $password)) {

                    // User credentials correct, set up proper view
                    $this->layoutV->clearView();
                    $this->messageToUser = $this->authenticate->getOutputMsg();
                    $this->loginV->setMessage($this->messageToUser);
                    $this->loginV->setUserLoggedIn(true);
                    $this->loginV->setCookie();
                    $this->layoutV->render(true, $this->loginV, $this->dateV);

                } else { // User credentials incorrect

                    // Set up view with error message
                    $this->layoutV->clearView();
                    $this->messageToUser = $this->authenticate->getOutputMsg();
                    $this->loginV->setMessage($this->messageToUser);
                    $this->loginV->setUserLoggedIn(false);
                    $this->layoutV->render(false, $this->loginV, $this->dateV);

                }
            }
        }
    }
}
