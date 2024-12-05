<?php declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Resources\SocketModules;

/**
 * data:
 *       0 Byte Relay number (0...3)
 *       1 Byte 1 – On; 0 – Off
 *       2 Byte On duration: 1-255 - 100ms intervals, 0 - always On
 */
class Socket5RelayActionResource extends Socket2RelayActionResource
{
}
