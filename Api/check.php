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

	//course query
	$result = $course->getCourses();
	//get row count
	$num = $result->rowCount();


	//if any courses
	if ($num > 0) {
		//post array
		$course_arr = array();
		$course_arr['data'] = array();

		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			extract($row);

			$course_item = array(
				'id' => $id,
				'course_duration' => $course_duration,
				'current_learning_process' => $current_learning_process,
				'created_at' => $created_at,
				'due_date' => $due_date
			);

			array_push($course_arr['data'], $course_item);
		}

		echo json_encode($course_arr);

	} else {
		echo 'No courses active!!!!!!!!!!';
	}