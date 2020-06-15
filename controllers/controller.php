<?php

/**
 * Class Controller
 *
 * @authors Corey Rogers <crogers25@mail.greenriver.edu> and Chunhai Yang <cyang21@mail.greenriver.edu>
 * @version 1.0
 */
class Controller
{
    private $_f3;
    private $_validator;

    /**
     * Controller constructor.
     * @param $f3
     * @param $validator
     */
    public function __construct($f3, $validator)
    {
        $this->_f3 = $f3;
        $this->_validator = $validator;
    }

    /**
     * Display the default route
     */
    public function home()
    {
        //echo "<h1>"."Welcome to IGarage Trainer!"."</h1>";

        /*
        // test User and PremiumUser classes
        echo "<pre>";
        $preMember = new PremiumUser('Ben', 'James', 'Ben_23', 'test1234', '44');
        echo print_r($preMember);

        $preMember->setEquipment(['dumbbells', 'exercise bands', 'pull-up bar']);
        $preMember->setFitnessLevel('advanced');
        echo print_r($preMember);

        echo "</pre>";
        */

        $view = new Template();
        echo $view->render('views/iGarageTrainer_home.html');

    }

    /**
     * Display the sign-up_1 route
     */
    public function signUp1()
    {
        //echo '<h1>Hello out there</h1>';

        //Redirect to member dashboard if user tries to reach this page while logged in
        //echo isset($_SESSION['loggedIn']);
        //echo print_r($_SESSION);
        if (isset($_SESSION['loggedIn'])) {
            //Redirect to dashboard page
            $this->_f3->reroute('/dashboard');
        }

        //If the form has been submitted
        if($_SERVER["REQUEST_METHOD"]=="POST") {
            //var_dump($_POST);


            //validate data
            if(!$this->_validator->validName($_POST['fName'])){
                $this->_f3->set('errors["name"]', "Enter a valid first name");
            }
            if(!$this->_validator->validName($_POST['lName'])){
                $this->_f3->set('errors["name"]', "Enter a valid last name");
            }
            if(!$this->_validator->validAge($_POST['age'])){
                $this->_f3->set('errors["age"]', "Please enter number between 18 and 118");
            }

            if(!$this->_validator->validUserName($_POST['username'])){
                $this->_f3->set('errors["username"]', "Please enter length between 5 and 15");
            }
            else {
                //Check to see if the username is already in the database, if so require different username
                if($GLOBALS['db']->checkUserName($_POST['username']) == 1){
                    $this->_f3->set('errors["dupUserName"]', "The username you selected is already in use. 
                    Please try a different user name.");
                }
            }

            if(!$this->_validator->validPassword($_POST['password'])){
                $this->_f3->set('errors["password"]', "Please enter length between 8 and 15,
                                                       at least contains one of '!, @, #, $, %'
                                                       and uppercase letter");
            }
            if(!$this->_validator->validCpassword($_POST['password'],$_POST['confirmPass'])){
                $this->_f3->set('errors["confirmPass"]', "password don't match");
            }

            //echo $GLOBALS['db']->checkUserName($_POST['username']);


            //data is valid - store data in session variables and display the next form
            if(empty($this->_f3->get('errors'))) {

                //instantiate the appropriate class - User or PremiumUser depending on whether PremiumUser box was checked
                if(isset($_POST['premium'])) {
                    $user = new PremiumUser($_POST['fName'], $_POST['lName'],
                        $_POST['username'], $_POST['password'], $_POST['age']);
                } else {
                    $user = new User($_POST['fName'], $_POST['lName'],
                        $_POST['username'], $_POST['password'], $_POST['age']);
                }

                //echo "<pre>";
                //echo print_r($user);
                //echo "</pre>";


                //Store the user object in the session array
                $_SESSION['user'] = $user;


                //var_dump($_SESSION);

                //Redirect to sign-up_2 page if this is a PremiumUser, otherwise send to summary page
                if(get_class($_SESSION['user']) == 'PremiumUser') {

                    //Redirect to sign-up 2 page
                    $this->_f3->reroute('sign-up_2');

                } else {

                    //Redirect to confirm page
                    $this->_f3->reroute('confirm');
                }


            }

        }


        //add previous submissions to the hive for sticky form
        $this->_f3->set('firstGiven', $_POST['fName']);
        $this->_f3->set('lastGiven', $_POST['lName']);
        $this->_f3->set('usernameGiven', $_POST['username']);
        $this->_f3->set('passwordGiven', $_POST['password']);
        $this->_f3->set('passConfirmGiven', $_POST['confirmPass']);


        $view = new Template();
        echo $view->render("views/signup_first.html");

    }

    /**
     * Display the sign-up_2 route
     */
    public function signUp2()
    {


        //echo '<h1>Hello out there</h1>';

        //Redirect to default route if user tries to reach this page directly
        if (!isset($_SESSION['user'])) {

            //Redirect to home page
            $this->_f3->reroute('/');

        }

        //Redirect to member dashboard if user tries to reach this page while logged in
        if (isset($_SESSION['loggedIn'])) {
            //Redirect to dashboard page
            $this->_f3->reroute('/dashboard');
        }


        //If the form has been submitted
        if($_SERVER["REQUEST_METHOD"]=="POST") {
            //var_dump($_POST);

            //validate data
            if (!empty($_POST['userEquipment'])) {

                if (!$this->_validator->validEquip($_POST['userEquipment'])) {
                    $this->_f3->set('errors["equip"]', "Please choose valid equipment.");
                }
            }
            else {
                //No equipment selected
                $this->_f3->set('errors["equip"]', "Please select your equipment.");

            }


            if (!$this->_validator->validLevel($_POST['fitnessLevel'])) {
                $this->_f3->set('errors["fitnessLevel"]', "Please select your fitness level.");
            }


            //data is valid - store data in session variables and display the next form
            if(empty($this->_f3->get('errors'))) {
                //Store the data in the session array
                $_SESSION['user']->setEquipment($_POST['userEquipment']);
                $_SESSION['user']->setFitnessLevel($_POST['fitnessLevel']);


                //var_dump($_SESSION);

                //Redirect to confirm page
                $this->_f3->reroute('confirm');

            }

        }

        /*
        //add previous submissions to the hive for sticky form
        $this->_f3->set('equipmentGiven', $_POST['userEquipment']);
        $this->_f3->set('levelGiven', $_POST['fitnessLevel']);

        */
        $this->_f3->set('equipments', getEquip());
        $this->_f3->set('levels', getLevel());



        $view = new Template();
        echo $view->render("views/signup_second.html");

    }

    /**
     * Display the confirm route
     */
    public function confirm()
    {
        //echo '<h1>Thank you for your order!</h1>';

        //Redirect to default route if user tries to reach this page directly
        if (!isset($_SESSION['user'])) {

            //Redirect to home page
            $this->_f3->reroute('/');

        }

        //Redirect to member dashboard if user tries to reach this page while logged in
        if (isset($_SESSION['loggedIn'])) {
            //Redirect to dashboard page
            $this->_f3->reroute('/dashboard');
        }

        //Write user to database
        $GLOBALS['db']->writeUser($_SESSION['user']);


        //echo $result['LAST_INSERT_ID()'];
        //Set userNum for user to the userNum result from the database

        $view = new Template();
        echo $view->render('views/confirmpage.html');

        session_destroy();

    }

    /**
     * Display the sign-in route
     */
    public function signIn()
    {
        //echo '<h1>Hello existing member</h1>';

        //If the form has been submitted
        if($_SERVER["REQUEST_METHOD"]=="POST") {
            //var_dump($_POST);

            //Check for correct username and password
            //Check to see if username is in the database
            if(!($GLOBALS['db']->checkUserName($_POST['username']) == 1)){
                $this->_f3->set('errors["username"]', "Please enter a valid username.");
            } else {

                //Check to see if password matches stored password for the username
                if (!($GLOBALS['db']->checkPassword($_POST['username'], $_POST['password']) == 1)) {
                    $this->_f3->set('errors["password"]', "Please enter a valid password.");
                }
            }


            //Username and password are valid - store correct user object in session and set loggedIn variable
            if(empty($this->_f3->get('errors'))) {

                //Read the user's information from the database
                $userInfoArray = $GLOBALS['db']->readUser($_POST['username']);

                //Use the $userInfoArray to create the user object and store it in the Session array
                if ($userInfoArray['fitness_level'] != NULL) {
                    $_SESSION['user'] = new PremiumUser($userInfoArray['firstName'], $userInfoArray['lastName'],
                        $userInfoArray['username'], $_POST['password']);

                    $_SESSION['user']->setUserNum($userInfoArray['user_id']);
                    $_SESSION['user']->setEquipment($userInfoArray['equipment']);
                    $_SESSION['user']->setFitnessLevel($userInfoArray['fitness_level']);

                } else {
                    $_SESSION['user'] = new User($userInfoArray['firstName'], $userInfoArray['lastName'],
                        $userInfoArray['username'], $_POST['password']);
                    $_SESSION['user']->setUserNum($userInfoArray['user_id']);
                }


                //Set loggedIn flag variable to true
                $_SESSION['loggedIn'] = TRUE;

                //var_dump($_SESSION);

                //Redirect to dashboard page
                $this->_f3->reroute('/dashboard');

            }

        }


        //add previously submitted username to the hive for sticky form
        $this->_f3->set('usernameGiven', $_POST['username']);


        $view = new Template();
        echo $view->render("views/signinPage.html");

    }

    /**
     * Display the dashboard route
     */
    public function dashboard()
    {
        //echo '<h1>Hello existing member</h1>';

        //Redirect to sign-in page if user tries to reach this page without being logged in
        if (!isset($_SESSION['loggedIn'])) {

            //Redirect to login page
            $this->_f3->reroute('/sign-in');
        }

        $view = new Template();
        echo $view->render("views/userDashboard.html");

    }

    /**
     * Display the workout_options route
     */
    public function workout_options()
    {
        //echo '<h1>Hello existing member</h1>';

        //Redirect to sign-in page if user tries to reach this page without being logged in
        if (!isset($_SESSION['loggedIn'])) {

            //Redirect to login page
            $this->_f3->reroute('/sign-in');
        }

        //If the form has been submitted
        if($_SERVER["REQUEST_METHOD"]=="POST") {
            //var_dump($_POST);

            //validate data




            //Redirect to dashboard page
            $this->_f3->reroute('/myWorkout');


        }

        $view = new Template();
        echo $view->render("views/workoutChoices.html");

    }

    /**
     * Display the myWorkout route
     */
    public function myWorkout()
    {
        //echo '<h1>Hello existing member</h1>';

        //Redirect to sign-in page if user tries to reach this page without being logged in
        if (!isset($_SESSION['loggedIn'])) {

            //Redirect to login page
            $this->_f3->reroute('/sign-in');
        }

        $view = new Template();
        echo $view->render("views/workoutView.html");

    }

    /**
     * Display the myWorkoutLog route
     */
    public function myWorkoutLog()
    {
        //echo '<h1>Hello existing member</h1>';

        //Redirect to sign-in page if user tries to reach this page without being logged in
        if (!isset($_SESSION['loggedIn'])) {

            //Redirect to login page
            $this->_f3->reroute('/sign-in');
        }

        $view = new Template();
        echo $view->render("views/workoutLog.html");

    }

    /**
     * Display the logout route
     */
    public function logout()
    {
        //echo '<h1>Hello existing member</h1>';

        //Redirect to sign-in page if user tries to reach this page without being logged in
        if (!isset($_SESSION['loggedIn'])) {

            //Redirect to login page
            $this->_f3->reroute('/sign-in');
        }

        //echo print_r($_SESSION);

        session_destroy();
        $_SESSION = array();

        //echo print_r($_SESSION);

        $view = new Template();
        echo $view->render("views/logoutConfirm.html");

    }

    /**
     * Display the admin route
     */
    public function admin()
    {
        //echo '<h1>Hello existing member</h1>';

        //echo print_r($_SESSION);

        //Redirect to sign-in page if user tries to reach this page without being logged in
        if (!isset($_SESSION['loggedIn'])) {

            //Redirect to login page
            $this->_f3->reroute('/sign-in');
        }
        else {

            //echo $_SESSION['user']->getUserName();

            //If the user is not the administrator, then redirect to member dashboard
            if (strcmp($_SESSION['user']->getUserName(), "Admin") != 0) {

                //Redirect to member dashboard page
                $this->_f3->reroute('/dashboard');
            }

        }

        //If the form has been submitted
        if($_SERVER["REQUEST_METHOD"]=="POST") {
            //var_dump($_POST);

            //validate data - ADD LATER

            //instantiate an Exercise object
            $exercise = new Exercise($_POST['exerciseName'], $_POST['description'],
                $_POST['difficulty'], $_POST['muscleGroup'], $_POST['equipment']);

            //echo print_r($exercise);


            //Write exercise to database
            $GLOBALS['db']->writeExercise($exercise);

        }


        $view = new Template();
        echo $view->render("views/admin.html");

    }


}