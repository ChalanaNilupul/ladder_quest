<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ./signInSignUp.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ladder Quest</title>
    <link rel="stylesheet" href="../css/game.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="../js/gameObjMovement.js"></script>
    <script src="../js/menu.js"></script>
    <script>

        let score = 0;
        let imgApi;
        let solution;
        let timeLeft = 15;
        let timerInterval;

    </script>
</head>

<body>

    <div class="tabs">

        <div class="goBack tab" id="goBack">
            <img id="board" src="../assets/svg/htpBoard.svg" alt="">
            <div class="goBackIn tabIn">
                <div class="div">
                    <h2>Are you sure?</h2>
                </div>
                <div class="div">
                    <img id="no" onclick="closeTab()" src="../assets/png/close.png" alt="">
                    <img onclick="leaveGame()" id="ok" src="../assets/png/ok.png" alt="">
                </div>
            </div>
        </div>

        <div class="waiting tab" id="waiting">
            <img id="board" src="../assets/svg/htpBoard.svg" alt="">
            <div class="goBackIn tabIn">
                <div class="div">
                    <h2>Waiting for player 2</h2>
                </div>
                <div class="div">
                    <img class="monkeyloading" src="../assets/monkey.png" alt="">
                </div>
            </div>
        </div>

        <div class="left tab" id="left">
            <img id="board" src="../assets/svg/htpBoard.svg" alt="">
            <div class="goBackIn tabIn">
                <div class="div">
                    <h2>Waiting for player 2</h2>
                </div>
                <div class="div">
                    <img class="monkeyloading" src="../assets/monkey.png" alt="">
                </div>
            </div>
        </div>
        <div class="gameOver tab " id="gameOver">
            <img id="board" src="../assets/svg/htpBoard.svg" alt="">
            <div class="goBackIn tabIn">
                <div class="div result">
                    <h1 style="color:rgb(0, 179, 0)">You won!</h1>
                </div>
                <div class="div">
                    <h3>Score : <span id="gameScore"></span></h3>
                </div>

                <div class="div">
                    <img onclick="directHomeOver()" class="monkeyloading" src="../assets/png/prew.png" alt="">
                </div>
            </div>
        </div>


    </div>

    <img id="jungle" src="../assets/SVG/jungle.svg" alt="">

    <div class="content">
        <div class="left">
            <img id="gameBoard" src="../assets/svg/gameBoard.svg" alt="">
            <img id="game" src="../assets/png/game.png" alt="">
            <div class="playBoard">
                <div id="player1"><img src="../assets/monkey.png" alt=""></div>
                <div id="player2"><img src="../assets/monkey2.png" alt=""></div>
            </div>
        </div>
        <div class="right">
            <div class="rightIn">
                <div class="playersout">
                    <div class="players">
                        <div id="you">
                            <div class="pIn">
                                <img class="table" src="../assets/png/table.png" alt=""><img id="p1" src="" alt="">
                                <h2>You</h2>
                            </div>
                        </div>
                        <div id="oppent">
                            <div class="pIn">
                                <img class="table" src="../assets/png/table.png" alt=""><img id="p2" src="" alt="">
                                <h2 id="oppentUsername"></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="questionout">
                    <div class="question">
                        <img id="quizImg" src="" alt="">
                    </div>
                </div>
                <div class="answersOut">
                    <div class="answers">
                        <button class='ansBtn' value="0"><img src="../assets/png/0.png" alt=""></button>
                        <button class='ansBtn' value="1"><img id="one" src="../assets/png/1.png" alt=""></button>
                        <button class='ansBtn' value="2"><img src="../assets/png/2.png" alt=""></button>
                        <button class='ansBtn' value="3"><img src="../assets/png/3.png" alt=""></button>
                        <button class='ansBtn' value="4"><img src="../assets/png/4.png" alt=""></button>
                        <button class='ansBtn' value="5"><img src="../assets/png/5.png" alt=""></button>
                        <button class='ansBtn' value="6"><img src="../assets/png/6.png" alt=""></button>
                        <button class='ansBtn' value="7"><img src="../assets/png/7.png" alt=""></button>
                        <button class='ansBtn' value="8"><img src="../assets/png/8.png" alt=""></button>
                        <button class='ansBtn' value="9"><img src="../assets/png/9.png" alt=""></button>
                    </div>
                </div>
                <div class="menuItemsOut">
                    <div class="menuItems">
                        <div class="time" style="display:none">
                            <img class="clock" src="../assets/png/clock.png" alt="">
                            <p><span id="timer"></span> Sec</p>
                        </div>


                        <button onclick="openTab('goBack')">Back</button>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>

        let player1, player2;
        const myId = <?php echo $_SESSION['user_id']; ?>;
        let gameId = localStorage.getItem("gameId");



        function directHomeOver() {
            localStorage.setItem("tempScore", 0);
            window.location.href = 'menu.php';
        }

        function leaveGame() {
            localStorage.setItem("tempScore", 0);
            window.location.href = 'menu.php';
        }


        function fetchPlayerNames(player1Id, player2Id) {
            $.ajax({
                url: "../server/get_player_name.php",
                method: "GET",
                data: { player1_id: player1Id, player2_id: player2Id },
                success: function (response) {
                    let data = JSON.parse(response);

                    if (myId == localStorage.getItem("player1")) {
                        $("#oppentUsername").text(data[player2Id]);
                    }
                    else {
                        $("#oppentUsername").text(data[player1Id]);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching player names:", xhr.responseText);
                }
            });
        }


        $(document).ready(function () {

            //assigning player character----------------------------------------------------------

            // console.log(myId == player1)
            // console.log(localStorage.getItem("player1"))
            // console.log(myId)
            if (myId == localStorage.getItem("player1")) {
                $('#p1').attr('src', '../assets/monkey.png')
                $('#p2').attr('src', '../assets/monkey2.png')
                $('#p2').css('width', '30px')
            }
            else {
                $('#p1').attr('src', '../assets/monkey2.png')
                $('#p2').attr('src', '../assets/monkey.png')
                $('#p1').css('width', '30px')
            }



            //checking player 2 joined----------------------------------------------------------------------------

            let checkGameInterval = setInterval(function () {
                $.ajax({
                    url: "../server/check_players_joined.php",
                    method: "POST",
                    data: { gameId: localStorage.getItem("gameId") },
                    dataType: "json",
                    success: function (response) {
                        if (response.started) {

                            startGame();
                            clearInterval(checkGameInterval);


                            closeTab();


                            console.log("Game started!");
                        } else {

                            openTab('waiting')
                            console.log("Waiting for Player 2...");
                        }
                    }
                });
            }, 1000);


            //start game----------------------------------------------------------------------------

            function startGame() {
                $.ajax({
                    url: "../server/start_multiplay.php",
                    method: "POST",
                    data: { gameId: localStorage.getItem("gameId") },
                    dataType: "json",
                    success: function (response) {
                        if (response.started) {
                            clearInterval(checkGameInterval); 

                            console.log("Game started!");
                            player1 = response.player1_id;
                            player2 = response.player2_id;
                            localStorage.setItem("player1", response.player1_id);
                            localStorage.setItem("player2", response.player2_id);


                            //fetch oppent username------------------------------------
                            fetchPlayerNames(localStorage.getItem("player1"), localStorage.getItem("player2"));

                            //startTime();
                            //updateCountdown(gameId);

                            if (myId == response.player1_id) {
                                $('#you').css('color', 'rgb(0, 255, 64)');
                            }
                            else {
                                $('#enemy').css('color', 'rgb(0, 255, 64)');
                            }


                        } else {
                            console.log("Waiting for Player 2...");
                        }
                    },
                    error: function (error) {
                        console.error("Error checking game status:", error);
                    }
                });
            }


            //switchPlayers----------------------------------------------------------------------------

            function switchTurns() {
                $.ajax({
                    url: "../server/check_turn.php",
                    method: "POST",
                    data: { gameId: localStorage.getItem("gameId") },
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {
                            let currentTurn = response.current_turn;
                            let playerId = localStorage.getItem("playerId");

                            // console.log('player id' + playerId)

                            if (currentTurn == player1) {
                                updateTurn(player2);

                            } else {
                                updateTurn(player1);
                            }

                        } else {
                            console.error("Error:", response.error);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                        console.error("Response Text:", xhr.responseText);
                    }

                });
            }

            // Function to switch turn after a move
            function updateTurn(player) {

                $.ajax({
                    url: "../server/update_turn.php",
                    method: "POST",
                    data: { gameId: gameId, player: player },
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {
                            // console.log("Turn switched successfully!");
                        } else {
                            console.error("Error:", response.error);
                        }
                    },
                    error: function (error) {
                        console.error("Error updating turn:", error);
                    }
                });
            }


            //check turn every .5s and update ui

            function checkTurn() {
                $.ajax({
                    url: "../server/check_turn.php",
                    method: "POST",
                    data: { gameId: localStorage.getItem("gameId") },
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {
                            let currentTurn = response.current_turn;
                            let playerId = localStorage.getItem("playerId");

                            //console.log("Player ID:", playerId);

                            if (currentTurn == playerId) {
                                //console.log("Your turn! Enabling inputs...");
                                $(".ansBtn").prop("disabled", false);
                                $(".ansBtn").removeClass("disable");

                                //$(document).on("keydown", handleKeyPress);


                                $('#you').css('color', 'rgb(0, 255, 64)');
                                $('#oppent').css('color', 'white');
                            } else {
                                //console.log("Waiting for opponent's turn...");
                                $(".ansBtn").prop("disabled", true);
                                $(".ansBtn").addClass("disable");

                                // $(document).off("keydown", handleKeyPress);


                                $('#oppent').css('color', 'rgb(0, 255, 64)');
                                $('#you').css('color', 'white');
                            }

                        } else {
                            console.error("Error:", response.error);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                        console.error("Response Text:", xhr.responseText);
                    }
                });
            }


            setInterval(checkTurn, 500);


            //check player positions-------------------------------------------------------------------
            function fetchPlayerPositions() {
                if (isMoving) return; 

                let gameId = localStorage.getItem("gameId");
                let totalCells = 100;

                $.ajax({
                    url: "../server/get_positions.php",
                    method: "GET",
                    data: { gameId: gameId },
                    success: function (response) {
                        let data = JSON.parse(response);

                        if (data.player1_pos !== undefined && data.player2_pos !== undefined) {
                            if (!isMoving && player1Position !== data.player1_pos) {
                                player1Position = data.player1_pos;
                                updatePlayerPosition(localStorage.getItem("player1"));

                                //game over------------------------------------------------
                                if (player1Position == totalCells) {
                                    if (myId == localStorage.getItem("player1")) {
                                        openTab('gameOver')
                                        $('#gameScore').text(localStorage.getItem("tempScore"))
                                        $('.result').html("<h1 style='color:rgb(0, 179, 0)'>You won!</h1>")
                                    }
                                    else {
                                        openTab('gameOver')
                                        $('#gameScore').text(localStorage.getItem("tempScore"))
                                        $('.result').html("<h1 style='color:red'>You lost!</h1>")
                                    }
                                }
                            }

                            if (!isMoving && player2Position !== data.player2_pos) {
                                player2Position = data.player2_pos;
                                updatePlayerPosition(localStorage.getItem("player2"));

                                //game over--------------------------------------------------
                                if (player2Position == totalCells) {
                                    if (myId == localStorage.getItem("player2")) {
                                        console.log(player2Position)
                                        openTab('gameOver')
                                        $('#gameScore').text(localStorage.getItem("tempScore"))
                                        $('.result').html("<h1 style='color:rgb(0, 179, 0)'>You won!</h1>")
                                    }
                                    else {
                                        openTab('gameOver')
                                        $('#gameScore').text(localStorage.getItem("tempScore"))
                                        $('.result').html("<h1 style='color:red'>You lost!</h1>")
                                    }
                                }
                            }
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Error fetching player positions:", xhr.responseText);
                    }
                });
            }

            // Call this function every 500ms to keep positions updated
            setInterval(fetchPlayerPositions, 500);









            function updateUI() {
                // document.getElementById("question-number").textContent = numQuestions;
                //document.getElementById("score").textContent = score;
                document.getElementById("timer").textContent = timeLeft;
                // document.getElementById("level").textContent = currentLevel;
            }

            // getting keyboard inputs-----------------------------------------------------------

            function handleKeyPress(event) {
                let key = event.key; // Get the pressed key

                // Check if key is between "0" and "9"
                if (key >= "0" && key <= "9") {
                    $(".ansBtn").each(function () {
                        if ($(this).text() === key) {
                            $(this).click(); // Simulate button click
                        }
                    });
                }
            }


            // Score update-----------------------------------------------------------

            let tempScore = 0;

            function highScore(score) {
                var dataSet = {
                    score: score,
                    userId: "<?php echo $_SESSION['user_id']; ?>"
                };

                tempScore += score;
                localStorage.setItem("tempScore", tempScore);

                //console.log( localStorage.getItem("tempScore"))

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

            // function updateCountdown() {
            //     clearInterval(timerInterval);

            //     timerInterval = setInterval(() => {
            //         $.ajax({
            //             url: `../server/get_timer.php?game_id=${localStorage.getItem("gameCountId")}`,
            //             type: "GET",
            //             dataType: 'json',
            //             success: function (response) {
            //                 if (response && response.time_left !== undefined) {
            //                     timeLeft = response['time_left'];
            //                     $("#timer").text(timeLeft);

            //                     if (timeLeft <= 10) {
            //                         $('.clock').addClass('active');
            //                         document.getElementById("clock").play();
            //                     }

            //                     if (timeLeft <= 1) {
            //                         // No need to manually reset here; the server handles it
            //                         $('.clock').removeClass('active');
            //                         document.getElementById("wrong").play();
            //                         document.getElementById("clock").pause();

            //                         switchTurns();
            //                         // updateCountdown(); // Not needed; the interval continues
            //                     }
            //                 } else {
            //                     console.error('Invalid response structure.');
            //                 }
            //             },
            //             error: function (xhr, status, error) {
            //                 console.error('Error fetching countdown data:', error);
            //                 if (xhr.responseText) {
            //                     console.log('Server response:', xhr.responseText);
            //                 } else {
            //                     console.log('No server response received.');
            //                 }
            //             }
            //         });
            //     }, 1000);
            // }





            // async function startTime() {

            //     const response = await fetch("../server/start_time.php", {
            //         method: "POST",
            //         headers: { "Content-Type": "application/json" }
            //     });

            //     const data = await response.json();

            //     if (data.success) {
            //         localStorage.setItem("gameCountId", data.game_id); // Save game ID
            //         localStorage.setItem("startTime", data.start_time); // Save start time


            //         //console.log('time created')
            //         //console.log(localStorage.getItem("gameCountId"))

            //     } else {
            //         console.error("Failed to start game:", data.error);
            //     }
            // }



            //Time Countdown-----------------------------------------------------------------

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
                        $('.clock').removeClass('active');
                        document.getElementById("wrong").play();
                        document.getElementById("clock").pause();

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
                    ans.css('background-color', '#AA6028')
                }, 500);
            }
            //setting red to wrong answer
            function wrongAns(ans) {
                ans.css('background-color', 'rgb(255, 43, 43)')
                setTimeout(() => {
                    ans.css('background-color', '#AA6028')
                }, 500);
            }

            $(".ansBtn").click(function (e) {
                var userAns = $(this).val();
                if (userAns == solution) {

                    answer = true;

                    correctAns($(this))
                    document.getElementById("correct").play();


                    //choosing the player--------------------------------------------
                    let playerTurn = myId;

                    movePlayer(userAns, answer, playerTurn)

                    score = 10;
                    highScore(score)

                    fetchImage();
                    updateUI();

                    timeLeft = 15;
                    //countDown();

                    switchTurns();

                    $('.clock').removeClass('active');
                    document.getElementById("clock").pause();
                }
                else {
                    answer = false;

                    //choosing the player--------------------------------------------
                    let playerTurn = myId;

                    movePlayer(userAns, answer, playerTurn)

                    fetchImage();
                    updateUI();

                    switchTurns();

                    timeLeft = 15;
                    //countDown();
                    $('.clock').removeClass('active');
                    document.getElementById("clock").pause();


                    wrongAns($(this))
                    var audioElement = document.getElementById("wrong");
                    audioElement.currentTime = 0;
                    audioElement.play();
                }
            })



            var music = document.getElementById("Music"); // Get the audio element

            // Retrieve music state from localStorage
            var isMusicPlaying = localStorage.getItem("isMusicPlaying") === "true";

            if (isMusicPlaying) {
                music.muted = false;
                music.play(); // Start playing if music was ON
            } else {
                music.muted = true;
                music.pause(); // Stop playing if music was OFF
            }


            fetchImage();
            updateUI();


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