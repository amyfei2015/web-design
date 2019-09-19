#!/usr/local/bin/php
<?php
    session_name('project'); // name the session
    session_start(); // start a session
    $_SESSION['email_ad'];//the email put in by user
    $msgfromjs = 'No message uploaded yet. ';
    $msgbreak = 'ksabdnvahjcbl78432r89a';//some random break that is unlikly to be natually typed and thus serve as a break between different messages, same as that in allorders.php
    
    if(isset($_POST['logout'])){ // if logout is pressed
        header('Location: logout.php');
    }
    
    /**
     This function saves all messages temporarily in file message.txt.
     
     @param string $fromjs is the message obtained in js; this is sent from javascript
     @param string $msgbreak is a random string created to seperate each message, that is unlikely to appear in a regular message
     */
    function add_message_to_record($fromjs,$msgbreak){
        $fout = fopen('message.txt','a');
        $wr =$_SESSION['email_ad'].';'.$fromjs . $msgbreak;
        fwrite($fout,$wr);
        fclose($fout);
        
    }
    
    //when a new message is saved
    if(isset($_GET['msgfromjs'])) {
        $msgfromjs = $_GET['msgfromjs'];
        add_message_to_record($msgfromjs,$msgbreak);
    }
    
    
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="proj.css" />
    <title>A Random Bookshelf</title>
    <script src="contact.js" defer ></script>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
</head>

<body>
    <header>
        <h1>A Random Bookshelf</h1>  <!-- title of the page -->
    </header>

    <main>
        <article id="mainpart">



            
            <!-- login stuff -->
            <form method = "post" action ="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div id="headerBar">


        <?php  if(!isset($_SESSION['loggedin']) or !$_SESSION['loggedin']) { ?>
                    <input class="button button1" type="submit" name="regis"  value= "Register/Log in" />
            <?php
            } else {  ?>

                    <input class="button button1" type="submit" name="logout"  value= "Log out" />

        <?php    if(!$_SESSION['admin']) { ?>
                    <button class="button button1"> <a href="cart.php" target="_blank" rel="noopener"  style="color: #FFFFFF"> View Cart</a></button>

                    <button class="button button1"> <a href="myaccount.php" target="_blank" rel="noopener"  style="color: #FFFFFF"> My Account</a></button>
            <?php        }
                } ?>

    
                </div>
            </form>

            

            <!-- Here we insert a table that hovers at left side of the page -->

        <form method = "post" action ="<?php echo $_SERVER['PHP_SELF']; ?>">
            <ul>
                <li><a href="index.php">Main Selections</a></li>
                <li><a  href="index2.php" )>More Selections</a></li>

<?php  if($_SESSION['loggedin']) { ?>
                <li><a href="index3.php">Secret Selections</a></li>
                <li><a  class="active">Contact</a></li>
<?php
    } ?>

            </ul>
        </form>

        <form id = "feedback"  method = "post" action ="<?php echo $_SERVER['PHP_SELF']; ?>">
                <fieldset id="radiopart">
                    <p>
                        <h2>What is your question about?</h2>
                    </p>
                    <p>
                        <label for="pt1"> Request New Collection</label>
                        <input type="radio" id="pt1" value="Request New Collection" name="Chooseq" />
                        <label for="pt2"> Return Items</label>
                        <input type="radio" id="pt2" value="Return Items" name="Chooseq" />
                        <label for="pt3"> Other Questions</label>
                        <input type="radio" id="pt3" value="Other Questions" name="Chooseq" checked/>
                    </p>
                </fieldset>
                <fieldset id="essaypart">
                        <p>
                            Type your comments here:<br>
                        </p>
                        <textarea rows="8" cols="100" id ="essay" style="font-family:Times New Roman,cursuve;font-size: 20px"> </textarea>
                </fieldset>
                <fieldset id="submitpart">
                    <p>
                        <input type="reset" class = "button button1" name = "resp" value="Submit" onclick= submitfeedback() />
                        <input type="reset" class = "button button1"  value="Reset" onclick="" />
                    </p>
                    <p id = "test"> <?php echo ($msgfromjs); ?></p>

                </fieldset>
        </form>



    </main>

</body>

</html>
