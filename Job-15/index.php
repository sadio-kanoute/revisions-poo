<?php
// Job-15: strictly follow the cahier des charges — only require Composer's
// autoloader (PSR-4). Do not fallback to legacy requires.

require __DIR__ . '/vendor/autoload.php';

echo "Job-15 ready: vendor/autoload.php required. Use App\\Abstract\\AbstractProduct, App\\Clothing and App\\Electronic via PSR-4.\n";

