<?php

use App\config\loaders;

loaders\bootstrap();

return [
    'defaultIncludes' => [
      './cli-config.php'
    ],
];