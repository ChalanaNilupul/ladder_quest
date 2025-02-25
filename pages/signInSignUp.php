<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/signInsignUp.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Register</title>
</head>
<body>
    <div class="container">

        <img id="board" src="../assets/1x/board.png" alt="">
        <img id="sign" src="../assets/texts/sign.png" alt="">
        <img id="reg" src="../assets/texts/reg.png" alt="">
        <img id="leaf" src="../assets/leaf.png" alt="">

        <div class="form-box" id="signInForm">
           
            <input type="email" placeholder="E-MAIL" required>
            <input type="password" placeholder="PASSWORD" required>
            <button class="btn">SIGN IN</button>
            <p>New to game? <a href="#" onclick="toggleForm();goUpSign()">REGISTER</a></p>
            <p>OR</p>
            <button class="google-btn">Continue with Google</button>
        </div>

        <div class="form-box hidden" id="signUpForm">
        
            <input type="text" placeholder="USERNAME" required>
            <input type="email" placeholder="E-MAIL" required>
            <input type="password" placeholder="PASSWORD" required>
            <input type="password" placeholder="CONFIRM PASSWORD" required>
            <button class="btn">REGISTER</button>
            <p>Already have an account? <a href="#" onclick="toggleForm();goUpReg()">SIGN IN</a></p>
        </div>
    </div>

    <script>
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

    </script>
</body>
</html>