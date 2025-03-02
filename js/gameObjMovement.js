const boardConfig = {
    20: 59,  // Ladder
    2: 23,   // Ladder
    6: 45, // Ladder
    57: 96, // Ladder
    52: 72, // Ladder
    71: 92, // Ladder

    98: 40,  // Snake
    84: 58,  // Snake
    87: 49,  // Snake
    50: 5,   // Snake
    56: 8,   // Snake
    43: 17,  // Snake
    73: 15,  // Snake
};


let playerPosition = 1; // Start at position 1
const totalCells = 100; // Adjust according to your board size

function movePlayer(steps) {
    steps = Number(steps);
    console.log(`Rolled: ${steps}`);

    let targetPosition = playerPosition + steps;

    // Ensure player doesn't go beyond the last cell (100)
    if (targetPosition > totalCells) {
        console.log("You need an exact roll to win!");
        return;
    }

    console.log(`Moving from ${playerPosition} to ${targetPosition}`);

    function animateStep() {
        if (playerPosition === targetPosition) {
            // Check for snakes or ladders after stopping
            if (boardConfig[playerPosition]) {
                let newPos = boardConfig[playerPosition];
                //console.log(`You hit a ${playerPosition < newPos ? "Ladder 🎉" : "Snake 🐍"}! Moving to ${newPos}`);
                playerPosition = newPos;
                updatePlayerPosition(); 
            }
            return;
        }

        playerPosition++; 
        updatePlayerPosition(); 

        setTimeout(animateStep, 300); 
    }

    animateStep(); 
}


function updatePlayerPosition() {
    let row = Math.floor((playerPosition - 1) / 10) + 1; // Calculate row
    let col = (playerPosition - 1) % 10 + 1; // Calculate column

    if (row % 2 == 0 ) {
        //(playerPosition - 1) % 10 + 1;
        col = (10 - ((playerPosition - 1) % 10 + 1)) + 1
        console.log(row)
    }
    else if(row % 2 == 1) {
        
        row = row
        console.log(row)
    }

    $("#player1").css({
        "grid-row": 11 - row,  // Reverse because grid starts from top
        "grid-column": col
    });
}

