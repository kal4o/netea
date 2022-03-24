<?php

	//HEADERS
	header('Access_Control_Allow_Origin: *');
	header('Content-Type: application/json');


	include_once '../config/Database.php';
	include_once '../models/Course.php';

	//instantitate DB object
	$database = new Database();
	$db = $database->connect();

	//Instantiate course class object
	$course = new Course($db);

	//Get id
	$course->id = isset($_GET['id']) ? $_GET['id'] : die();

	//Get course single
	$course->getCourse();


	$course_arr = array(
		'id' => $course->id,
		'course_duration' => $course->course_duration,
		'current_learning_process' => $course->current_learning_process,
		'created_at' => $course->created_at,
		'due_date' => $course->due_date
	);

		// Function to find the difference 
	  // between two dates.
	  

	  //Current date
	  $d1 = new Datetime();
	  $date1 = $d1->format('Y-m-d h:i:sa');
	  
	  // created at date
	  $date2 = $course_arr['created_at'];

	  //echo $date1;

	  //calculate passed days betw created at and current date
	  $diff = strtotime($date1) - strtotime($date2);
	  //echo $diff;
	  $diff_day = abs(round($diff / 86400));
	  $course_dur = $course_arr['course_duration'];
	  $opt_progress_day = abs(round($course_dur / 28800));
	  $opt_progress_curr = $opt_progress_day * $course_arr['current_learning_process'] / 100;
	  $status = $opt_progress_day-$diff_day;
	  $opt_days_left = $opt_progress_day - $opt_progress_curr;
	  
	  // Respond
	  if ($status<0) {
	  	echo "overdue";
	  } else if ($opt_days_left >= $status) {
	  	echo "on track";
	  } else {
	  	echo "not on track";
	  }

	  
		
	//Print json respond
	print_r(json_encode($course_arr));