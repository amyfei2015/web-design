#!/usr/local/bin/php
<?php
    session_name('project'); // name the session
    session_start(); // start a session
    $orders = array();
    $noorder = '';

    
    
    /**
     This extracts order history for the user and print them on webpage from file order_history.txt.
     
     @param array $orders saves corresponding orders
     @param string $noorder is a string that becomes a message if the user has no order history
     */
    function extractorderhistory(&$orders, &$noorder){
        
        //read all data
        $fin = fopen('order_history.txt', 'r'); // open file to read
        $everything = fgets($fin); // get the line
            $everything_arr = explode(';', $everything);
            $count = sizeof($everything_arr);
            fclose($fin); // close the file
            
            
            $index = 0;
            
            for ($x = 0; $x <= $count; $x++) {//for each order
                $args = explode(':', $everything_arr[$x]);
                if($args[0] === $_SESSION['email_ad']){ //if the account name match
                    $groups = explode(',', $args[1]);
                        $count_group = sizeof($groups)-1;
                    
                        for($y = 0; $y < $count_group; $y++) {//for each item in the order
                            $iteme = explode('.', $groups[$y]);
                            $groups[$y] =$iteme[0].':  '.$iteme[1];
                        }
                    
                    //store the summary in the string too
                    $groups[$count_group+1] = 'Number of books: '.$groups[$count_group];
                    $groups[$count_group+2] = 'Total Price: $'.($groups[$count_group]*29.99);
                    $groups[$count_group] = '';
                    
                    $orders[$index] = $groups;
                    $index = $index+1;
                }
            
            
            }
        if(empty($orders)){//if no order history
            $noorder = '. You have no past orders. ';
        }
    }
    
    extractorderhistory($orders,$noorder);
    

    
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="myaccount.css" />
    <title>Account Summary</title>
</head>

<body>
    <header>
        <h1>My Account Summary</h1>  <!-- title of the page -->
    </header>

    <main>
        <p id = "firstp">
        Dear customer, your account id is: <?php  echo ($_SESSION['email_ad']);
                    echo($noorder); ?>
            <br>
        </p>

        <div id="myaccount"> <?php
            $ct = sizeof($orders);
            for ($x = 0; $x <$ct; $x++) {?>
                <h4><b>Order <?php echo($x+1) ?> :  </b></h4><?php
                    $sep = $orders[$x];
                    $ctt =sizeof($sep)-2;
                    
                    for ($y = 0; $y < $ctt; $y++){
                        echo ($sep[$y]); ?>
                        <br>
                 <?php  } ?>  <i><?php
                     
                     for ($y = 0; $y < 2; $y++){
                         echo ($sep[$ctt+$y]); ?>
                        <br>
                <?php  }
                    
                    ?>
                </i><br>
            <?php   }?>
        </div>



    </main>

</body>

</html>
