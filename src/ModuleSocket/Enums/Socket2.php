<?php

declare(strict_types=1);

namespace Autodoctor\ModuleSocket\Enums;

/**
 * Here are the commands of Socket-2 and Socket-2W modules
 * The command 'GET_ANALOG_INPUT' is only for the 'Socket-2W' module
 * and digital/analog input number '0'
 */

/**
 * The Socket-2W module supports all the commands and events of the Socket-2 module.
 * In addition, since its discrete input 0 can be configured as analog,
 * it has an additional command to get the analog input value.
 * The measured voltage range at the analog input is from 0 to 1.0 Volts.
 * The voltage value obtained by the read command is transmitted as an integer from 0 to
 * 1024 (2 Bytes) proportional to the voltage applied to the input.
 * Switching input 0 from discrete to analog mode is described in the
 * 'Operating Manual'. Applying voltage over 1.0 Volts is unacceptable and
 * may cause the module to fail.
 */
enum Socket2: string implements Resolution
{
    use Helper;

    case SetInput = Commands::SetInput->value;
    case GetInput = Commands::GetInput->value;
    case RelayAction = Commands::RelayAction->value;
    case GetAllStatus = Commands::GetAllStatus->value;
    case GetAnalogInput = Commands::GetAnalogInput->value;

    public const TYPE = ModuleTypes::Socket2->value;
    // rules
    public const INPUT_START_NUMBER = 0;
    public const INPUT_END_NUMBER = 1;
    public const RELAY_START_NUMBER = 0;
    public const RELAY_END_NUMBER = 1;
}
