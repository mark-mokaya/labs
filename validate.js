// create form validation function
// called when form is submitted

function validateForm(){
    var fname = document.forms["user_details"]["first_name"].value;
    var lname = document.forms["user_details"]["last_name"].value;
    var city = document.forms["user_details"]["city_name"].value;

    //user_details => name of form

    if(fname == null || lname == "" || city == "") {
        alert("All details required were not supplied");
        return false;
    }
    return true;
}