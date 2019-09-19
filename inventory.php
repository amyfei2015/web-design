#!/usr/local/bin/php
<?php
    session_name('project'); // name the session
    session_start(); // start a session
    $number = array();
    $booknames = array('Alice in Wonderland','The Great Expectations','And Then There Were None','Hamlet','The Republic','Sense and Sensibility','The Wizard of Oz','Hans Christian Andersens Fairy Tales','A Tale of Two Cities','Oliver Twist','The Murder of Roger Ackroyd','Pride and Prejudice','Macbeth','Twelfth Night');
    
    /**
     This extracts inventory and print them on webpage from file inventory.txt.
     
     @param array $number saves corresponding number of books purchased in each order
     */
    function extractinventory(&$number){
        $fin = fopen('inventory.txt', 'r'); // open file to read
        $everything = fgets($fin); // get the line
        $number = explode(',', $everything);
    }
    extractinventory($number);

    
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
    <script src="proj.js" defer ></script>
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
                    <button class="button button1"> <a href="cart.php" target="_blank" rel="noopener"   style="color: #FFFFFF"> View Cart</a></button>

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
                    <li><a class="active">Inventory records</a></li>
                    <li><a href="allorders.php">All order history</a></li>
                    <li><a href="msg.php">Message Center</a></li>
            <?php } ?>


            </ul>
        </form>


        <div id="allorders"> <?php
                $ct = 14;//number of items in total
                for ($x = 0; $x <$ct; $x++) {?>
            <b><?php echo($booknames[$x]) ?> :  </b><?php
               echo($number[$x]) ?>  left. <br>
                <?php }  ?>

        </div>


    </main>

</body>

</html>
