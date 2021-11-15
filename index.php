<?php
	// check if input has been received else return 0
	if(isset($_GET["players"])) {

		$players = $_GET["players"];

		// if number of players is less than 0 return -1 else return result
		if($players <= 0) {

			$flag = -1;
		}
		else {

			$flag = 1;
			$deck = shuffleCard();
			$result = dealCards($players, $deck);			
		}
	}
	else {

		$flag = 0;
	}

	// create deck of cards and shuffle 
	function shuffleCard() {

		$deck = array();

		for($i=1; $i<=52; $i++) {

			array_push($deck, $i);
		}

		shuffle($deck);

		return $deck;
	}

	// deal shuffled deck to number of players
	function dealCards(int $players, array $deck) {

		$pointer = 0;
		$result = array();

		//create array dimension
		for($i=0; $i<$players; $i++) {

			$result[$i] = array();
		}

		//loop through deck and deal according to players
		while($pointer < 52) {

			for($i=0; $i<$players; $i++) {

				//stop dealing cards when all cards has been dealt
				if($pointer >= 52) {
					break;
				}

				array_push($result[$i], convertCard($deck[$pointer]) . ",");

				$pointer++;
			}
		}

		return $result;
	}

	// convert number to assigned card
	function convertCard(int $number) {

		$suits = array("S", "H", "D", "C");
		$cards = array("A", "2", "3", "4", "5", "6", "7", "8", "9", "X", "J", "Q", "K");

		//determine suits based on range of 13 cards
		$s = $suits[ceil($number/13)-1];

		//determine card based on range using remainder
		if(ceil($number%13)-1 == -1) {

			$c = $cards[12];
		}
		else {

			$c = $cards[ceil($number%13)-1];
		}

		$card = strval($s) . '-' . strval($c);

		return $card;
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Playing Cards</title>
	</head>
	<body style="margin-top:30px; font-size: 18px;">
		<form action="<?= $_SERVER['PHP_SELF'] ?>" method="GET">
			<div style="text-align: center;">
				<div>
					<label>Please Enter # Player(s):</label>
					<input type="number" name="players" id="players" value="<?= $_GET["players"] ?>" style="border-radius: 10px;">
					<input type="submit" value="Enter" style="border-radius: 10px; padding-top: 5px; padding-bottom: 5px; padding-left: 10px; padding-right: 10px;">
				</div>
				<div style="margin-top: 20px; line-height: 25px;">
					<?php 
						if($flag == -1) { // input error

							echo "Result: Input value does not exist or value is invalid";

						} else if($flag == 0) { // no input

							echo "";

						} else { // input accepted

							$count = 1;

							foreach ($result as $users) { // loop through each users

								echo "Player " . $count . ": ";

								foreach($users as $cards) { // loop through each card
									echo $cards;
								}

								$count ++;
								echo "<br>";
							}
						}
					?>					
				</div>
			</div>
		</form>
	</body>
</html>

<!-- Time taken: 1hr -->