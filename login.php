#!/usr/local/bin/php
<?php
	session_name('project'); // name the session
	session_start(); // start a session
	$_SESSION['loggedin'] = false; // have not logged in
    $_SESSION['account'] = '';//account name of user
    $_SESSION['email_ad'] = '';//the email put in by user
    $_SESSION['newly_register'] = false;
    $_SESSION['admin'] = false;
    $error = true;
    $msg = ' ';

	/**
	This function validates a email and a corresponding password and sets the $_SESSION token to true
	if it is correct, logging them in and sending them to the main page.
	Otherwise it flags $error as true. The message also changes based on the error made when user attempts to log in.

    @param string $email the email address the user entered
	@param string $password the password the user entered
	@param boolean $error the error flag to possibly change
    @param string $msg the message that should show on website according to the input
	*/
	function validate($email, $password, &$error, &$msg){
        
        //check if it's the admin's account
     
        $fin_im = fopen('admin.txt', 'r');
        $admin = fgets($fin_im);
        $admin_sets = explode(',', $admin);
        if($email === $admin_sets[0] && password_verify($password, $admin_sets[1])){
           $_SESSION['admin'] = true;
           }
        
        
		$fin = fopen('password.txt', 'r'); // open file to read
        $account_exist = false;
            $true_pass = fgets($fin); // get the line
            $true_sets = explode(',', $true_pass);
            $count = (sizeof($true_sets)-1)/2; //number of accounts existed
        
            while($count > 0 && $_SESSION['loggedin'] === false){//compare the input to all existing accounts unless something match
                
                if($email === $true_sets[$count*2-2]){ //check if the email address match
                
                    if(password_verify($password, $true_sets[$count*2-1])){ //check if password match
                        $_SESSION['loggedin'] = true;
                        $_SESSION['email_ad'] = $email;
                        $error = false;
                        $account_exist = true;
                    }else{
                        $account_exist = true;
                    }
                }
            
            $count = $count - 1;
            }
        if($error === false){//if login is successful
            header('Location: index.php');
        }else{
            if($account_exist){//if account exists but password is wrong
                $msg ='Your password is invalid';
            }else{//if account doesn't exist
                $msg ='No such email address. Please register.';
            }
        }
        
		fclose($fin); // close the file
	}
    
    
    
    /**
     This function register new account based on a email and a corresponding password if the combination is valid.
     if it is correct, logging them in and sending them to the main page.
     Otherwise it prints corresponding error message on page.
     
     @param string $email the email address the user entered
     @param string $password the password the user entered
     @param string $msg the message that should show on website according to the input
     */
    function regis($email, $password, &$msg){
        $account_exist = false;
        if(file_exists('password.txt')){//if the file exist, check if the email is already registered
            $fin = fopen('password.txt', 'r'); // open file to read
            $everything = fgets($fin); // get the line
            $everything_arr = explode(',', $everything);
            $count = (sizeof($everything_arr)-1)/2;
            $ind = 0;
            fclose($fin); // close the file
            
            while($ind < $count && !$account_exist){//compare the input email to every existing email
                if($email ===  $everything_arr[$ind*2]){
                    $account_exist = true;
                    $msg = 'Already registered. Please log in/validate.';
                }
                $ind = $ind + 1;
            }
        }
        
        if($account_exist === false){//if the email address does not already exist
            
            
            
            if (strpos($email, '@') !== false && $email[0] !=='@' && $email[strlen($email)-1] !=='@') {//check if the email address contains @ if yes then procees
                if (!preg_match('/[^A-Za-z0-9]/', $password)){//check if password contain anything other than numbers and letters
                    if (strlen($password) >= 6){//check if password is long enough
                        
                        //save name and password
                        $fout = fopen('password.txt','a');
                        $hash = password_hash($password, PASSWORD_DEFAULT);
                        $wr = $email . ',' . $hash . ',';
                        fwrite($fout,$wr);
                        fclose($fout);
                        
                        //log them in
                        $_SESSION['loggedin'] = true;
                        $_SESSION['email_ad'] = $email;
                        $_SESSION['newly_register'] = true;
                        header('Location: index.php');
                    
                        
                    }else{//if password is shorter than 6 characters
                        $msg = 'Your password is not long enough.';
                    }
                }else{//if password contain anything other than numbers and letters
                    $msg = 'Your password should contain letters and digits only.';
                }
            }else{//if the email address doesn't contain @
                $msg = 'Your email address is invalid.';
            }
        }
        
    }
    
    
    
    
    
	if(isset($_POST['login'])){ // if login is pressed
		validate($_POST['email'], $_POST['pass'], $error,$msg); // check it
	}
    
    if(isset($_POST['register'])){ // if register is pressed
        regis($_POST['email'], $_POST['pass'],$msg); // check it
    }
    if(isset($_POST['goback'])){ // if register is pressed
        header('Location: logout.php');
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="proj.css" />
	<title>Login Page</title>
</head>
<body>
    <header>
        <h1>A Random Bookshelf</h1>  <!-- title of the page -->
    </header>

	<main>
		<form id = "loginbuttons" method = "post" action ="<?php echo $_SERVER['PHP_SELF']; ?>">
                Account Name (email address): <input type="textfield" name="email" /><br>
                Password: <input type="password" name="pass" /></input><br>

                <br><br>
                <input class="button button3" type="submit" value="register" name = "register" />
                <input class="button button3" type="submit" value="log in"  name = "login"/>
                <input class="button button3" type="submit" value="go back"  name = "goback"/>
				<p id = "msg">
                    <?php echo($msg) ?>
                </p>
		</form>
	</main>
</body>
</html>
