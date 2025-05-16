<?php
return [
    // select between: file, sync, database, cache
    'driver' => $_ENV['QUEUE_DRIVER'] ?? 'file',
];
