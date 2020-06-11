<?php
//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once("vendor/autoload.php");

//Start a session
session_start();

//Instantiate the F3 Base class
$f3 = Base::instance();

//Instantiate a Validate object
$validator = new Validate;

//Instantiate a Controller object
$controller = new Controller($f3, $validator);

//Instantiate a Database object
$db = new Database();

//Default route
$f3->route('GET /', function() {

    $GLOBALS['controller']->home();

});

//Sign-Up_1 route
$f3->route('GET|POST /sign-up_1', function(){

    $GLOBALS['controller']->signUp1();

});


//Sign-up_2 Route
$f3->route('GET|POST /sign-up_2', function(){

    $GLOBALS['controller']->signUp2();

});


//Confirmation page after signing up
$f3->route('GET /confirm', function() {

    $GLOBALS['controller']->confirm();

});


//Sign In page
$f3->route('GET|POST /sign-in', function(){

    $GLOBALS['controller']->signIn();

});


//User Dashboard Route
$f3->route('GET|POST /dashboard', function(){

    $GLOBALS['controller']->dashboard();

});

//Workout Options Route
$f3->route('GET|POST /workout_options', function(){

    $GLOBALS['controller']->workout_options();

});

//My Workout Route
$f3->route('GET|POST /myWorkout', function(){

    $GLOBALS['controller']->myWorkout();

});


//My Workout Log Route
$f3->route('GET|POST /myWorkoutLog', function(){

    $GLOBALS['controller']->myWorkoutLog();

});

//Logout Route
$f3->route('GET|POST /logout', function(){

    $GLOBALS['controller']->logout();

});


//Run F3
$f3->run();
