#!/usr/local/bin/php
<?php
    session_name('project'); // name the session
    session_start(); // start a session
    $_SESSION['email_ad'];//the email put in by user
    $_SESSION['loggedin'];
    $_SESSION['admin'];
    $fromjs = 'not yet';//cart information sent from javascript
    $cartlist = array();
    
    
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
                    }else{  ?>
                            <input class="button button1" type="submit" name="logout"  value= "Log out" />
                <?php  if(!$_SESSION['admin']) { ?>
                            <button class="button button1"> <a href="cart.php" target="_blank"  rel="noopener" style="color: #FFFFFF"> View Cart</a></button>

                        <!-- This part of style doesn't work when put into css for the nature of href -->

                            <button class="button button1"> <a href="myaccount.php" target="_blank" rel="noopener" style="color: #FFFFFF"> My Account</a></button>
                   <?php   }   ?>

                <?php } ?>

                </div>
            </form>

            <!-- Here we insert a table that hovers at left side of the page -->

        <form method = "post" action ="<?php echo $_SERVER['PHP_SELF']; ?>">
            <ul>

                    <li><a href="#home" class="active">Main Selections</a></li>
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
                    <li><a href="msg.php">Message Center</a></li>
            <?php } ?>


            </ul>
        </form>

        <!-- Here are images we use on the website -->
        <?php if($_SESSION['loggedin'] !== true){   //only useful if user already logged in?>
            <form method = "post" action ="<?php echo $_SERVER['PHP_SELF']; ?>">
        <?php  }   ?>

            <table id = "books">
                <tbody>
                    <tr>
                        <th>
                             <table id = "b1">
                                 <tbody>
                                     <tr><th><img src="alice1.jpg" alt="Alice in Wonderland, Lewis Carroll" id="alice1" title="b1" width = "300"  /></tr></th>
                                    <tr><th>Alice in Wonderland: $29.99</th> </tr>
                                    <tr><th>
                                    <?php if($_SESSION['loggedin'] === true){   ?>
                                        <button class="button button2" onclick="openForm('myForm1')">Add to Cart</button>

                                        <div class="form-popup" id="myForm1">
                                            <form action="/action_page.php" class="form-container">
                                            number: <input type="text" id="sec1" value="1" required> <br>
                                                <button type="reset" class="btn" onclick="addcart('Alice in Wonderland','sec1',1)">Add</button>
                                                <button type="button" class="btn cancel" onclick="closeForm('myForm1')">Close</button>
                                            </form>
                                        </div>
                                    <?php }  ?>
                                    </th> </tr>
                                </tbody>
                            </table>
                        </th>
                        <th>
                        <table id = "b2">
                            <tbody>
                                <tr><th><img src="expect1.jpg" alt="the Great Expectations,Charles Dickens" id="expect1" title="b2" width = "300"  /></tr></th>
                                <tr><th>The Great Expectations: $29.99</th> </tr>
                                <tr><th>
                                    <?php if($_SESSION['loggedin'] === true){   ?>
                                        <button class="button button2" onclick="openForm('myForm2')">Add to Cart</button>
                                        <div class="form-popup" id="myForm2">
                                            <form action="/action_page.php" class="form-container">
                                            number: <input type="text" id="sec2" value="1" required> <br>
                                                <button type="reset" class="btn" onclick="addcart('The Great Expectations','sec2',2)">Add</button>
                                                <button type="button" class="btn cancel" onclick="closeForm('myForm2')">Close</button>
                                            </form>
                                        </div>
                                    <?php }  ?>
                                </th> </tr>
                            </tbody>
                        </table>
                        </th>
                        <th>
                            <table id = "b3">
                                <tbody>
                                <tr><th><img src="none1.jpg" alt="And Then There Were None, Agatha Christie" id="none1" title="b3" width = "300"  /></tr></th>
                                <tr><th>And Then There Were None: $29.99</th> </tr>
                                <tr><th>
                                    <?php if($_SESSION['loggedin'] === true){   ?>
                                            <button class="button button2" onclick="openForm('myForm3')">Add to Cart</button>
                                        <div class="form-popup" id="myForm3">
                                            <form action="/action_page.php" class="form-container">
                                                number: <input type="text" id="sec3" value="1" required> <br>
                                                <button type="reset" class="btn" onclick="addcart('And Then There Were None','sec3',3)">Add</button>
                                                <button type="button" class="btn cancel" onclick="closeForm('myForm3')">Close</button>
                                            </form>
                                        </div>
                                    <?php }  ?>
                                </th> </tr>
                            </th> </tr>
                        </tbody>
                        </table>
                        </th>
                    </tr>
                    <tr>
                        <th>
                            <table id = "b4">
                                <tbody>
                                <tr><th><img src="hamlet1.jpg" alt="Hamlet, Shakespeare" id="hamlet1" title="b4" width = "300"  /></tr></th>
                                <tr><th>Hamlet: $29.99</th> </tr>
                                <tr><th>
                                    <?php if($_SESSION['loggedin'] === true){   ?>
                                            <button class="button button2" onclick="openForm('myForm4')">Add to Cart</button>

                                        <div class="form-popup" id="myForm4">
                                            <form action="/action_page.php" class="form-container">
                                                number: <input type="text" id="sec4" value="1" required> <br>
                                                <button type="reset" class="btn" onclick="addcart('Hamlet','sec4',4)">Add</button>
                                                <button type="button" class="btn cancel" onclick="closeForm('myForm4')">Close</button>
                                            </form>
                                        </div>
                                    <?php }  ?>
                                </th> </tr>
                        </tbody>
                        </table>
                        </th>
                        <th>
                            <table id = "b5">
                                <tbody>
                                <tr><th><img src="republic1.jpg" alt="the Republic, Plato" id="republic1" title="b5" width = "300"  /></tr></th>
                                <tr><th>The Republic: $29.99</th> </tr>
                                <tr><th>
                                    <?php if($_SESSION['loggedin'] === true){   ?>
                                    <button class="button button2" onclick="openForm('myForm5')">Add to Cart</button>
                                        <div class="form-popup" id="myForm5">
                                            <form action="/action_page.php" class="form-container">
                                                number: <input type="text" id="sec5" value="1" required> <br>
                                                <button type="reset" class="btn" onclick="addcart('The Republic','sec5',5)">Add</button>
                                                <button type="button" class="btn cancel" onclick="closeForm('myForm5')">Close</button>
                                            </form>
                                        </div>
                                    <?php }  ?>

                                </th> </tr>
                        </tbody>
                        </table>
                        </th>
                        <th>
                            <table id = "b6">
                                <tbody>
                                <tr><th><img src="sense1.jpg" alt="Sense and Sensibility, Jane Austen" id="sense1" title="b6" width = "300"  /></tr></th>
                                <tr><th>Sense and Sensibility: $29.99</th> </tr>
                                <tr><th>
                                     <?php if($_SESSION['loggedin'] === true){   ?>
                                            <button class="button button2" onclick="openForm('myForm6')">Add to Cart</button>

                                        <div class="form-popup" id="myForm6">
                                            <form action="/action_page.php" class="form-container">
                                                number: <input type="text" id="sec6" value="1" required> <br>
                                                <button type="reset" class="btn" onclick="addcart('Sense and Sensibility','sec6',6)">Add</button>
                                                <button type="button" class="btn cancel" onclick="closeForm('myForm6')">Close</button>
                                            </form>
                                        </div>
                                    <?php }  ?>

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
