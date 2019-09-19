/*
  This function transfer user information and submitted message to php

*/
function submitfeedback() {

    let currentdate = new Date();
    let datetime = "Time: " + currentdate.getDate() + "/"
                    + (currentdate.getMonth()+1)  + "/"
                    + currentdate.getFullYear() + " @ "
                    + currentdate.getHours() + ":"
                    + currentdate.getMinutes() + ":"
                    + currentdate.getSeconds();



     let radio = $("input[name='Chooseq']:checked").val();
     let msg = $("#essay").val();

     let notice = 'Thank you for your response! We will try to reach you by email in 7 business days!';
     alert(notice);

     let msgfromjs = datetime+"; "+radio+";"+msg;
     window.location.href = "contact.php?msgfromjs="+ msgfromjs;


};


