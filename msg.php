#!/usr/local/bin/php
<?php
    session_name('project'); // name the session
    session_start(); // start a session
    $number = array();
    $_SESSION['email_ad'];//the email put in by user
    $msgfromjs = '';
    $msgbreak = 'ksabdnvahjcbl78432r89a';//some random break that is unlikly to be natually typed and thus serve as a break between different messages, same as that in contact.php
    $msgs = array();
    

    
    /**
     This function extracts all messages from file message.txt and print them on webpage.
     
     @param string $msgs is an array saving strings related to message
     @param string $msgbreak is a random string created to seperate each message, that is unlikely to appear in a regular message
     */
    function extractmessage(&$msgs,$msgbreak){
        
        $fin = fopen('message.txt', 'r'); // open file to read
        $everything = fgets($fin); // get the line
        $allmsgs = explode($msgbreak, $everything);
        $ctt = sizeof($allmsgs)-1;

        
        for ($x = 0; $x <$ctt; $x++) {//for each message
            $eachone = array();
            $allineach = explode(';',$allmsgs[$x]);
            $eachone[0] =$allineach[0];
            $eachone[1] =$allineach[1];
            $eachone[2] =$allineach[2];
            $eachone[3] =$allineach[3];
            
            $cttt = sizeof($eachone)-1;
            if($cttt>3){//the message contains ';' so that they are seperated into array elements
                $tmpp =array();
                for($y = 0; $y <$ctt-3; $y++){
                    $tmpp[$y] =$eachone[$y+3];
                }
                 $eachone[3] =implode(';', $tmpp);
            }
           
            $msgs[$x]=$eachone;
        }
        
    }
    
    extractmessage($msgs,$msgbreak);

    
    if(isset($_POST['logout'])){ // if logout is pressed
        header('Location: logout.php');
    }

    
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="proj.css" />
    <title>A Random Bookshelf</title>
    <script src="proj.js" defer></script>
</head>

<body>
    <header>
        <h1>A Random Bookshelf</h1>  <!-- title of the page -->
    </header>

    <main>
        <article id="mainpart">

        <p><?php
                //alert("register successful");
                $message = 'register successful';
            if($_SESSION['newly_register']){//if newly registered
                echo "<script type='text/javascript'>alert('$message');</script>";
                $_SESSION['newly_register'] = false;
            }
            ?></p>


            
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
        <?php        }   ?>

        <?php
        
        }?>
    
                </div>
            </form>

            
            
            
            <!-- Here we insert a table that hovers at left side of the page -->

        <form method = "post" action ="<?php echo $_SERVER['PHP_SELF']; ?>">
            <ul>
                    <li><a href="index.php" >Main Selections</a></li>
            <?php  if(!$_SESSION['admin']) { ?>
                    <li><a  href="index2.php" >More Selections</a></li>
            <?php } ?>

            <?php  if($_SESSION['loggedin'] && !$_SESSION['admin']) { ?>
                    <li><a href="index3.php">Secret Selections</a></li>
                    <li><a href="contact.php">Contact</a></li>
            <?php } ?>

            <?php  if($_SESSION['admin']) { ?>
                    <li><a href="inventory.php">Inventory records</a></li>
                    <li><a href="allorders.php">All order history</a></li>
                    <li><a class="active">Message Center</a></li>
            <?php } ?>

            </ul>
        </form>

            <div id="allorders"> <?php
                $ct = sizeof($msgs);//number of items in total
                for ($x = 0; $x <$ct; $x++) {
                        $temp = $msgs[$x];
                    
                        ?><b><?php echo($temp[0]) ?>: </b><br>
                        <?php echo($temp[1]) ?> <br>
                        Selection: <?php echo($temp[2]) ?> <br>
                        Message: <?php echo($temp[3]) ?> <br>
                    <br>

               <?php } ?>

            </div>



    </main>

</body>

</html>
