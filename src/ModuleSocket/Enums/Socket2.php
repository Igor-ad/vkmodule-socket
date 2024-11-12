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
enum Socket2
{
    const TYPE = 'Socket-2';
    const SET_INPUT = Commands::SET_INPUT->value;
    const GET_INPUT = Commands::GET_INPUT->value;
    const RELAY_ACTION = Commands::RELAY_ACTION->value;
    const GET_ALL_STATUS = Commands::GET_ALL_STATUS->value;
    const GET_ANALOG_INPUT = Commands::GET_ANALOG_INPUT->value;
    const COMMANDS = [
        self::SET_INPUT,
        self::GET_INPUT,
        self::RELAY_ACTION,
        self::GET_ALL_STATUS,
        self::GET_ANALOG_INPUT,
    ];
    // rules
    const INPUT_START_NUMBER = 0;
    const INPUT_END_NUMBER = 1;
    const RELAY_START_NUMBER = 0;
    const RELAY_END_NUMBER = 1;

    public static function allowedInput(): array
    {
        return [self::INPUT_START_NUMBER, self::INPUT_END_NUMBER];
    }

    public static function allowedRelay(): array
    {
        return [self::RELAY_START_NUMBER, self::RELAY_END_NUMBER];
    }
}