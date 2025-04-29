<?php
function measureExecutionTime(callable $function, ...$args) {
    $startTime = microtime(true);
    call_user_func_array($function, $args);
    $endTime = microtime(true);
    $executionTime = round(($endTime - $startTime) * 1000, 2); // milliseconds
    return "Execution time: $executionTime ms";
}