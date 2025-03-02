<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ladder Quest</title>
    <link rel="stylesheet" href="../css/game.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="../js/gameObjMovement.js"></script>
    <script>

        let score;
        let imgApi;
        let solution;
        let timeLeft = 15;
        let timerInterval;

    </script>
</head>

<body>

    <img id="jungle" src="../assets/SVG/jungle.svg" alt="">

    <div class="content">
        <div class="left">
            <img id="gameBoard" src="../assets/svg/gameBoard.svg" alt="">
            <img id="game" src="../assets/png/game.png" alt="">
            <div class="playBoard">
                <div id="player1"></div>
            </div>
        </div>
        <div class="right">
            <div class="questionout">
                <div class="question">
                    <img id="quizImg" src="" alt="">
                </div>
            </div>
            <div class="answersOut">
                <div class="answers">
                    <button class='ansBtn'>0</button>
                    <button class='ansBtn'>1</button>
                    <button class='ansBtn'>2</button>
                    <button class='ansBtn'>3</button>
                    <button class='ansBtn'>4</button>
                    <button class='ansBtn'>5</button>
                    <button class='ansBtn'>6</button>
                    <button class='ansBtn'>7</button>
                    <button class='ansBtn'>8</button>
                    <button class='ansBtn'>9</button>
                </div>
            </div>
            <div class="menuItemsOut">
                <div class="menuItems">
                    <div class="time">
                        <img class="clock" src="../assets/png/clock.png" alt="">
                        <p><span id="timer">29</span> Sec</p>
                    </div>
                </div>
            </div>

        </div>
    </div>



    <script>
        $(document).ready(function () {
            // let divWidth = $("#gameBoard").width();
            // let divHeight = $("#gameBoard").height();

            // $('.playBoard').css('width',divWidth - 120)
            // $('.playBoard').css('height',divHeight - 190)

            // console.log("Div width:", divWidth);
            // console.log("Div width:", $(".playBoard").width());



            function updateUI() {
                // document.getElementById("question-number").textContent = numQuestions;
                //document.getElementById("score").textContent = score;
                document.getElementById("timer").textContent = timeLeft;
                // document.getElementById("level").textContent = currentLevel;
            }

            // getting keyboard inputs-----------------------------------------------------------

            $(document).on("keydown", function (event) {
                let key = event.key; // Get the pressed key

                // Check if key is between "0" and "9"
                if (key >= "0" && key <= "9") {
                    $(".ansBtn").each(function () {
                        if ($(this).text() === key) {
                            $(this).click(); // Simulate button click
                        }
                    });
                }
            });


            // Score update-----------------------------------------------------------

            function highScore(score) {
                var dataSet = {
                    score: score,
                    userName: "<?php echo ''; ?>"
                };


                //console.log(dataSet)

                $.ajax({

                    type: 'POST',
                    url: '../server/updateScore.php',
                    data: dataSet,
                    success: function (response) {

                        if (response === 'Success') {
                            //console.log(response);
                        }
                        console.log(response);
                    },
                    error: function () {
                        alert('Error occurred. Please try again.');
                    }

                });
            }



            //Time Countdown-----------------------------------------------------------

            function countDown() {
                clearInterval(timerInterval);
                
                timerInterval = setInterval(() => {
                    $("#timer").text(timeLeft);

                    if (timeLeft <= 10) {
                        $('.clock').addClass('active');
                        document.getElementById("clock").play();
                    }

                    timeLeft -= 1;

                    if (timeLeft < 0) {
                        clearInterval(timerInterval);
                        $('.clock').removeClass('active');
                       
                        document.getElementById("wrong").play();
                        document.getElementById("clock").pause();
                        // console.log(livesLeft)
                        fetchImage();
                        timeLeft = 30
                        countDown()
                    }

                }, 1000);
            }



            // fetch image -----------------------------------------------------------

            function fetchImage() {
                fetch('https://marcconrad.com/uob/banana/api.php')
                    .then(response => response.json())
                    .then(data => {
                        imgApi = data.question;
                        solution = data.solution;
                        document.getElementById("quizImg").src = imgApi;

                    })
                    .catch(error => {
                        console.error('Error fetching image from the API:', error);
                    });
            }



            // check answer -----------------------------------------------------------

            //setting green to correct answer
            function correctAns(ans) {
                ans.css('background-color', 'rgb(25, 255, 121)')
                setTimeout(() => {
                    ans.css('background-color', 'aliceblue')
                }, 500);
            }
            //setting red to wrong answer
            function wrongAns(ans) {
                ans.css('background-color', 'rgb(255, 43, 43)')
                setTimeout(() => {
                    ans.css('background-color', 'aliceblue')
                }, 500);
            }

            $(".ansBtn").click(function (e) {
                var userAns = $(this).text();
                if (userAns == solution) {
                    correctAns($(this))
                    document.getElementById("correct").play();

                    movePlayer(userAns);

                    score += 10;
                    highScore(score)
                    fetchImage();
                    updateUI();
                    timeLeft = 30;
                   // countDown();
                    $('.clock').removeClass('active');
                    document.getElementById("clock").pause();
                }
                else {
                    wrongAns($(this))
                    var audioElement = document.getElementById("wrong");
                    audioElement.currentTime = 0;
                    audioElement.play();
                }
            })


            fetchImage();
            updateUI();
            //countDown();

        });

    </script>

    <audio id="correct" src="../assets/music/sounds/correct.mp3" preload="auto"></audio>
    <audio id="wrong" src="../assets/music/sounds/wrong.mp3" preload="auto"></audio>
    <audio id="over" src="../assets/music/sounds/over.mp3" preload="auto"></audio>
    <audio id="clock" src="../assets/music/sounds/clock.mp3" preload="auto"></audio>
    <audio id="Music" autoplay loop>
        <source src="../assets/music/song2.mp3" type="audio/mp3">
    </audio>

</body>

</html>