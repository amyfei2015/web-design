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
    <link rel="stylesheet" type="text/css" href="proj2.css" />
    <title>A Random Bookshelf</title>
    <script src="proj2.js" defer></script>

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

                            <button class="button button1"> <a href="cart.php" target="_blank" rel="noopener" style="color: #FFFFFF"> View Cart</a></button>

                            <button class="button button1"> <a href="myaccount.php" target="_blank" rel="noopener"  style="color: #FFFFFF"> My Account</a></button>
                <?php } ?>

                    </div>
                </form>

            
            
            
            <!-- Here we insert a table that hovers at left side of the page -->

        <form method = "post" action ="<?php echo $_SERVER['PHP_SELF']; ?>">
            <ul>
                    <li><a  href="index.php" >Main Selections</a></li>
            <?php  if(!$_SESSION['admin']) { ?>
                    <li><a  href="index2.php" class="active">More Selections</a></li>
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


            <!-- Here are three images we use on the website -->
            <?php if($_SESSION['loggedin'] !== true){   ?>
                <form method = "post" action ="<?php echo $_SERVER['PHP_SELF']; ?>">
            <?php  }   ?>


            <table id = "books">
                <tbody>
                    <tr>
                        <th>
                            <table id = "b11">
                                <tbody>
                                    <tr><th><img src="roger.jpg" alt="The Murder of Roger Ackroyd" id="rog1" title="b11" width = "300"  /></tr></th>
                                    <tr><th>The Murder of Roger Ackroyd: $29.99</th> </tr>
                                    <tr><th>
                                    <?php if($_SESSION['loggedin'] === true){   ?>
                                            <button class="button button2" onclick="openForm('myForm11')">Add to Cart</button>

                                        <div class="form-popup" id="myForm11">
                                            <form action="/action_page.php" class="form-container">
                                                number: <input type="text" id="sec11" value="1" required> <br>
                                                <button type="reset" class="btn" onclick="addcart('The Murder of Roger Ackroyd','sec11',11)">Add</button>
                                                <button type="button" class="btn cancel" onclick="closeForm('myForm11')">Close</button>
                                            </form>
                                        </div>
                                    <?php }  ?>


                    </th> </tr>
                                </tbody>
                            </table>
                        </th>
                        <th>
                            <table id = "b7">
                                <tbody>
                                    <tr><th><img src="oz1.jpg" alt="The Wizard of Oz" id="oz1" title="b7" width = "300"  /></tr></th>
                                    <tr><th>The Wizard of Oz: $29.99</th> </tr>
                                    <tr><th>
                                     <?php if($_SESSION['loggedin'] === true){   ?>
                                            <button class="button button2" onclick="openForm('myForm7')">Add to Cart</button>

                                        <div class="form-popup" id="myForm7">
                                            <form action="/action_page.php" class="form-container">
                                                number: <input type="text" id="sec7" value="1" required> <br>
                                                <button type="reset" class="btn" onclick="addcart('The Wizard of Oz','sec7',7)">Add</button>
                                                <button type="button" class="btn cancel" onclick="closeForm('myForm7')">Close</button>
                                            </form>
                                        </div>
                                    <?php }  ?>

                            </th> </tr>
                                </tbody>
                            </table>
                        </th>
                        <th>
                            <table id = "b8">
                                <tbody>
                                    <tr><th><img src="anderson1.jpg" alt="Hans Christian Andersen's Fairy Tales" id="and1" title="b8" width = "300"  /></tr></th>
                                    <tr><th>Hans Christian Andersen's Fairy Tales: $29.99</th> </tr>
                                    <tr><th>
                                     <?php if($_SESSION['loggedin'] === true){   ?>
                                            <button class="button button2" onclick="openForm('myForm8')">Add to Cart</button>
                                        <div class="form-popup" id="myForm8">
                                            <form action="/action_page.php" class="form-container">
                                                number: <input type="text" id="sec8" value="1" required> <br>
                                                <button type="reset" class="btn" onclick="addcart('Hans Christian Andersen\'s Fairy Tales','sec8',8)">Add</button>
                                                <button type="button" class="btn cancel" onclick="closeForm('myForm8')">Close</button>
                                            </form>
                                        </div>
                                    <?php }  ?>

                            </th> </tr>
                                </tbody>
                            </table>
                        </th>
                    </tr>
                    <tr>
                        <th>
                            <table id = "b12">
                                <tbody>
                                    <tr><th><img src="pride.jpg" alt="Pride and Prejudice" id="pride1" title="b12" width = "300"  /></tr></th>
                                    <tr><th>Pride and Prejudice: $29.99</th> </tr>
                                    <tr><th>
                                     <?php if($_SESSION['loggedin'] === true){   ?>
                                            <button class="button button2" onclick="openForm('myForm12')">Add to Cart</button>
                                        <div class="form-popup" id="myForm12">
                                            <form action="/action_page.php" class="form-container">
                                                number: <input type="text" id="sec12" value="1" required> <br>
                                                <button type="reset" class="btn" onclick="addcart('Pride and Prejudice','sec12',12)">Add</button>
                                                <button type="button" class="btn cancel" onclick="closeForm('myForm12')">Close</button>
                                            </form>
                                        </div>
                                    <?php }  ?>

                                    </th></tr>
                                </tbody>
                            </table>
                        </th>
                        <th>
                            <table id = "b9">
                                <tbody>
                                    <tr><th><img src="tale1.jpg" alt="A Tale of Two Cities" id="tale1" title="b9" width = "300"  /></tr></th>
                                    <tr><th>A Tale of Two Cities: $29.99</th> </tr>
                                    <tr><th>
                                     <?php if($_SESSION['loggedin'] === true){   ?>
                                            <button class="button button2" onclick="openForm('myForm9')">Add to Cart</button>
                                        <div class="form-popup" id="myForm9">
                                            <form action="/action_page.php" class="form-container">
                                                number: <input type="text" id="sec9" value="1" required> <br>
                                                <button type="reset" class="btn" onclick="addcart('A Tale of Two Cities','sec9',9)">Add</button>
                                                <button type="button" class="btn cancel" onclick="closeForm('myForm9')">Close</button>
                                            </form>
                                        </div>
                                    <?php }  ?>
                                    </th> </tr>
                                </tbody>
                            </table>
                        </th>

                        <th>
                            <table id = "b10">
                                <tbody>
                                    <tr><th><img src="twist1.jpeg" alt="Oliver Twist" id="twist1" title="b10" width = "300"  /></tr></th>
                                    <tr><th>Oliver Twist: $29.99</th> </tr>
                                    <tr><th>
                                     <?php if($_SESSION['loggedin'] === true){   ?>
                                            <button class="button button2" onclick="openForm('myForm10')">Add to Cart</button>
                                        <div class="form-popup" id="myForm10">
                                            <form action="/action_page.php" class="form-container">
                                                number: <input type="text" id="sec10" value="1" required> <br>
                                                <button type="reset" class="btn" onclick="addcart('Oliver Twist','sec10',10)">Add</button>
                                                <button type="button" class="btn cancel" onclick="closeForm('myForm10')">Close</button>
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
