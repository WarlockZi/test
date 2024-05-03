<?php

namespace app\Actions;

use app\model\ProductUnit;
use app\model\Unitable;

class Helpers
{
    //copy from unitables to ProductUnit
    private function copyUnits()
    {
        $unitables = Unitable::all()->toArray();
        foreach ($unitables as $unitable) {
            $model = [
                'product_1s_id' => $unitable['product_id'],
                'unit_id' => $unitable['unitable_id'],
                'multiplier' => $unitable['multiplier'],
                'is_base' => $unitable['main'] ? 1 : null,
            ];
            ProductUnit::create($model);
        }
    }

// clean ports and start port 4000
    public function serve()
    {
        $host = '127.0.0.1';
//		$host = 'localhost';
        $ports = [4000];
        $self        = new self;

        foreach ($self->ports as $port) {
            $errno  = null;
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