const boardConfig = {
    20: 59, 2: 23, 6: 45, 57: 96, 52: 72, 71: 92, // Ladders
    98: 40, 84: 58, 87: 49, 50: 5, 56: 8, 43: 17, 73: 15 // Snakes
};

let player1Position = 1; // Start position for Player 1
let player2Position = 1; // Start position for Player 2
const totalCells = 100; 

let isMoving = false; // Flag to prevent conflicts

function movePlayer(steps, answer, PlayerTurn) {
    isMoving = true;  // Stop fetching positions
    steps = Number(steps);

    let targetPosition;
    if (answer) {
        targetPosition = PlayerTurn == localStorage.getItem("player1") ? player1Position + steps : player2Position + steps;
    } else {
        // When answer is false, just move back one cell
        targetPosition = PlayerTurn == localStorage.getItem("player1") ? player1Position - 1 : player2Position - 1;
        if (targetPosition < 1) targetPosition = 1; // Ensure doesn't go below 1
    }

    function animateStep() {
        if (PlayerTurn == localStorage.getItem("player1")) {
            if (answer) {
                if (player1Position == targetPosition) {
                    checkSnakesOrLadders(PlayerTurn);
                    isMoving = false;  // Resume fetching after move
                    return;
                }
                player1Position++;
            } else {
                if (player1Position == targetPosition) {
                    isMoving = false;  // Resume fetching after move
                    return;
                }
                player1Position--;
            }
        } else {
            if (answer) {
                if (player2Position == targetPosition) {
                    checkSnakesOrLadders(PlayerTurn);
                    isMoving = false;  // Resume fetching after move
                    return;
                }
                player2Position++;
            } else {
                if (player2Position == targetPosition) {
                    isMoving = false;  // Resume fetching after move
                    return;
                }
                player2Position--;
            }
        }

        updatePlayerPosition(PlayerTurn);
        setTimeout(animateStep, 300);
    }

    animateStep();
}


function checkSnakesOrLadders(PlayerTurn) {
    let playerPosition = PlayerTurn == localStorage.getItem("player1") ? player1Position : player2Position;

    if (boardConfig[playerPosition]) {
        let newPos = boardConfig[playerPosition];

       // console.log(`You hit a ${playerPosition < newPos ? "Ladder 🎉" : "Snake 🐍"}! Moving to ${newPos}`);

        if (PlayerTurn == localStorage.getItem("player1")) {
            player1Position = newPos;
        } else {
            player2Position = newPos;
        }

        updatePlayerPosition(PlayerTurn);

        // **Recursive Call to Check Again** (in case of another ladder)
        checkSnakesOrLadders(PlayerTurn);
    }
}


function updatePlayerPosition(PlayerTurn) {
    let playerPosition = PlayerTurn == localStorage.getItem("player1") ? player1Position : player2Position;
    let row = Math.floor((playerPosition - 1) / 10) + 1;
    let col = (playerPosition - 1) % 10 + 1;

    if (row % 2 === 0) {
        col = (10 - ((playerPosition - 1) % 10 + 1)) + 1;
    }

    let playerElement = PlayerTurn == localStorage.getItem("player1") ? "#player1" : "#player2";

    console.log('player',playerElement)
    console.log('PlayerTurn',PlayerTurn)
    console.log('localStorage.getItem("player1")',localStorage.getItem("player1"))

    $(playerElement).css({
        "grid-row": 11 - row,
        "grid-column": col
    });

    

    // Send updated position to the server
    updatePlayerPositionInDB(PlayerTurn, playerPosition);
}

function updatePlayerPositionInDB(PlayerTurn, newPosition) {
    let gameId = localStorage.getItem("gameId");
    let playerKey = PlayerTurn == localStorage.getItem("player1") ? "player1_pos" : "player2_pos";

    // console.log('key',playerKey)
    // console.log('PlayerTurn',PlayerTurn)
    // console.log('player 1',localStorage.getItem("player1"))
    // console.log(PlayerTurn == localStorage.getItem("player1"))

    $.ajax({
        url: "../server/update_position.php",
        method: "POST",
        data: { gameId: gameId, playerKey: playerKey, position: newPosition },
        success: function (response) {
            console.log("Position updated:", response);
        },
        error: function (xhr, status, error) {
            console.error("Error updating position:", xhr.responseText);
        }
    });
}
