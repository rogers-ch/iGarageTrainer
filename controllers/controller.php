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

        //If the form has been submitted
        if($_SERVER["REQUEST_METHOD"]=="POST") {
            //var_dump($_POST);

            //validate data - ADD THIS


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

        /*
        //add previous submissions to the hive for sticky form
        $f3->set('firstGiven', $_POST['fName']);
        $f3->set('lastGiven', $_POST['lName']);
        $f3->set('usernameGiven', $_POST['username']);
        $f3->set('passwordGiven', $_POST['password']);
        $f3->set('passConfirmGiven', $_POST['confirmPass']);
        */

        $view = new Template();
        echo $view->render("views/signup_first.html");

    }

    /**
     * Display the sign-up_2 route
     */
    public function signUp2()
    {
        //echo '<h1>Hello out there</h1>';

        //If the form has been submitted
        if($_SERVER["REQUEST_METHOD"]=="POST") {
            //var_dump($_POST);

            //validate data - ADD LATER

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

        $view = new Template();
        echo $view->render("views/signup_second.html");

    }

    /**
     * Display the confirm route
     */
    public function confirm()
    {
        //echo '<h1>Thank you for your order!</h1>';

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

            //validate data


            //data is valid - store data in session variables and display the next form
            if(empty($this->_f3->get('errors'))) {
                //Store the data in the session array
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['password'] = $_POST['password'];

                //var_dump($_SESSION);

                //Redirect to dashboard page
                $this->_f3->reroute('/dashboard');

            }

        }

        /*
        //add previous submissions to the hive for sticky form
        $f3->set('firstGiven', $_POST['fName']);
        $f3->set('lastGiven', $_POST['lName']);
        $f3->set('usernameGiven', $_POST['username']);
        $f3->set('passwordGiven', $_POST['password']);
        $f3->set('passConfirmGiven', $_POST['confirmPass']);
        */

        $view = new Template();
        echo $view->render("views/signinPage.html");

    }

    /**
     * Display the dashboard route
     */
    public function dashboard()
    {
        //echo '<h1>Hello existing member</h1>';

        $view = new Template();
        echo $view->render("views/userDashboard.html");

    }

    /**
     * Display the workout_options route
     */
    public function workout_options()
    {
        //echo '<h1>Hello existing member</h1>';

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

        $view = new Template();
        echo $view->render("views/workoutView.html");

    }

    /**
     * Display the myWorkoutLog route
     */
    public function myWorkoutLog()
    {
        //echo '<h1>Hello existing member</h1>';

        $view = new Template();
        echo $view->render("views/workoutLog.html");

    }





}