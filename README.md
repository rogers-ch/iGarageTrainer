# iGarageTrainer
## Project Requirements
### Separates all database/business logic using the MVC pattern.
We have separate model, views, and controllers folders to hold the files for each part of the MVC
pattern. All of our data arrays and the functions that deal with our data are included in the model folder.
We created a "class"ified database.php file that connects to the database with PDO and reads and writes to the 
database using prepared statements.   

### Routes all URLs and leverages a templating language using the Fat-Free framework.
All routing is handled through the Fat-Free framework, and no pages can be reached directly without using the correct 
route name. Templates are used to render views. Templates are used within views to include data from the model 
(including data from users, the database, and the data-layer.php file).  

### Has a clearly defined database layer using PDO and prepared statements. You should have at least two related tables.
Our model folder includes a "class"ified database.php file that connects to the database using a PDO object. All of 
the methods in our Database class read from and write to the database using prepared statements. Our database includes 
seven tables. The connections among the tables can be seen in our ER diagram. There is a link to the ER diagram at the 
bottom of this README file.

### Data can be viewed and added.
New users can create an account, and their information is added to the database. When a user is logged in, they can 
generate new workouts based on their account information. Each new workout is displayed for the user and saved to the 
database. The user can also view a log of all their workouts from the past 14 days, and that information is also 
retrieved from the database.  

### Has a history of commits from both team members to a Git repository. Commits are clearly commented.
Our commit history is available for review at the following link: 
https://github.com/rogers-ch/iGarageTrainer/commits/master

### Uses OOP, and defines multiple classes, including at least one inheritance relationship.
We defined the following four classes for the real-world objects in our project: User, PremiumUser, Exercise, and 
Workout. These classes can be found in the classes folder. New users can sign up as either a standard User or a PremiumUser.  Their is an inheritance relationship
between the User and PremiumUser classes.  PremiumUser extends User, and PremiumUsers can provide additional 
information regarding fitness level and exercise equipment so they can get a more personalized workout. 

### Contains full Docblocks for all PHP files and follows PEAR standards.
Our PHP files all include Docblock comment headers. Our classes all have class level Docblock comments and Docblock 
comments for all public functions. We also worked to follow PEAR standards throughout our code.  

### Has full validation on the client side through JavaScript and server side through PHP.
Our new member sign-up forms include PHP validation. We check to make sure that name fields are not empty,
age is between 18 and 118, and username is between 5 and 15 characters. Passwords must between 8 and 15 characters 
long, have at least one uppercase letter, and contain one of 5 special characters. We included a password confirm
field that must match with the first password entered. All form fields except for the password fields are sticky. We
also check additional radio button and checkbox fields on sign-up page 2 to make sure selections have been made and
that no spoofing has been attempted. We also included PHP validation on the member sign-in form.

### All code is clean, clear, and well-commented. DRY (Don't Repeat Yourself) is practiced.
We spaced and indented our code properly, and our code is well-commented. We avoided repeating code by creating 
functions for commonly used code and by using repeat blocks and templates in our views. Examples of our use
of repeat blocks can be seen in the following views: signup_second.html, workoutLog.html, and workoutView.html.

### Your submission shows adequate effort for a final project in a full-stack web development course.
We spent considerable time designing and implementing our project. We worked hard, and as a result we have a functional 
web application that meets the project requirements.  

## UML class diagram
https://github.com/rogers-ch/iGarageTrainer/blob/master/images/iGarageTrainer_UML_Diagram.png

## ER database diagram
https://github.com/rogers-ch/iGarageTrainer/blob/master/images/ERDiagram.jpg


