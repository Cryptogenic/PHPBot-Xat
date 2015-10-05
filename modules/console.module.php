<?php
	class console {

		public function inform($inform, $official = false) {
			if($official) {
				switch($inform) {
					case "INTRO":
						$l  = '  _____ _      ____  _    _ _____  ____   ____ _______ '.PHP_EOL;
						$l .= ' / ____| |    / __ \| |  | |  __ \|  _ \ / __ \__   __|'.PHP_EOL;
						$l .= '| |    | |   | |  | | |  | | |  | | |_) | |  | | | |  '.PHP_EOL;
						$l .= '| |    | |   | |  | | |  | | |  | |  _ <| |  | | | |   '.PHP_EOL;
						$l .= '| |____| |___| |__| | |__| | |__| | |_) | |__| | | |   '.PHP_EOL;
						$l .= ' \_____|______\____/ \____/|_____/|____/ \____/  |_|   '.PHP_EOL.PHP_EOL;
						$l .= '*******************************************************'.PHP_EOL;
						$l .= 'Created by Specter (Cryptogenic), Ethan, and Jaden'.PHP_EOL.PHP_EOL;
						echo $l;
				}
			} else {
				$start = "\033[0;0m[INFO] ";
				$end   = "\033[0;0m".PHP_EOL;
				echo $start.$inform.$end;
			}
			return true;
		}

		// Write that we sent (or recieved) data to the console
		public function send($output) {
			$start = "\033[1;36m[SENT] ";
			$end   = "\033[0;0m".PHP_EOL;
			echo $start.$output.$end;
			return true;
		}

		// Write that we recieved data to the console
		public function recv($output) {
			$start = "\033[1;36m[RECV] ";
			$end   = "\033[0;0m".PHP_EOL;
			echo $start.$output.$end;
			return true;
		}

		// Write that we have an error to the console
		public function error($error) {
			$start = "\033[1;31m[ERRO] ";
			$end   = "\033[0;0m".PHP_EOL;
			die($start.$error.$end);
		}
	}
?>
