<?php
	class socket {

		public $socket = null;

		public function __construct($parent) {
			$this->parent = &$parent;
		}

		public function listen($xml = True, $handle = True) {
			$packet = rtrim(@socket_read($this->socket, 32768));
			if($packet == null) {
				return null;
			}
			$this->log($packet, "recv");
			if($handle == True && $xml == True) {
				$this->parent->modules["function"]->handlePacket(simplexml_load_string($packet));
			}
			if($xml) {
				return simplexml_load_string($packet);
			} else {
				return $packet;
			}
		}

		public function write($tag, $data) {
			$packet = "<".$tag;
			if(!empty($data) && is_array($data)) {
				foreach($data as $k => $v) {
					$packet .= " ".$k."=\"".$v."\"";
				}
			}
			$packet .= " />";
			if($packet{strlen($packet)-1} != chr(0))
				$packet .= chr(0);
			$this->log($packet, "send");
			socket_write($this->socket, $packet);
		}

		public function log($packet, $type) {
			switch($type) {
				case "recv":
					$start = "\033[1;36m[RECV] ";
					$end   = "\033[0;0m".PHP_EOL;
					if($this->parent->debug)
						echo $start.$packet.$end;
					break;
				case "send":
					$start = "\033[1;36m[SENT] ";
					$end   = "\033[0;0m".PHP_EOL;
					if($this->parent->debug)
						echo $start.$packet.$end;
					break;
			}
		}
	}
?>