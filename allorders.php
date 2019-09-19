#!/usr/local/bin/php
<?php
    session_name('project'); // name the session
    session_start(); // start a session
    $orders = array();
    $names = array();
    
    
    /**
     This function extracts all order history from file order_history.txt and print them on webpage.
     
     @param array $orders is an array saving strings related to orders
     @param string $names is an array saving names of those who made corresponding orders
     */
    function extractorderhistory(&$orders,&$names){
        
        //read all data
        $fin = fopen('order_history.txt', 'r'); // open file to read
        $everything = fgets($fin); // get the line
        $everything_arr = explode(';', $everything);
        $count = sizeof($everything_arr);
        fclose($fin); // close the file
        
        
        for ($x = 0; $x <= $count; $x++) {//for each order
            $args = explode(':', $everything_arr[$x]);
            $names[$x] =$args[0];
            
                $groups = explode(',', $args[1]);
                $count_group = sizeof($groups)-1;
                
                for($y = 0; $y < $count_group; $y++) {//for each item in order
                    $iteme = explode('.', $groups[$y]);
                    $groups[$y] =$iteme[0].':  '.$iteme[1];
                }
            
                $groups[$count_group+1] = 'Number of books: '.$groups[$count_group];
                $groups[$count_group+2] = 'Total Price: $'.($groups[$count_group]*29.99);
                $groups[$count_group] = '';
                
                $orders[$x] = $groups;
            
            
        }
    }
    
    extractorderhistory($orders,$names);
    
    
    
    if(isset($_POST['regis'])){ // if login is pressed
        header('Location: login.php');
    }
    
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

        <?php  if(!isset($_SESSION['loggedin']) or !$_SESSION['loggedin']) { //visitor?>
                        <input class="button button1" type="submit" name="regis"  value= "Register/Log in" />
            <?php
                } else {  ?>

                        <input class="button button1" type="submit" name="logout"  value= "Log out" />

        <?php    if(!$_SESSION['admin']) { //normal users?>
                        <button class="button button1"> <a href="cart.php" target="_blank"  rel="noopener"  style="color: #FFFFFF"> View Cart</a></button>

                        <button class="button button1"> <a href="myaccount.php" target="_blank" rel="noopener"   style="color: #FFFFFF"> My Account</a></button>
            <?php        }   ?>

        <?php
            
            }?>

    
                </div>
            </form>

            
            
            
            <!-- Here we insert a table that hovers at left side of the page -->

        <form method = "post" action ="<?php echo $_SERVER['PHP_SELF']; ?>">
            <ul>
                <li><a href="index.php">Main Selections</a></li>
            <?php  if(!$_SESSION['admin']) { //normal users or visiters ?>
                    <li><a  href="index2.php" >More Selections</a></li>
            <?php } ?>

            <?php  if($_SESSION['loggedin'] && !$_SESSION['admin']) { //normal users ?>
                    <li><a href="index3.php">Secret Selections</a></li>
                    <li><a href="contact.php">Contact</a></li>
            <?php } ?>

            <?php  if($_SESSION['admin']) { //admin ?>
                    <li><a href="inventory.php">Inventory records</a></li>
                    <li><a class="active">All order history</a></li>
                    <li><a href="msg.php">Message Center</a></li>
            <?php } ?>

            </ul>
        </form>

        <section id = "invent">

            <div id="allorder"> <?php
                $ct = sizeof($orders)-2;
                for ($x = 0; $x <$ct; $x++) {?>
            <h4><b>Order <?php echo($x+1) ?> by <?php echo($names[$x]) ?> :  </b></h4><?php
                $sep = $orders[$x];
                $ctt =sizeof($sep)-1;
                
                    for ($y = 0; $y < $ctt; $y++){
                        echo ($sep[$y]); ?>
                &nbsp;&nbsp;&nbsp;
                <?php  } ?>  <i><br><br><?php
                    
                    for ($y = 0; $y < 2; $y++){
                        echo ($sep[$ctt+$y]); ?>
                <br>
                <?php  } ?>
            </i><br>
            <?php   }?>
            </div>



        </<section



          


    </main>

</body>

</html>
