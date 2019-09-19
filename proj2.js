/*
  This function opens the form to ask how many items the user want

*/
function openForm() {
    document.getElementById(arguments[0]).style.display = "block";
};

/*
  This function closed the form which asks how many items the user want

*/
function closeForm() {
    document.getElementById(arguments[0]).style.display = "none";
};


/*
  This function sends information to php

  @params string arguments[0] is the name of the book selected
  @params string arguments[1] is the name section from which we know the number of book wanted
  @params string arguments[2] is the index of the book selected
*/
function addcart() {

    let bnumber = document.getElementById(arguments[1]).value;
    let bindex = arguments[2];
    let bname = arguments[0];
    msg = "You successfully add "+ bnumber +" of "+ arguments[0] +" to your cart." ;


    alert(msg);
    let fromjs = bnumber+","+ bindex+","+bname;
    window.location.href = "index2.php?fromjs="+ fromjs;



};



