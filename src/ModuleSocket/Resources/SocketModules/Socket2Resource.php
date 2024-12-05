<?php declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Resources\SocketModules;

/**
 * data:
 *       0 Byte Input number (0...1)
 *       1 Byte 1 – Processing on; 0 – Processing off (default on)
 *       2 Byte Anti-bounce duration *20ms. (default 5 <=> 100ms)
 */
class Socket2Resource extends Socket1Resource
{
}
