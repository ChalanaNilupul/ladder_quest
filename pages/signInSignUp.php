<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/signInsignUp.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="../js/loginReg.js"></script>
    <title>Register</title>
</head>

<body>

    <div class="cloud">

        <img src="../assets/cloud1.png" alt="">
        <img src="../assets/cloud2.png" alt="">
        <img src="../assets/cloud1.png" alt="">

    </div>

    <div class="monkey">
        <div class="mIn">
            <img src="../assets/monkey.png" alt="">
            <p id="error">Cant be empty</p>
        </div>
    </div>

    <div class="formOut">

        <div class="container">

            <img id="board" src="../assets/1x/board.png" alt="">
            <img id="sign" src="../assets/texts/sign.png" alt="">
            <img id="reg" src="../assets/texts/reg.png" alt="">
            <img id="leaf" src="../assets/leaf.png" alt="">
            <div class="forms">

                <div class="form-box signBox" id="signInForm">

                    <input type="email" placeholder="E-MAIL" required>
                    <input type="password" placeholder="PASSWORD" required>
                    <button class="btn" id="signBtn">SIGN IN</button>
                    <p>New to game? <a href="#" onclick="toggleForm();goUpSign()">REGISTER</a></p>
                    <p>OR</p>
                    <button class="google-btn"><img src="../assets/icons/google.svg" alt="" onclick="monkeyIn()"> Continue with
                        Google</button>
                </div>

                <div class="form-box hidden" id="signUpForm">

                    <input type="text" placeholder="USERNAME" required>
                    <input type="email" placeholder="E-MAIL" required>
                    <input type="password" placeholder="PASSWORD" required>
                    <input type="password" placeholder="CONFIRM PASSWORD" required>
                    <button class="btn" id="regBtn">REGISTER</button>
                    <p>Already have an account? <a href="#" onclick="toggleForm();goUpReg()">SIGN IN</a></p>
                </div>
            </div>
        </div>

    </div>

    <script>


        function monkeyIn() {
           
            $('.mIn').css('left','10%')

            setTimeout(() => {
                $('.mIn img').css('transform','rotateZ(0deg)')
                $('.mIn').css('animation-play-state','running')
            }, 500);

            setTimeout(() => {
                $('#error').css('opacity','1')
            }, 1100);
        }

        function monkeyOut(){
            $('.mIn img').css('transform','rotateZ(-30deg)')
            $('.mIn').css('left','130%')
            $('#error').css('opacity','0')

            setTimeout(() => {
                $('.mIn').css('display','none')
                $('.mIn').css('left','-15%')

                setTimeout(() => {
                    $('.mIn').css('display','flex')
                }, 100);
            }, 600);
        } 



        $('#signBtn').click(function () {
           
        })

        $(document).ready(function () {

            setTimeout(() => {
                $('.forms').css('display', 'flex')
            }, 1000);


        });


    </script>
</body>

</html>