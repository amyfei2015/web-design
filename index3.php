#!/usr/local/bin/php
<?php
    session_name('project'); // name the session
    session_start(); // start a session
    
    
    if(isset($_POST['regis'])){ // if register/login is pressed
        header('Location: login.php');
    }
    
    if(isset($_POST['logout'])){ // if logout is pressed
        header('Location: logout.php');
    }
    
    /**
     This function saves all cart information temporarily in cart.txt.
     
     @param string $fromjs is the item user just add to cart; this is sent from javascript
     */
    function add_item_to_record($fromjs){
        $fout = fopen('cart.txt','a');
        $wr =$fromjs . ';';
        fwrite($fout,$wr);
        fclose($fout);
        
    }
    
     //if user add something new to cart
    if(isset($_GET['fromjs'])) {
        $fromjs = $_GET['fromjs'];
        add_item_to_record($fromjs);
    }
    

    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="proj3.css" />
    <title>A Random Bookshelf</title>
    <script src="proj3.js" defer></script>

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
            <?php  } else {  ?>
                            <input class="button button1" type="submit" name="logout"  value= "Log out" />

                            <button class="button button1"> <a href="cart.php" target="_blank"  rel="noopener" style="color: #FFFFFF"> View Cart</a></button>

                            <button class="button button1"> <a href="myaccount.php" target="_blank"  rel="noopener" style="color: #FFFFFF"> My Account</a></button>
<?php
    
    }?>


                    </div>
                </form>

            
            
            
            <!-- Here we insert a table that hovers at left side of the page -->

        <form method = "post" action ="<?php echo $_SERVER['PHP_SELF']; ?>">
            <ul>
                <li><a  href="index.php" >Main Selections</a></li>
                <li><a href="index2.php" >More Selections</a></li>
<?php  if($_SESSION['loggedin']) { ?>
                <li><a href="#contact" class="active">Secret Selections</a></li>
                <li><a href="contact.php">Contact</a></li>

<?php
    } ?>
            </ul>
        </form>


            <!-- Here are three images we use on the website -->
            <?php if($_SESSION['loggedin'] !== true){   ?>
                <form method = "post" action ="<?php echo $_SERVER['PHP_SELF']; ?>">
            <?php  }   ?>


            <table id = "books">
                <tbody>
                    <tr>
                        <th>
                            <table id = "b13">
                                <tbody>
                                <tr><th><img src="macbeth1.jpg" alt="Macbeth" id="mac1" title="b13" width = "300"  /></tr></th>
                                    <tr><th>Macbeth: $29.99</th> </tr>
                                    <tr><th>
                                            <button class="button button2" onclick="openForm('myForm13')">Add to Cart</button>

                                        <div class="form-popup" id="myForm13">
                                            <form action="/action_page.php" class="form-container">
                                                number: <input type="text" id="sec13" value="1" required> <br>
                                                <button type="reset" class="btn" onclick="addcart('*Macbeth','sec13',13)">Add</button>
                                                <button type="button" class="btn cancel" onclick="closeForm('myForm13')">Close</button>
                                            </form>
                                        </div>
                                    </th> </tr>
                                </tbody>
                            </table>
                        </th>
                        <th>
                            <table id = "b14">
                                <tbody>
                                    <tr><th><img src="twelfth.jpg" alt="Twelfth Night" id="tn1" title="b14" width = "300"  /></tr></th>
                                    <tr><th>Twelfth Night: $29.99</th> </tr>
                                    <tr><th>

                                            <button class="button button2" onclick="openForm('myForm14')">Add to Cart</button>

                                        <div class="form-popup" id="myForm14">
                                            <form action="/action_page.php" class="form-container">
                                                number: <input type="text" id="sec14" value="1" required> <br>
                                                <button type="reset" class="btn" onclick="addcart('*Twelfth Night','sec14',14)">Add</button>
                                                <button type="button" class="btn cancel" onclick="closeForm('myForm14')">Close</button>
                                            </form>
                                        </div>
                                    </th> </tr>
                                </tbody>
                            </table>
                        </th>
                    </tr>

                </tbody>
            </table>
            <?php if($_SESSION['loggedin'] !== true){   ?>
                </form>
            <?php  }   ?>


    </main>

</body>

</html>
