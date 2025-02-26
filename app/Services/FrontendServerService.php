<?php


namespace app\Services;


class FrontendServerService
{
	protected string $host;
	protected array $ports;

	public function __construct()
	{
		$this->host = '127.0.0.1';
//		$this->host = 'localhost';
		$this->ports = [4000];
	}

	public static function serve()
	{
		$self = new self;

		foreach ($self->ports as $port) {
			$errno = null;
			$errstr = null;

			$connection = @fsockopen($self->host, $port, $errno, $errstr);

			if (is_resource($connection)) {
//				$command = "npx kill-port $port";
//				$output = exec($command);
//				fclose($connection);
////				echo '<p>' . $self->host . ':' . $port . ' ' . '(' . getservbyport($port, 'tcp') . ') is open.</p>' . "\n";
//				$output = shell_exec('npm run serve');

			} else {
//				$output = shell_exec('npm run serve');
//				$output = shell_exec('npm run serve');
//				echo "<p>{$self->host}:{$port} is not responding. Error {$errno}: {$errstr} </p>" . "\n";
			}
		}
	}

}