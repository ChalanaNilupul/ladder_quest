function toggleForm() {
    document.getElementById("signInForm").classList.toggle("hidden");
    document.getElementById("signUpForm").classList.toggle("hidden");
}

function goUpSign(){
    $('#sign').css('top','-50%')
    $('#reg').css('top',' 30px')
}

function goUpReg(){
    $('#sign').css('top',' 30px')
    $('#reg').css('top','-50%')
}