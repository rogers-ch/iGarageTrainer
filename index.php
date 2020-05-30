<?php
//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once("vendor/autoload.php");


//Instantiate the F3 Base class
$f3 = Base::instance();

//Default route
$f3->route('GET /', function() {

    //echo "<h1>"."Welcome to IGarage Trainer!"."</h1>";

    $view = new Template();
    echo $view->render('views/iGarageTrainer_home.html');

});

//Sign-Up_1 route
$f3->route('GET|POST /sign-up_1', function($f3){
    //echo '<h1>Hello out there</h1>';

    //If the form has been submitted
    if($_SERVER["REQUEST_METHOD"]=="POST") {
        //var_dump($_POST);

        //validate data


        //data is valid - store data in session variables and display the next form
        if(empty($f3->get('errors'))) {
            //Store the data in the session array
            $_SESSION['fName'] = $_POST['fName'];
            $_SESSION['lName'] = $_POST['lName'];
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['password'] = $_POST['password'];
            $_SESSION['confirmPass'] = $_POST['confirmPass'];

            //var_dump($_SESSION);

            //Redirect to sign-up_2 page
            $f3->reroute('sign-up_2');

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
            $_SESSION['userEquipment'] = $_POST['userEquipment'];
            $_SESSION['fitnessLevel'] = $_POST['fitnessLevel'];

            //var_dump($_SESSION);

            //Redirect to summary page
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
// confirmation page after signing up
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

    $view = new Template();
    echo $view->render("views/workoutChoices.html");

});


//Run F3
$f3->run();
