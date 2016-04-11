//put an event listener on the button at the bottom of the form (the only button on the form)
$('button').on('click', function () {
    
    //remove any errors that already exist on the page by first selecting all the spans on the page that are children of an element with the classes col-md-5 and error
    $('.has-error span').each(function (index) {
        
        //first remove the error class from the parent element
        $(this).parent().removeClass('has-error');
        
        //then delete the error element itself
        $(this).remove();
    });
    
    //store any form inputs that are required to submit in an object
    var reqInputs = {
        name_f: $('#name_f'),
        name_l: $('#name_l'),
        password: $('#password'),
        passwordVer: $('#passwordVer'),
        email: $('#email'),
        zipCode: $('#zipCode')
    }
    
    //set up validation with another object that holds an array that will contain any empty required fields, bools for more specific validation, and error text for validation failure
    var errors = {
        emptyFields: [],
        name_fLength: false,
        name_lLength: false,
        passwordMatch: false,
        passwordLength: false,
        passwordUpper: false,
        passwordLower: false,
        email: false,
        website: false,
        zipLength: false,
        zipNumbers: false,
        agreeCheck: false,
        txt : {
            emptyFields: 'This Field is Required',
            name_fLength: 'Must Contain at Least 2 Characters',
            name_lLength: 'Must Contain at Least 2 Characters',
            passwordMatch: 'The Passwords Do Not Match',
            passwordLength: 'Must Contain at Least 5 Characters',
            passwordUpper: 'Must Contain 1 Upper Case Letter',
            passwordLower: 'Must Contain 1 Lower Case Letter',
            email: 'The Email Address is Not Valid',
            website: 'The URL is Not Valid',
            zipLength: 'Zip Code Must be 5 Numbers',
            zipNumbers: 'Zip Code Must be Numbers Only',
            agreeCheck: 'You Must Agree to the Terms Even Though No Terms Actually Exist'
        }
    }
    
    //First we take care of the required fields
    //loop through the required fields
    for (var key in reqInputs) {
        
        //if there is nothing in the required field (after trimming any white space)
        if (reqInputs[key].val().trim() === '') {
            
            //push this key into the empty fields array in the errors object
            errors.emptyFields.push(key);
        }
    }
    
    //Next we can start looking at specific validation issues
    //check to make sure that the first name field contains at least two characters (Note: do not check for this if the required field error is already in place)
    if (errors.emptyFields.indexOf('name_f') === -1 &&
        reqInputs.name_f.val().trim().length < 2) {
            
        //if the first name is too short, set the first name error to true
        errors.name_fLength = true;
    }
    
    //check to make sure that the last name field contains at least two characters (Note: dont check for this if the required field error is already in place)
    if (errors.emptyFields.indexOf('name_l') === -1 &&
        reqInputs.name_l.val().trim().length < 2) {
            
        //if the last name is too short, set the last name error to true
        errors.name_lLength = true;
    }
    
    //check to make sure that the password and passwordVer inputs match (Note: making sure we do not check for this if the reqired error is already activated)
    if (errors.emptyFields.indexOf('password') === -1 &&
        errors.emptyFields.indexOf('passwordVer') === -1 &&
        reqInputs.password.val().trim() !== reqInputs.passwordVer.val().trim()) {
            
        //if both inputs are not empty, but they also do not match, set the password match error to true
        errors.passwordMatch = true;    
    }
    
    //if the password has been entered (the required field error is not active) we can check for the other password validation issues
    if (errors.emptyFields.indexOf('password') === -1) {
        
        //check to make sure that the password is at least 5 characters long
        if (reqInputs.password.val().trim().length < 5) {
            
            //if not set the password length error to true
            errors.passwordLength = true;
        }
        
        //set up the variables for testing each character in the password
        var character, upperPresent = false, lowerPresent = false;
        
        //check to make sure that the password has at least one upper case and one lower case letter
        for (var i = 0; i < reqInputs.password.val().length; i++) {
            
            //set the varaible equal to the character we are checking
            character = reqInputs.password.val().charAt(i);
            
            //if the character (made upper case) is equal to the character in the password
            if (character.toUpperCase() === reqInputs.password.val().charAt(i)) {
                
                //set the upper present bool to true
                upperPresent = true;
                
            //otherwise, if the character (made lower case) is equal to the character in the password
            } else if (character.toLowerCase() === reqInputs.password.val().charAt(i)) {
                
                //set the lower present bool to true
                lowerPresent = true;
            }
        }
        
        //make sure the password contains an upper case letter
        if (upperPresent === false) {
            
            //if it doesn't, set the password upper error to true
            errors.passwordUpper = true;
        }
        
        //make sure the password contains a lower case letter
        if (lowerPresent === false) {
            
            //if it doesn't, set the password lower error to true
            errors.passwordLower = true;
        }
    }
    
    //if an email has been entered, verify that it is in the correct format
    if (errors.emptyFields.indexOf('email') === -1 && !validateEmail(reqInputs.email.val().trim())) {
        
        //set the invalid email error to true
        errors.email = true;
    }
    
    //if website has been entered (optional), verfiy that it is in the correct format
    if ($("#website").val().trim() !== '' && !validateURL($('#website').val().trim())) {
        
        //set the invalid website error to true
        errors.website = true;
    }
    
    //if a zip code has been entered we can cehck the rest of the validation issues for zip code
    if (errors.emptyFields.indexOf('zipCode') === -1) {
        
        //check to make sure the zip code has exactly 5 characters
        if (reqInputs.zipCode.val().trim().length !== 5) {
            
            //set the zipCode length error to true
            errors.zipLength = true;
        }
        
        //check to make sure the zip code has ONLY numbers starting by setting up a bool to tell us if all the characters are numbers
        var allNumbers = true;
        
        //loop through the zip code
        for (var i = 0; i < reqInputs.zipCode.val().length; i++) {
            
            //if the current character is within the range of numbers (0-9)
            if (reqInputs.zipCode.val()[i] >= 0 && reqInputs.zipCode.val()[i] <= 9) {
                
                //do nothing
            
            //otherwise...
            } else {
                
                //set the allNumbers bool to false
                allNumbers = false;
            }
        }
        
        //if the allNumbers bool is now false after the loop
        if (allNumbers === false) {
            
            //set the zip numbers error to true
            errors.zipNumbers = true;
        }
    }
    
    //finally, check to see if the agree to terms checkbox is clicked
    if (!$('#agree').prop('checked')) {
        
        //set the agree check error to true
        errors.agreeCheck = true;
    }
    
    //start handling validation
    //if there are errors
    if (errors.emptyFields.length !== 0 ||
        errors.name_fLength || errors.name_lLength || errors.passwordMatch ||
        errors.passwordLength || errors.passwordUpper || errors.passwordLower ||
        errors.email || errors.website || errors.zipLength || errors.zipNumbers ||
        errors.agreeCheck) {
            
        //start by handling any empty required fields; if the empty fields array is not empty
        if(errors.emptyFields.length !== 0) {
            
            //set up the variables for looping through the array
            var i, len;
            for (len = errors.emptyFields.length, i = 0; i < len; i++) {
                
                //pass in the element that is empty and the appropriate error text to the display validation error function
                displayValError(reqInputs[errors.emptyFields[i]], errors.txt.emptyFields);
            }
        }
            
        //next, handle all the specific validation issues for each input
        //starting with first name
        if(errors.name_fLength === true) {
            
            //pass the first name element and its associated error text into the display validation error function
            displayValError(reqInputs.name_f, errors.txt.name_fLength);
        }
        
        //next handle last name
        if(errors.name_lLength === true) {
            
            //pass the last name element and its associated error text into the display error function
            displayValError(reqInputs.name_l, errors.txt.name_lLength);
        }
        
        //next handle non matching passwords
        if(errors.passwordMatch === true) {
            
            //display the password match error
            displayValError(reqInputs.passwordVer, errors.txt.passwordMatch);
        }
        
        //next cascade through the password validation issues
        if (errors.passwordLength === true) {
            
            //display the password length error
            displayValError(reqInputs.password, errors.txt.passwordLength);
            
        } else {
            
            //if the password has no upper case letters
            if (errors.passwordUpper === true) {
                
                //display the password upper case error
                displayValError(reqInputs.password, errors.txt.passwordUpper);
            }
            
            //if the password has no lower case letters
            if (errors.passwordLower === true) {
                
                //display the password upper case error
                displayValError(reqInputs.password, errors.txt.passwordLower);
            }
        }
        
        //next handle non valid email format
        if (errors.email === true) {
            
            //display the email format error
            displayValError(reqInputs.email, errors.txt.email)
        }
        
        //next comes the url validation for the optional favorite webiste element
        if (errors.website === true) {
            
            //display the webiste format error
            displayValError($('#website'), errors.txt.website);
        }
        
        //next, cascade through the two possible zip code errors
        if (errors.zipLength === true) {
            
            //display the zip code length error
            displayValError(reqInputs.zipCode, errors.txt.zipLength);
            
        } else if (errors.zipNumbers === true) {
            
            //display the zip code numbers error
            displayValError(reqInputs.zipCode, errors.txt.zipNumbers);
        }
        
        //finally, check to make sure the user has clicked the checkbox to agree to our non existant terms
        if (errors.agreeCheck === true) {
            
            //display the agree check error
            displayValError($('#agree'), errors.txt.agreeCheck);
        }
    //otherwise...
    } else {
            
        //submit the form
        $('#regForm').submit();
    }
});

//function that validates the structure of an email address for form validation
function validateEmail(email) {
    var emailRegex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return emailRegex.test(email);
}

//function that adds a validation error message to the element that has not passed validation
function displayValError(element, message) {
    
    //add the error class to the element's parent
    element.parent().addClass('has-error');
    
    //add the error message after the element itself
    element.after('<span>' + message + '</span>');
}

//function that validates the structure of aurl for form validation
function validateURL(url) {
    var urlRegex = /^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/;
    return urlRegex.test(url);
}


