<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: mohammad nazari
	 * Date: 9/3/13
	 * Time: 2:38 PM
	 * To change this template use File | Settings | File Templates.
	 */
	namespace Update;

		/**
		 * Cryptography Class
		 *
		 * Cryptography class to make things easier for the programmer.  To use this
		 * class, you should make sure you have both mcrypt and OpenSSL working
		 * in your environment.  This class will encrypt/decrypt with a 256bit
		 * AES encryption.  Also, it will generate public/private key-pairs and
		 * encrypt/decrypt with those.  There are two methods in this class that
		 * make encrypting large data using a public key system faster, and those
		 * are {@link LW_crypt::secureSend} and {@link LW_crypt:secureReceive}.
		 * Those two methods use both public key encryption, a one-time password
		 * and AES to encrypt the data specifically for an intended recipient using
		 * their public key.  Please note that this class will NOT encrypt the
		 * private key for you.  You should use the AES encryption along with
		 * your user's password to encrypt their private key and make it secure for
		 * storage.
		 */
	/**
	 * Class AESClass
	 *
	 * @package Update
	 */
	class AESClass
	{
		/**
		 * Public key used for encryption
		 *
		 * @var resource
		 */
		private $publicKey;
		/**
		 * Private key used for encryption
		 *
		 * @var resource
		 */
		private $privateKey;
		/**
		 * Private key used for encryption
		 *
		 * @var resource
		 */
		private $password;

		/**
		 * Constructor
		 *
		 * Pass the parameter of 'salt' to use with the class,
		 * if not provided, one is here automatically.  SALT
		 * MUST BE THE SAME when you encrypt/decrypt data, so
		 * keep it constant within your application
		 *
		 */
		public
		function __construct()
		{
		}

		/**
		 * Assign the public key to encrypt
		 *
		 * @param string $key
		 */
		function SetPublicKey($key)
		{
			$this->publicKey = trim($key);
		}

		/**
		 * Assign the private key to encrypt
		 *
		 * @param string $key
		 */
		function SetPrivateKey($key)
		{
			$this->privateKey = trim($key);
		}

		/**
		 * Get public key
		 *
		 * @return resource
		 */
		function GetPublicKey()
		{
			return $this->publicKey;
		}

		/**
		 * Get private key
		 *
		 * @return resource
		 */
		function GetPrivateKey()
		{
			return $this->privateKey;
		}

		/**
		 * Assign the private key to encrypt
		 *
		 * @param    $key
		 */
		function SetPassword($key)
		{
			$this->password = trim($key);
		}

		/**
		 * Get private key
		 *
		 * @return resource
		 */
		function GetPassword()
		{
			return $this->password;
		}

		/**
		 * Encrypt AES
		 *
		 * Will Encrypt data with a password in AES compliant encryption.  It
		 * adds built in verification of the data so that the {@link LW_crypt::decryptAES}
		 * can verify that the decrypted data is correct.
		 *
		 * @param String $data This can either be string or binary input from a file
		 *
		 * @return String The encrypted data in concatenated base64 form.
		 */
		public
		function EncryptAESData($data)
		{
			if ($data != "")
			{
				$data = trim($data);
				//Encrypt the data with AES 256 bit
				$data = openssl_encrypt($data, "AES-256-ECB", $this->password);
//				$data = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $this->password, $data, MCRYPT_MODE_ECB);
//				$data = base64_encode(($data));
			}

			return $data;
		}

		/**
		 * Decrypt AES
		 *
		 * Decrypts data previously encrypted WITH THIS CLASS, and checks the
		 * integrity of that data before returning it to the programmer.
		 *
		 * @param String $data The encrypted data we will work with
		 *
		 * @return String|Boolean False if the integrity check doesn't pass, or the raw decrypted data.
		 */
		public
		function DecryptAESData($data)
		{
			if ($data != "")
			{
				//$data = base64_decode(($data));
				//Decrypt the data with AES 256 bit
				$data = openssl_decrypt($data, "AES-256-ECB", $this->password);
//				$data = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->password, $data, MCRYPT_MODE_ECB);
				//Cut raw data from start to "\0"
				list($data, $trashData) = explode("\0", $data);
			}

			return $data;
		}

		/**
		 * Generate Password
		 *
		 * Will create a password 30 chars in length, meant to be used as a one-time
		 * password and then used with {@link LW_crypt::encryptAES}.
		 *
		 * @param int $Len
		 *
		 * @return String Password 30 characters in length
		 */
		public
		function generatePassword($Len = 32)
		{
			//create a random password here
			$chars
				= array('a', 'A', 'b', 'B', 'c', 'C', 'd', 'D', 'e', 'E', 'f', 'F', 'g', 'G', 'h', 'H', 'i', 'I', 'j',
						'J', 'k', 'K', 'l', 'L', 'm', 'M', 'n', 'N', 'o', 'O', 'p', 'P', 'q', 'Q', 'r', 'R', 's', 'S',
						't', 'T', 'u', 'U', 'v', 'V', 'w', 'W', 'x', 'X', 'y', 'Y', 'z', 'Z', '1', '2', '3', '4', '5',
						'6', '7', '8', '9', '0', '?', '<', '>', '.', ',', ';', '-', '@', '!', '#', '$', '%', '^', '&',
						'*', '(', ')');
			$max_chars = count($chars) - 1;
			srand((double)microtime() * 1000000);
			$rand_str = '';
			for ($i = 0; $i < $Len; $i++)
			{
				$rand_str .= $chars[rand(0, $max_chars)];
			}
			$this->SetPassword($rand_str);

			return $rand_str;
		}

		/**
		 * Generate Key Pair
		 *
		 * This function will use OpenSSL to generate a public/private
		 * key-pair that is then returned to be stored how the programmer
		 * sees fit.  Since this class isn't meant to make certificates
		 * or anything of the sort, none are made, just a private key,
		 * and a public key ^^
		 *
		 * @return Array Returns an associative array 'privateKey' and 'publicKey'
		 */
		public
		function makeKeyPair()
		{
			//Define variables that will be used, set to ''
			$private = '';
			$public = '';
			//Generate the resource for the keys
			$config = array("digest_alg"       => "sha512", "private_key_bits" => 1024,
							"private_key_type" => OPENSSL_KEYTYPE_RSA,);
			$resource = openssl_pkey_new($config);
			//get the private key
			openssl_pkey_export($resource, $private);
			//get the public key
			$public = openssl_pkey_get_details($resource);
			$public = $public["key"];
			$this->SetPrivateKey($private);
			$this->SetPublicKey($public);
			$ret = array('privateKey' => $private, 'publicKey' => $public);

			return $ret;
		}

		/**
		 * Public Encryption
		 *
		 * Will encrypt data based on the public key
		 *
		 * @param String $data The data to encrypt
		 *
		 * @return String The Encrypted data in base64 coding
		 */
		public
		function PublicEncryptData($data)
		{
			
			if ($data != "")
			{
				//encrypt it
				openssl_public_encrypt($data, $data, $this->publicKey);

				return $data;
			}

			//return it
			return $data;
		}

		/**
		 * Private Decryption
		 *
		 * Decrypt data that was encrypted with the assigned private
		 * key's public key match. (You can't decrypt something with
		 * a private key if it does n't match the public key used.)
		 *
		 * @param String $data The data to decrypt (in base64 format)
		 *
		 * @return String The raw decoded data
		 */
		public
		function PrivateDecryptData($data)
		{
			
			if ($data != "")
			{
				//decrypt it
				openssl_private_decrypt($data, $data, $this->privateKey);
				//Cut raw data from start to "\0"
				list($data, $trashData) = explode("\0", $data);

				//return the decrypted data
				return $data;
			}

			//return the decrypted data
			return $data;
		}

		/**
		 * sign the file
		 *
		 * for secured transfering We encrypt and sign data
		 * with private key and password
		 *
		 * @param $cleartext
		 *
		 * @return string
		 */
		function sign($cleartext)
		{
			$signed_data = $cleartext;
			if ($signed_data != "")
			{
				// Get data MD5
				$msg_hash = md5($signed_data);
				$sig = "";
				$ok = openssl_sign($msg_hash, $sig, $this->privateKey);
				if ($ok == 1)
				{
					// append sign into end of data
					$signed_data .= "----SIGNATURE:----" . base64_encode($sig);
				}
				elseif ($ok == 0)
				{
					$signed_data = "";
				}
				else
				{
					$signed_data = "";
				}
			}

			return $signed_data;
		}

		/**
		 * @param $my_signed_data
		 *
		 * @return string
		 */
		function verify($my_signed_data)
		{
			$plain_data = $my_signed_data;
			if ($plain_data != "")
			{
				list($plain_data, $old_sig) = explode("----SIGNATURE:----", $plain_data);
				$old_sig = base64_decode($old_sig);
				$data_hash = (md5($plain_data));
				$ok = openssl_verify($data_hash, $old_sig, $this->publicKey);
				if ($ok == 1)
				{
					return $plain_data;
				}
				elseif ($ok == 0)
				{
					$plain_data = "";
				}
				else
				{
					$plain_data = "";
				}
			}

			return $plain_data;
		}

		/**
		 * Secure Send
		 *
		 * OpenSSL and 'public-key' schemes are good for sending
		 * encrypted messages to someone that can then use their
		 * private key to decrypt it.  However, for large amounts
		 * of data, this method is incredibly slow.  This function
		 * will take the public key to encrypt the data to, and
		 * using that key will encrypt a one-time-use randomly
		 * generated password.  That one-time password will be
		 * used to encrypt the data that is provided.  So the data
		 * will be encrypted with a one-time password that only
		 * the owner of the private key will be able to uncover.
		 * This method will return a base64encoded serialized array
		 * so that it can easily be stored, and all parts are there
		 * without modification for the receive function
		 *
		 * @param String $data The data to encrypt
		 *
		 * @return String serialized array of 'password' and 'data'
		 */
		public
		function SecureSendDataToServer($data)
		{
			
			if ($data != "")
			{
				//Now, we will encrypt in AES the data
				$data = $this->EncryptAESData($data);
				//Now we will encrypt the password with the public key
//			$data = $this->PublicEncryptData($data);
				//serialize the array and then base64 encode it
//			$data = serialize($data);
				$data = base64_encode($data);

				//send it on its way
				return trim($data);
			}

			//send it on its way
			return trim($data);
		}

		/**
		 * Secure Receive
		 *
		 * This is the compliment of {@link LW_crypt::secureSend}.
		 * Pass the data that was returned from secureSend, and it
		 * will dismantle it, and then decrypt it based on the
		 * private key provided.
		 *
		 * @param String $data the base64 serialized array
		 *
		 * @return String the decoded data.
		 */
		public
		function SecureReceiveDataFromClient($data)
		{
			if ($data != "")
			{
				//Let's decode the base64 data
				$data = base64_decode($data);
				//Now we'll get the AES password by decrypting via OpenSSL
//			$data = $this->PrivateDecryptData($data);
				//and now decrypt the data with the password we found
				$data = $this->DecryptAESData($data);

				//return the data
				return trim($data);
			}

			//return the data
			return trim($data);
		}

		/**
		 * Secure Send
		 *
		 * OpenSSL and 'public-key' schemes are good for sending
		 * encrypted messages to someone that can then use their
		 * private key to decrypt it.  However, for large amounts
		 * of data, this method is incredibly slow.  This function
		 * will take the public key to encrypt the data to, and
		 * using that key will encrypt a one-time-use randomly
		 * generated password.  That one-time password will be
		 * used to encrypt the data that is provided.  So the data
		 * will be encrypted with a one-time password that only
		 * the owner of the private key will be able to uncover.
		 * This method will return a base64encoded serialized array
		 * so that it can easily be stored, and all parts are there
		 * without modification for the receive function
		 *
		 * @param String $data The data to encrypt
		 *
		 * @return String serialized array of 'password' and 'data'
		 */
		public
		function SecureSendDataToClient($data)
		{
			if ( $data!= "")
			{
				//Now, we will encrypt in AES the data
				$data = $this->EncryptAESData($data);
				//Let's encode the base64 data
//				$data = base64_encode(($data));
				//Sign your Data with Private Key
//				$data = $this->sign($data);
				//Let's encode the base64 data
				$data = base64_encode(($data));

				//send it on its way
				return ($data);
			}

			//send it on its way
			return ($data);
		}

		/**
		 * Secure Receive
		 *
		 * This is the compliment of {@link LW_crypt::secureSend}.
		 * Pass the data that was returned from secureSend, and it
		 * will dismantle it, and then decrypt it based on the
		 * private key provided.
		 *
		 * @param String $data the base64 serialized array
		 *
		 * @return String the decoded data.
		 */
		public
		function SecureReceiveDataFromServer($data)
		{
			
			if ($data != "")
			{
				//Let's decode the base64 data
				$data = base64_decode($data);
				//Now we'll get the AES password by decrypting via OpenSSL
//				$data = $this->verify($data);
				//Let's decode the base64 data
//				$data = base64_decode($data);
				//and now decrypt the data with the password we found
				$data = $this->DecryptAESData($data);

				//return the data
				return trim($data);
			}

			//return the data
			return trim($data);
		}
	}