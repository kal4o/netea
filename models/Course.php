<?php
	
	class Course {
		//DB conn
		private $conn;
		private $table = 'courses';

		//Course properties
		public $id;
		public $course_duration;
		public $current_learning_process;
		public $created_at;
		public $due_date;


		public function __construct($db) {
			$this->conn = $db;
		}

		//Get courses
		public function getCourses() {
			//query
			$query = 'SELECT 
				id,
				course_duration,
				current_learning_process,
				created_at,
				due_date
			   FROM
			    courses';

			//Prepare stmt
			$stmt = $this->conn->prepare($query);

			//stmt execute
			$stmt->execute();

			return $stmt;
		}

		//Get single Course
		public function getCourse() {
			//query
			$query = 'SELECT 
				id,
				course_duration,
				current_learning_process,
				created_at,
				due_date
			   FROM
			    courses
			   WHERE 
			   	id = ?
			   LIMIT 0,1';

			//Prepare stmt
			$stmt = $this->conn->prepare($query);

			//bind id
			$stmt->bindParam(1, $this->id);

			//stmt execute
			$stmt->execute();

			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			//set prop return
			$this->id = $row['id'];
			$this->course_duration = $row['course_duration'];
			$this->current_learning_process = $row['current_learning_process'];
			$this->created_at = $row['created_at'];
			$this->due_date = $row['due_date'];


		}

	}