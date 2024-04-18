<?php

namespace App\Loggin;

use Monolog\Formatter\LineFormatter;

class SimpleFormatter{


     public function __invoke($logger)
     {
        foreach($logger->getHandlers() as $handler){
            //$handler->setFormatter(new LineFormatter('[%datetime%]: %message% %context% %extra% '));
            $format = "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n";
            $dateFormat = "d-m-Y H:i"; // Formato personalizado para fecha y hora

            // Establece el formateador de línea con el formato personalizado
            $handler->setFormatter(new LineFormatter($format, $dateFormat, true, true));
        }
     }
}
