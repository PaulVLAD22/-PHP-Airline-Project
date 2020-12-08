<?php
$configs = include('config.php');
session_start();
//resetting sign up errors
unset($_SESSION['signinFailed']);
unset($_SESSION['forgotPasswordFailed']);
// verifying CSRF Attack
$token = isset($_SESSION['delete_customer_token']) ? $_SESSION['delete_customer_token'] : "";
//mai verifica alte chestii
if ($token){
    if (isset($_POST["loginPassanger"])){
        if ((isset ($_POST["usernameInput"]) && isset($_POST["passwordInput"]))
        || (!(ctype_alnum($_POST['usernameInput'])) || !(ctype_alnum($_POST['passwordInput'])))){
            $username = htmlspecialchars($_POST["usernameInput"], ENT_QUOTES, 'UTF-8');
            $password = htmlspecialchars($_POST["passwordInput"], ENT_QUOTES, 'UTF-8');

            $uncompletedFields = false;

            if (strlen($username) == 0 || strlen($password) == 0) {
                $uncompletedFields = true;
            }

            $correctAccount = false;

            if (!$uncompletedFields) {//check for all invalid inputs errors
                $dbservername = $configs['host'];
                $dbusername = $configs['username'];
                $dbpassword = $configs['password'];
                $dbName = $configs['dbname'];
                

                $conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbName);

                if ($conn->connect_error)
                    die("Connection failed: " . $conn->connect_error);

                $stmt = $conn->prepare("select * from passenger where username = ?");

                $stmt->bind_param('s',$username);

                $stmt->execute();
                $result = $stmt->get_result();

                $email = '';
                $accountType = '';
                $first_name='';
                $last_name='';
                $date_created='';
                $date_of_birth='';
                $social_status='';
                $status='';


                while ($row = $result->fetch_assoc()){
                    // NU MERGE PASSWORD VERIFY
                    if (password_verify($password,$row['password'])){
                        $email = $row['email'];
                        $first_name = $row['first_name'];
                        $last_name = $row['last_name'];
                        $date_created = $row['date_created'];
                        $date_of_birth = $row['date_of_birth'];
                        $social_status = $row['social_status'];
                        $phone_number = $row['phone_number'];
                        $status = $row['status'];
                        $nationality = $row['nationality'];
                        $correctAccount = true;
                    }
                }
                $stmt->close();
                $conn->close();

            

            if ($correctAccount == true) {
                session_start();
                session_unset();
                //save account details
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;
                $_SESSION['type'] = $accountType;
                $_SESSION['first_name']=$first_name;
                $_SESSION['last_name']=$last_name;
                $_SESSION['date_of_birth']=$date_of_birth;
                $_SESSION['social_status']=$social_status;
                $_SESSION['status']=$status;
                $_SESSION['phone_number']=$phone_number;
                $_SESSION['nationality']=$nationality;
                unset($_SESSION['loggedIn']);
                unset($_SESSION['adminLoggedIn']);
                //
                if ($status=='inactive'){
                    header('location:/activatePage.php');
                }
                else{
                    $_SESSION['loggedIn']=true;
                    header('location:/home.php');
                }
            } else {
                session_start();
                $_SESSION['loginFailed'] = true;
                $_SESSION['loginProblem']='Wrong Details';
                header('location:/index.php');
            }
        } else {
            session_start();
            $_SESSION['loginFailed'] = true;
            $_SESSION['loginProblem'] = 'Uncompleted Fields';
            header('location:/index.php');
            }
        }
        else{
            session_start();
            $_SESSION['loginFailed'] = true;
            $_SESSION['loginProblem'] = 'Stop playing';
            header('location:/index.php');
        }
    }
    else if (isset($_POST['loginAdmin'])){// Admin Login
        if ((isset ($_POST["usernameInput"]) && isset($_POST["passwordInput"]))
        || (!(ctype_alnum($_POST['usernameInput'])) || !(ctype_alnum($_POST['passwordInput'])))){
            $username = htmlspecialchars($_POST["usernameInput"], ENT_QUOTES, 'UTF-8');
            $password = htmlspecialchars($_POST["passwordInput"], ENT_QUOTES, 'UTF-8');

            $uncompletedFields = false;

            if (strlen($username) == 0 || strlen($password) == 0) {
                $uncompletedFields = true;
            }

            $correctAccount = false;

            if (!$uncompletedFields) {//check for all invalid inputs errors
                $dbservername = $configs['host'];
                $dbusername = $configs['username'];
                $dbpassword = $configs['password'];
                $dbName = $configs['dbname'];
                

                $conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbName);

                if ($conn->connect_error)
                    die("Connection failed: " . $conn->connect_error);

                $stmt = $conn->prepare("select * from admin where username = ?");

                $stmt->bind_param('s',$username);

                $stmt->execute();
                $result = $stmt->get_result();

                $email = '';
                $admin_id='';

                while ($row = $result->fetch_assoc()){
                    // NU MERGE PASSWORD VERIFY
                    if ($password==$row['password']){
                        $admin_id = $row['admin_id'];
                        $email = $row['email'];
                        $correctAccount = true;
                    }
                }
                $stmt->close();
                $conn->close();

            

            if ($correctAccount == true) {
                session_start();
                //save account details
                session_unset();
                $_SESSION['username'] = $username;
                $_SESSION['adminLoggedIn']=true;
                $_SESSION['adminId']=$admin_id;
                unset($_SESSION['loggedin']);
                //
                header('location:/adminHome.php');
            } else {
                session_start();
                $_SESSION['loginFailed'] = true;
                $_SESSION['loginProblem']='Wrong Details';
                header('location:/index.php');
            }
        } else {
            session_start();
            $_SESSION['loginFailed'] = true;
            $_SESSION['loginProblem'] = 'Uncompleted Fields';
            header('location:/index.php');
            }
        }
        else{
            session_start();
            $_SESSION['loginFailed'] = true;
            $_SESSION['loginProblem'] = 'Stop playing';
            header('location:/index.php');
        }
    }
}
else{
    session_start();
    session_start();
    $_SESSION['loginFailed'] = true;
    $_SESSION['loginProblem'] = 'CSRF attack attempted';
    header('location:/index.php');
}
?>
