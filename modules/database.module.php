<?php
	class database {

		private $db_config;

		public function __construct($config) {
			$this->db_config["host"] = 'mysql:host=localhost;dbname='.$config->database;
			$this->db_config["user"] = $config->username;
			$this->db_config["pswd"] = $config->password;
		}

		// Fetch dynamic information from the database
		public function fetchInformation($table, $select, $where, $value) {
			try {
				$db  = new pdo($this->db_config["host"], $this->db_config["user"], $this->db_config["pswd"]);
				$sql = $db->prepare("SELECT ".$select." FROM ".$table." WHERE  ".$where." = :value");
				$sql->execute(array(':value' => $value));
				if($select == "*") {
					$row = $sql->fetch(PDO::FETCH_ASSOC);
				} else {
					$row = $sql->fetchColumn();
				}
				unset($db);
				return $row;
			} catch(PDOException $e) {
				die("Database Error: ".$e);
			}
		}

		// Insert into database (use an associative array for $insert)
		// Key: What field to set
		// Val: What to set the field's value to
		public function insertInformation($table, $insert) {
			$keys = implode(",", array_keys($insert));
			$vals = implode(",", array_values($insert));
			try {
				$db  = new pdo($this->db_config["host"], $this->db_config["user"], $this->db_config["pswd"]);
				$sql = $db->prepare("INSERT INTO ".$table." (:keys) VALUES (:vals)");
				$sql->execute(array(':keys' => $keys, ':vals' => $vals));
				unset($db);
				return true;
			} catch(PDOException $e) {
				die("Database Error: ".$e);
				return false;
			}
		}

		// Update database (use an associative array for $update)
		// Key: What field to update
		// Val: What to update the field to
		public function updateInformation($table, $update, $where, $val) {
			foreach($update as $key => $value) {
				$x++;
				$set .= "".$key." = ".$value."";
				if(count($update) > $x) {
					$set .= ", ";
				}
			}
			try {
				$db  = new pdo($this->db_config["host"], $this->db_config["user"], $this->db_config["pswd"]);
				$sql = $db->prepare("UPDATE ".$table." SET ".$set." WHERE ".$where." = ".$val."");
				$sql->execute();
				unset($db);
				return $row;
			} catch(PDOException $e) {
				die("Database Error: ".$e);
				return false;
			}
		}
	}
?>