<?php
	class User {

		private $con;
		private $username;
		private $role;

		public function __construct($con, $username) {
			$this->con = $con;
			$this->username = $username;
		}
        
        public function getUsername() {
            return $this->username;
		}

		public function getId() {
			$query = mysqli_query($this->con, "SELECT id FROM users 
			WHERE username='$this->username'");
			$row = mysqli_fetch_array($query);
			return $row['id'];
		}

		public function getRole() {
			$query = mysqli_query($this->con, "SELECT role FROM users 
			WHERE username='$this->username'");
			$row = mysqli_fetch_array($query);
			return $row['role'];
		}

		public function getRoleName() {
			return $this->getRole() == 1 ? 'Admin' : 'User';
		}
		
		public function getFullName() {
			$query = mysqli_query($this->con, "SELECT fullname FROM users 
			WHERE username='$this->username'");
			$row = mysqli_fetch_array($query);
			return $row['fullname'];
		}

		public function getEmail() {
			$query = mysqli_query($this->con, "SELECT email FROM users WHERE username='$this->username'");
			$row = mysqli_fetch_array($query);
			return $row['email'];
		}

		public function getTimeSignUp() {
			$query = mysqli_query($this->con, "SELECT signUpDate FROM users WHERE username='$this->username'");
			$row = mysqli_fetch_array($query);
			return $row['signUpDate'];
		}
	}
?>