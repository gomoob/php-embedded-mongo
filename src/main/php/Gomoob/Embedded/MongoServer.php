<?php

/**
 * gomoob/php-embedded-mongo
 *
 * @copyright Copyright (c) 2015, GOMOOB SARL (http://gomoob.com)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE.md file)
 */
namespace Gomoob\Embedded;

/**
 * Class which defines an embedded Mongo DB server.
 *
 * @author Baptiste GAILLARD (baptiste.gaillard@gomoob.com)
 */
class MongoServer
{
	/**
	 * @return int
	 */
	protected function getOS()
	{
		$os = strtoupper(PHP_OS);
		if (substr($os, 0, 3) === 'WIN') {
			return 'WINDOWS';
		} else if ($os === 'LINUX' || $os === 'FREEBSD' || $os === 'DARWIN') {
			return 'UNIX';
		}
		return 'UNKNOWN';
	}
	
	/**
	 * Starts the server.
	 */
	public function start()
	{
		$os = $this->getOS();
		
		$command = 'java -classpath ' . $this->createJavaClassPath();
		$command .= ' com.gomoob.embedded.EmbeddedMongo --mongo-port=27017 --socket-port=4309';

		if($os === 'WINDOWS') {

			if(!extension_loaded('com_dotnet')) {

				// TODO: Exception...

			}

			$WshShell = new \COM("WScript.Shell");
			$oExec = $WshShell->Run("CMD /C " . $command . " 1> output.log 2>&1", 0, false);
			echo $oExec;

		} else if($os === 'UNIX') {

			$this->pid = (int)shell_exec(sprintf('%s > %s 2>&1 & echo $!', $command, 'output.log'));

		}

	}
	
	public function stop()
	{
		$address = 'localhost';
		$port = 4309;
		
		$socket = socket_create(AF_INET, SOCK_STREAM, getprotobyname('tcp'));
		socket_connect($socket, $address, $port);
		
		$message = '{"command" : "stop"}' . PHP_EOL;
		$len = strlen($message);
		
		$status = socket_sendto($socket, $message, $len, 0, $address, $port);
		if($status !== FALSE)
		{
			$message = '';
			$next = '';
			while ($next = socket_read($socket, 4096))
			{
				$message .= $next;
			}
		
			echo $message;
		}
		else
		{
			echo "Failed";
		}
		
		socket_close($socket);
		
		// Clean-up the log file
		// TODO: Il serait bien d'avoir un mécanisme de logs tournants...
		// unlink('output.log');

	}
	
	/**
	 * Utility function used to create a Java class path required to start the Gomoob embedded MongoDB server.
	 *
	 * @return string The created Java class path.
	 */
	private function createJavaClassPath() {
	
		// Gets the operating system
		$sep = ':';
		$os = $this->getOS();
	
		// If we are under windows the classpath separator is ';'
		if($os === 'WINDOWS') {
				
			$sep = ';';
				
		}
	
		// Create JAR files list
		$jarFiles = [];
		$embeddedMongoPath = realpath(dirname(__FILE__) . '/../../../resources/embedded-mongo-0.0.1-SNAPSHOT/');
	
		if ($handle = opendir($embeddedMongoPath)) {
			while (false !== ($file = readdir($handle)))
			{
				if ($file != "." && $file != ".." && strtolower(substr($file, strrpos($file, '.') + 1)) == 'jar')
				{
					$jarFiles[] = realpath($embeddedMongoPath . '/' . $file);
				}
			}
			closedir($handle);
		}
	
		// Creates the Java Class path
		$javaClassPath = '';
		foreach($jarFiles as $jarFile) {
				
			if($javaClassPath !== '') {
				$javaClassPath .= $sep;
			}
				
			$javaClassPath .= $jarFile;
	
		}
	
		return $javaClassPath;
	
	}
}