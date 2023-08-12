<?php

//submit_rating.php

$connect = new PDO("mysql:host=localhost;dbname=plant", "root", "");
if (isset($_POST["pid"])) {
	$pid = $_POST["pid"];
}

//submit
if (isset($_POST["rating_data"])) {

	if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
		// Google secret API
		$secretAPIkey = '6LfOCW0mAAAAALiI_52jZV8HpuUfaQragoglsPmB';
		// reCAPTCHA response verification
		$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secretAPIkey . '&response=' . $_POST['g-recaptcha-response']);
		// Decode JSON data
		$response = json_decode($verifyResponse);
		if ($response->success) {
			$data = array(
				':user_name'		=>	$_POST["user_name"],
				':user_rating'		=>	$_POST["rating_data"],
				':user_review'		=>	$_POST["user_review"],
				':datetime'			=>	time(),
				':plant_id'		=> $_POST["plant_id"],
				':c_id'				=> $_POST['c_id']
			);

			$query = "
				INSERT INTO review_acc 
				(user_name, user_rating, user_review, datetime, accessory_id, user_id) 
				VALUES (:user_name, :user_rating, :user_review, :datetime, :plant_id, :c_id)
				";

			$statement = $connect->prepare($query);

			$statement->execute($data);
			echo "Submit review success. Please wait approve!";
		} else {
			echo "Robot verification failed, please try again.";
		}
	} else {
		echo "Please check on the reCAPTCHA box.";
	}
	header('Location:acc-detail.php?pid=' . $pid . '');
}

if (isset($_POST["action"])) {
	$average_rating = 0;
	$total_review = 0;
	$five_star_review = 0;
	$four_star_review = 0;
	$three_star_review = 0;
	$two_star_review = 0;
	$one_star_review = 0;
	$total_user_rating = 0;
	$review_content = array();


	$query = "
	SELECT * FROM review_acc where accessory_id = $pid and status = 0
	ORDER BY review_id DESC
	";

	$result = $connect->query($query, PDO::FETCH_ASSOC);

	foreach ($result as $row) {
		$review_content[] = array(
			'user_name'		=>	$row["user_name"],
			'user_review'	=>	$row["user_review"],
			'rating'		=>	$row["user_rating"],
			'datetime'		=>	date('l jS, F Y h:i:s A', $row["datetime"]),
		);

		if ($row["user_rating"] == '5') {
			$five_star_review++;
		}

		if ($row["user_rating"] == '4') {
			$four_star_review++;
		}

		if ($row["user_rating"] == '3') {
			$three_star_review++;
		}

		if ($row["user_rating"] == '2') {
			$two_star_review++;
		}

		if ($row["user_rating"] == '1') {
			$one_star_review++;
		}

		$total_review++;

		$total_user_rating = $total_user_rating + $row["user_rating"];
	}

	$average_rating = $total_user_rating / $total_review;

	$output = array(
		'average_rating'	=>	number_format($average_rating, 1),
		'total_review'		=>	$total_review,
		'five_star_review'	=>	$five_star_review,
		'four_star_review'	=>	$four_star_review,
		'three_star_review'	=>	$three_star_review,
		'two_star_review'	=>	$two_star_review,
		'one_star_review'	=>	$one_star_review,
		'review_data'		=>	$review_content
	);

	echo json_encode($output);
}
