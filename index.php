<?php
//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once("vendor/autoload.php");

//Start a session
session_start();


//Instantiate the F3 Base class
$f3 = Base::instance();

//Instantiate a Database object
$db = new Database();

//Default route
$f3->route('GET /', function() {

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

});

//Sign-Up_1 route
$f3->route('GET|POST /sign-up_1', function($f3){
    //echo '<h1>Hello out there</h1>';

    //If the form has been submitted
    if($_SERVER["REQUEST_METHOD"]=="POST") {
        //var_dump($_POST);

        //validate data - ADD THIS


        //data is valid - store data in session variables and display the next form
        if(empty($f3->get('errors'))) {

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
                $f3->reroute('sign-up_2');

            } else {

                //Redirect to confirm page
                $f3->reroute('confirm');
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

});


//Sign-up_2 Route
$f3->route('GET|POST /sign-up_2', function($f3){
    //echo '<h1>Hello out there</h1>';

    //If the form has been submitted
    if($_SERVER["REQUEST_METHOD"]=="POST") {
        //var_dump($_POST);

        //validate data - ADD LATER

        //data is valid - store data in session variables and display the next form
        if(empty($f3->get('errors'))) {
            //Store the data in the session array
            $_SESSION['user']->setEquipment($_POST['userEquipment']);
            $_SESSION['user']->setFitnessLevel($_POST['fitnessLevel']);


            //var_dump($_SESSION);

            //Redirect to confirm page
            $f3->reroute('confirm');

        }

    }

    /*
    //add previous submissions to the hive for sticky form
    $f3->set('equipmentGiven', $_POST['userEquipment']);
    $f3->set('levelGiven', $_POST['fitnessLevel']);

    */

    $view = new Template();
    echo $view->render("views/signup_second.html");

});


//Confirmation page after signing up
$f3->route('GET /confirm', function() {
    //echo '<h1>Thank you for your order!</h1>';

    $view = new Template();
    echo $view->render('views/confirmpage.html');

    session_destroy();
});


//Sign In page
$f3->route('GET|POST /sign-in', function($f3){
    //echo '<h1>Hello existing member</h1>';

    //If the form has been submitted
    if($_SERVER["REQUEST_METHOD"]=="POST") {
        //var_dump($_POST);

        //validate data


        //data is valid - store data in session variables and display the next form
        if(empty($f3->get('errors'))) {
            //Store the data in the session array
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['password'] = $_POST['password'];

            //var_dump($_SESSION);

            //Redirect to dashboard page
            $f3->reroute('/dashboard');

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

});


//User Dashboard Route
$f3->route('GET|POST /dashboard', function($f3){
    //echo '<h1>Hello existing member</h1>';

    $view = new Template();
    echo $view->render("views/userDashboard.html");

});

//Workout Options Route
$f3->route('GET|POST /workout_options', function($f3){
    //echo '<h1>Hello existing member</h1>';

    //If the form has been submitted
    if($_SERVER["REQUEST_METHOD"]=="POST") {
        //var_dump($_POST);

        //validate data




        //Redirect to dashboard page
        $f3->reroute('/myWorkout');


    }

    $view = new Template();
    echo $view->render("views/workoutChoices.html");

});

//My Workout Route
$f3->route('GET|POST /myWorkout', function($f3){
    //echo '<h1>Hello existing member</h1>';

    $view = new Template();
    echo $view->render("views/workoutView.html");

});


//My Workout Log Route
$f3->route('GET|POST /myWorkoutLog', function($f3){
    //echo '<h1>Hello existing member</h1>';

    $view = new Template();
    echo $view->render("views/workoutLog.html");

});


//Run F3
$f3->run();
