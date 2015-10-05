<?php
	define("PUB_ENCRYPTION_KEY", "BEC30CAFE832FFA1");

	class security {

		public function encrypt($plaintext, $PRI_ENCRYPTION_KEY) {
			$cryptkey = $PRI_ENCRYPTION_KEY.PUB_ENCRYPTION_KEY;

			$size   = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
			$iv     = mcrypt_create_iv($size, MCRYPT_RAND);
			$cipher = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $cryptkey, $plaintext, MCRYPT_MODE_CBC, $iv);
			$cipher = rtrim($cipher, chr(0));

			return base64_encode($cipher);
		}

		public function decrypt($cipher, $PRI_ENCRYPTION_KEY) {
			$cryptkey = $PRI_ENCRYPTION_KEY.PUB_ENCRYPTION_KEY;

			$size   = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
			$iv     = mcrypt_create_iv($size, MCRYPT_RAND);
			$text   = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $cryptkey, $cipher, MCRYPT_MODE_CBC, $iv);
			$text   = rtrim($text, chr(0));

			return base64_decode($text);
		}
	}
?>