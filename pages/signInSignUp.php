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
            <p id="error"></p>
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

                    <input type="email" placeholder="E-MAIL" required id="lmail">
                    <input type="password" placeholder="PASSWORD" required id="lpassword">
                    <button class="btn" id="signBtn">SIGN IN</button>
                    <p>New to game? <a href="#" onclick="toggleForm();goUpSign()">REGISTER</a></p>
                    <p>OR</p>
                    <button class="google-btn" id="googleSignInBtn"><img src="../assets/icons/google.svg" alt="">
                        Continue with
                        Google</button>
                </div>

                <div class="form-box hidden" id="signUpForm">

                    <input type="text" placeholder="USERNAME" required id="rusername">
                    <input type="email" placeholder="E-MAIL" required id="rmail">
                    <input type="password" placeholder="PASSWORD" required id="rpassword">
                    <input type="password" placeholder="CONFIRM PASSWORD" required id="conpassword">
                    <button class="btn" id="regBtn">REGISTER</button>
                    <p>Already have an account? <a href="#" onclick="toggleForm();goUpReg()">SIGN IN</a></p>
                </div>
            </div>
        </div>

    </div>



    <script>


        function monkeyIn() {

            $('.mIn').css('left', '10%')

            setTimeout(() => {
                $('.mIn img').css('transform', 'rotateZ(0deg)')
                $('.mIn').css('animation-play-state', 'running')
            }, 500);

            setTimeout(() => {
                $('#error').css('opacity', '1')
            }, 1100);
        }

        function monkeyOut() {
            $('.mIn img').css('transform', 'rotateZ(-30deg)')
            $('.mIn').css('left', '130%')
            $('#error').css('opacity', '0')

            setTimeout(() => {
                $('.mIn').css('display', 'none')
                $('.mIn').css('left', '-15%')

                setTimeout(() => {
                    $('.mIn').css('display', 'flex')
                }, 100);
            }, 600);
        }


        function isValidEmail(email) {
            let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        // player Login
        $("#signBtn").click(function () {
            let email = $("#lmail").val().trim();
            let password = $("#lpassword").val().trim();

            $("#error").text()

            if (!email || !password) {
                monkeyIn()
                $("#error").text("Please enter email and password.").css("color", "red");
                return;
            }

            if (!isValidEmail(email)) {
                monkeyIn()
                $("#error").text("Invalid email format!").css("color", "red");
                return;
            }

            $.ajax({
                url: "../server/login.php",
                type: "POST",
                data: { email: email, password: password },
                dataType: "json",  // Ensure this is set to JSON
                success: function (response) {
                    console.log("Response object:", response);
                    if (response.success) {
                        monkeyOut();
                        localStorage.setItem("playerId", response.player_id);
                        window.location.href = "./menu.php"; // Redirect
                    } else {
                        monkeyIn();
                        $("#error").text(response.message).css("color", "red");
                    }
                },
                error: function () {
                    monkeyIn();
                    $("#error").text("Error logging in. Please try again.").css("color", "red");
                }
            });

        });

        // player Registration
        $("#regBtn").click(function () {

            console.log('click')

            let name = $("#rusername").val().trim();
            let email = $("#rmail").val().trim();
            let password = $("#rpassword").val().trim();
            let confirmPassword = $("#conpassword").val().trim();

            $("#error").text()

            if (!name || !email || !password || !confirmPassword) {
                monkeyIn()
                $("#error").text("All fields are required!").css("color", "red");
                return;
            }

            if (!isValidEmail(email)) {
                monkeyIn()
                $("#error").text("Invalid email format!").css("color", "red");
                return;
            }

            
            if (password.length < 8) {
                monkeyIn()
                $("#error").text("Password Must Be 8 Or More Characters Long").css("color", "red");
                return;
            }

            if (password !== confirmPassword) {
                monkeyIn()
                $("#error").text("Passwords do not match!").css("color", "red");
                return;
            }


            $.ajax({
                url: "../server/register.php",
                type: "POST",
                data: { name: name, email: email, password: password },
                success: function (response) {
                    if (response.trim() === "success") {
                        monkeyOut();
                        toggleForm();
                        goUpReg();
                        $('#rusername, #rmail, #rpassword, #conpassword').val('');

                    } else {
                        monkeyIn()
                        $("#error").text(response).css("color", "red");
                    }
                },
                error: function () {
                    monkeyIn()
                    $("#error").text("Error registering. Please try again.").css("color", "red");
                }
            });
        });



        $(document).ready(function () {

            setTimeout(() => {
                $('.forms').css('display', 'flex')
            }, 1000);

        });


    </script>



    <!-- //google sign in---------------------------------------------------------------------------------------->

    <script type="module">
        import { auth } from "../js/firebase_config.js"; // Import auth

        import { GoogleAuthProvider, signInWithPopup } from "https://www.gstatic.com/firebasejs/11.4.0/firebase-auth.js";

        document.getElementById("googleSignInBtn").addEventListener("click", async function () {
            const provider = new GoogleAuthProvider();
            try {
                const result = await signInWithPopup(auth, provider);
                const user = result.user;

                const response = await fetch("../server/google_auth.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: new URLSearchParams({
                        google_id: user.uid,
                        name: user.displayName,
                        email: user.email
                    })
                });

                // Parse the JSON response
                const responseData = await response.json();

                // Check the success of the response
                if (responseData.success) {
                    localStorage.setItem("playerId", responseData.player_id);
                    window.location.href = "./menu.php";
                } else {
                    document.getElementById("error").innerText = "Login failed: " + responseData.message;
                }
            } catch (error) {
                console.error("Google Sign-In Error:", error);
            }
        });

    </script>



</body>

</html>