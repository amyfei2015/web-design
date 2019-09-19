#!/usr/local/bin/php
<?php
    session_name('project'); // name the session
    session_start(); // start a session
    $item_number = 0;
    
    /**
     This function print things in cart on webpage.
     
     @param array $cartlist is an array saving items in cart
     @param array $item_number is an array saving corresponding number of items in cart
     */
    function viewcart(&$cartlist, &$item_number){
        $fin = fopen('cart.txt', 'r'); // open file to read
        $everything = fgets($fin); // get the line
        $everything_arr = explode(';', $everything);
        $count = sizeof($everything_arr)-1;
        fclose($fin); // close the file
        
        $print = '';
        
        for ($x = 0; $x <= $count; $x++) {//for eah item
            $args = explode(',', $everything_arr[$x]);
            $cartlist[$x] = $args[2].":\t".$args[0];
            $item_number = $item_number + intval($args[0]);
        }
        
    }
    
    viewcart($cartlist, $item_number);
    
    
    /**
     This function saves the order history when order is made to file order_history.txt.
     
     */
    function saveorderhistory(){
        
        //read all data
        $cartlist = array();
        $fin = fopen('cart.txt', 'r'); // open file to read
        $everything = fgets($fin); // get the line
        if(!empty($everything)){//only save order history if the cart is not empty
            $everything_arr = explode(';', $everything);
            $count = sizeof($everything_arr)-1;
            fclose($fin); // close the file
            
            //save all data into a string
            $wr =$_SESSION['email_ad'].':';
            $item_count = 0;
            
            for ($x = 0; $x < $count; $x++) {
                $args = explode(',', $everything_arr[$x]);
                $item_count = $item_count + intval($args[0]);
                $sv = explode("\t", $cartlist[x]);
                $wr= $wr.$args[2].'.'.$args[0].',';
            }
            
            $wr=$wr.$item_count.';';
            //write them into order history
            $fout = fopen('order_history.txt','a');
            fwrite($fout,$wr);
            fclose($fout);
            
        }
        
    }
    /**
     This function update the invetory when order is made in inventory.txt.
     
     */
    function updateinventory(){
        //read old invebtory count
        $fin = fopen('inventory.txt', 'r'); // open file to read
        $everything = fgets($fin); // get the line
        $everything_arr = explode(',', $everything);
        $count = sizeof($everything_arr)-1;
        fclose($fin); // close the file
        
        //read cart
        $fin_new = fopen('cart.txt', 'r'); // open file to read
        $everything_new = fgets($fin_new); // get the line
        $everything_arr_new = explode(';', $everything_new);
        $count_new = sizeof($everything_arr_new)-1;
        fclose($fin_new); // close the file
        
        //update inventory
        for ($x = 0; $x < $count_new; $x++) {//for each item
            $args = explode(',', $everything_arr_new[$x]);
            $ind = intval($args[1])-1;
            $num = intval($args[0]);
            $everything_arr[$ind] = $everything_arr[$ind] -$num;
        }
        //write back new inventory
        $new_invent = '';
        for ($x = 0; $x < $count; $x++) {//for each item
            $new_invent = $new_invent.$everything_arr[$x].',';
        }
        $fout = fopen('inventory.txt','w');
        fwrite($fout,$new_invent);
        fclose($fout);
        
        
        
    }
    
    /**
     This clears everythin in cart.
     
     */
    function cleancart(){
        $fout = fopen('cart.txt','w');
        fwrite($fout,'');
        fclose($fout);
         header('Location: cart.php');
        
    }
    
    
    /*
     1. record order history to individual user
     2. decrease counts for inventory: read from file the numbers for each item, then decrease,then save back
     3. clear cart
     
     */
    function checkout(){
        saveorderhistory();
        updateinventory();
        cleancart();
        
    }
    
    if(isset($_POST['checkout'])){ // if logout is checkout is pressed
        checkout();
    }
    
    if(isset($_POST['clearcart'])){ // if clearcart is pressed
        cleancart();
    }
    
    

    
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="cart.css" />
    <title>Cart Summary</title>
    <script src="proj.js" defer></script>
</head>

<body>
    <header>
        <h1>Cart Summary</h1>  <!-- title of the page -->
    </header>

    <main>

        <!-- the cart -->

        <div id="cart"> <?php
                $ct = sizeof($cartlist)-1;
                for ($x = 0; $x < $ct; $x++) {
                    echo ($cartlist[$x]);?>
                    <br>
                <?php   }?>
                <hr>
                    Total price is <?php echo($item_number) ?> x $29.99 = <?php echo($item_number*29.99) ?>

            <br>
             <form method = "post" action ="<?php echo $_SERVER['PHP_SELF']; ?>">
            <br>
                <input class="button button2" type="submit" value="Remove all items" name = "clearcart" />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input class="button button2" type="submit" value="Check out" name = "checkout" />
             </form>
        </div>


    </main>

</body>

</html>
