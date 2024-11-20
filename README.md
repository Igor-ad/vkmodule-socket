## VKmodule PHP Socket-client Library 
PHP driver library for use with VKmodule 'Socket-N' type electronic devices. Control and monitoring modules via the Ethernet network.

**The logo and trademark "VKmodule" belong to the manufacturer of the devices, the company "VKmodule".**

[![VKmodule Socket PHP client Library](https://vkmodule.com.ua/images/vkmodule_logo.png)](https://vkmodule.com.ua/Ethernet_ua.html)


![License MIT](https://img.shields.io/badge/License-MIT-blue)
[![Supported PHP Versions](https://img.shields.io/badge/PHP-8.2,%208.3,%208.4-blue)](https://github.com/Igor-ad/VKmodule-php-client-library/)
![GitHub release](https://img.shields.io/badge/Release-Beta_0.8.8-green)


Home page of the manufacturer of Socket-N controller modules -
https://vkmodule.com.ua/Ethernet_ua.html

## Table of Contents.
   * [VKmodule PHP Socket-client Library](README.md)
   * [Table of Contents](#table-of-contents)
   * [Description](#description-of-library)
     * [System requirements](#system-requirements)
     * [Compatibility with devices](#compatibility-with-devices)
     * [Protocols](#protocols-tcpip-http)
     * [System Configuration](#system-configuration)
     * [Installation](#installation)
   * [CLI](#cli)
     * [Available console command](#available-console-commands)
       * [Common console commands](#common-console-commands)
         * [Example for a single-module system](#example-for-a-single-module-system)
         * [Example for a multi-module system](#examples-of-console-commands-with-a-query-string-for-a-multi-module-system)
       * [Module control commands](#module-control-commands)
   * [API](#api)
     * [Api console command](#api-commands)

## Description of library.

Open-source PHP library

#### System requirements.
PHP 8.2 and higher, Composer, cron or Cli.

The library's API can be used as part of the framework or with any HTTP server.

#### Compatibility with devices.

Currently, the library supports interaction with modules of the following types:
* Socket-1
* Socket-2
* Socket-2W
* Socket-3
* Socket-4
* Socket-5
* Socket-Giant

The hardware modules are configured as a SERVER, the library operates as a CLIENT.    

Working with modules is not yet supported:

* EM-marine card readers (VRD-E)

#### Protocols (TCP/IP, HTTP).

The above modules are equipped with a built-in HTTP server for configuring operating modes and network parameters. Therefore, the library does not currently implement the HTTP protocol. Only the TCP/IP protocol is used.

#### System configuration.

To control a system with a single-module implementation, it is enough to specify the module parameters in the configuration file -
`./config/vk_module.php`.
When simultaneously managing different modules in a multi-module system, the module parameters must be sent in each request as a JSON string, for example -

```'{"module":{"host":"192.168.4.191","port":9761,"type":"Socket-2"}}'```
Otherwise, the default module parameters specified in the configuration file will be accepted.
#### Installation.
The library can be used by simply copying the files to the working directory. When using
as a cron worker or from the command line, an HTTP server is not required.

Init application:
```
mkdir projects
cd projects
git clone https://github.com/Igor-ad/vkmodule-socket.git
cd ./vkmodule-socket
chmode +x ./console/cli.php
```

The name and directory of the log file can be changed in the configuration file.



## CLI

The executable file for console commands is  `./console/cli.php`

Syntax: `./console/cli.php <command> <JSON query string (optional)>`

Command and module response debug logs will be written to the log file `./log/socket_module.log`

### Available console commands.

### Common console commands.

General-purpose commands are supported by all module types and do not require a query string for a single-module system. Module parameters for a single-module system are retrieved from the configuration file - `./config/vk_module.php`

```
connection
firmware
reboot
uid
```

#### Example for a single-module system:
```
# Checking the connection to the module
./console/cli.php connection

# Extracting information about the module firmware version
./console/cli.php firmware

# Module Reboot command
./console/cli.php reboot

# Command to get a unique module identifier
./console/cli.php uid
```

#### Examples of console commands with a query string for a multi-module system.
Two parameters are passed to the executable file`./console/cli.php`, the first parameter is the command name, the second parameter is the query string in JSON format. Controller parameters are passed in the query string.

Command - Connection:
```
./console/cli.php connection '{"module":{"host":"192.168.4.191","port":9761,"type":"Socket-2"}}'
```

Response:
```
{
    "success": true,
    "event": {
        "id": "01",
        "description": "CheckConnect",
        "data": {
            "status": "online"
        }
    }
}
```

Command - Firmware:
```
./console/cli.php firmware '{"module":{"host":"192.168.4.191","port":9761,"type":"Socket-2"}}' 
```

Response:
```
{
    "success": true,
    "event": {
        "id": "03",
        "description": "GetFirmware",
        "data": {
            "controllerType": "Socket-3",
            "version": "0000",
            "firmwareType": "regular",
            "firmware": "04000000"
        }
    }
}
```

Command - Reboot:
```
./console/cli.php reboot '{"module":{"host":"192.168.4.191","port":9761,"type":"Socket-2"}}'
```

Response:
```
{
    "success": true,
    "event": {
        "id": "02",
        "description": "RebootController",
        "data": null
    }
}
```

Command - Uid:
```
./console/cli.php uid '{"module":{"host":"192.168.4.191","port":9761,"type":"Socket-3"}}' 
```

Response:
```
{
    "success": true,
    "event": {
        "id": "04",
        "description": "GetUid",
        "data": {
            "uid": 873
        }
    }
}
```

### Module control commands.

Commands for control and monitoring of modules:
```
 name of command     |  modules types support	 |  description
_____________________|___________________________|_____________________________________	
cli_full_control **  | for all types of modules	 | any command by ID
input_analog         | Socket-2W only            | analog input voltage value
input_setup *        | Socket-(1,2,5,Giant)      | configure digital input 
input_status *       | Socket-(1,2,5,Giant)      | digital input status
input_temperature0   | Socket-3 only             | sensor 0 temperature value
input_temperature1   | Socket-3 only             | sensor 1 temperature value
relay_control *      | Socket-(2,3,4,5,Giant)    | relay control
relay_group_control *| Socket-Giant only         | control all module relays
relay_off *          | Socket-(2,3,4,5,Giant)    | turn off relay
relay_on *           | Socket-(2,3,4,5,Giant)    | turn on relay 
status               | for all types of modules  | get the state of all inputs/outputs
```
#### _Notes_ 

*_**The command requires sending a query string with data - the digital input or relay number and control parameters (optional).**_

**_**The command requires sending the module command ID in the query string and knowledge of the module manufacturer's documentation**_.


The console command name corresponds to the command class name. You can write the console command name in both snake case and kebab case, as well as camel case and pascal case. For convenience, all console command names in this file are written in snake case.

#### Example of console commands.


Command - FullControl:
```
./console/cli.php cli_full_control '{"command":{"id":"43","data":{"relay":{"relayNumber":0,"action":1,"interval":30}}},"module":{"host":"192.168.4.191","port":9761,"type":"Socket-3"}}'
```
Response:
```
{
    "success": true,
    "event": {
        "id": "43",
        "description": "Socket3RelayAction",
            "relay": {
                "relayNumber": 0,
                "action": 1,
                "interval": 30
            }
    }
}
```
Only a complete and formatted query string:
```
{
    "command": {
        "id": "43",
        "data": {
            "relay": {
                "relayNumber": 0,
                "action": 1,
                "interval": 30
            }
        }
    },
    "module": {
        "host": "192.168.4.191",
        "port": 9761,
        "type": "Socket-3"
    }
}
```

Command - InputSetup:
```
./console/cli.php input_setup '{"command":{"data":{"input":{"inputNumber":1,"action":1,"antiBounce":5}}}}'
```
Response:
```
{
    "success": true,
    "event": {
        "id": "20",
        "description": "SetInput",
        "data": {
            "input": {
                "inputNumber": 1,
                "triggerAction": "Open",
                "antiBounce": 5
            }
        }
    }
}
```
Command - InputStatus:
```
./console/cli.php input_status '{"command":{"data":{"input":{"inputNumber":0}}}}'
```
Response:
```
{
    "success": true,
    "event": {
        "id": "20",
        "description": "SetInput",
        "data": {
            "input": {
                "inputNumber": 0,
                "triggerAction": "Open",
                "antiBounce": 4
            }
        }
    }
}
```

Command - RelayControl:
```
./console/cli.php relay_control '{"command":{"data":{"relay":{"relayNumber":0,"action":1,"interval":5}}}}' 
```
Response:
```
{
    "success": true,
    "event": {
        "id": "22",
        "description": "RelayAction",
        "data": {
            "relay": {
                "relayNumber": 0,
                "action": "On",
                "interval": 5
            }
        }
    }
}
```

Command - RelayOn:
```
./console/cli.php relay_on '{"command":{"data":{"relay":{"relayNumber":0}}}}'
```
Response:
```
{
    "success": true,
    "event": {
        "id": "22",
        "description": "RelayAction",
        "data": {
            "relay": {
                "relayNumber": 0,
                "action": "On",
                "interval": 0
            }
        }
    }
}
```

Command - RelayOff:
```
./console/cli.php relay_off '{"command":{"data":{"relay":{"relayNumber":0}}},"module":{"host":"192.168.4.191","port":9761,"type":"Socket-3"}}'
```

Response:
```
{
    "success": true,
    "event": {
        "id": "43",
        "description": "Socket3RelayAction",
        "data": {
            "relay": {
                "relayNumber": 0,
                "action": "Off",
                "interval": 0
            }
        }
    }
}
```

Command - InputTemperature0:
```
./console/cli.php input_temperature0 '{"module":{"host":"192.168.4.191","port":9761,"type":"Socket-3"}}'
```
Response:
```
{
    "success": true,
    "event": {
        "id": "41",
        "description": "GetTemperatureSensor0",
        "data": {
            "input": {
                "sensor0": {
                    "sign": "+",
                    "temperature": 21
                }
            }
        }
    }
}
```

Command - InputTemperature1:
```
./console/cli.php input_temperature1 '{"module":{"host":"192.168.4.191","port":9761,"type":"Socket-3"}}'
```
Response:
```
{
    "success": true,
    "event": {
        "id": "42",
        "description": "GetTemperatureSensor1",
        "data": {
            "input": {
                "sensor1": {
                    "sign": "+",
                    "temperature": 28
                }
            }
        }
    }
}
```

Command - Status
```
./console/cli.php status '{"module":{"host":"192.168.4.191","port":9761,"type":"Socket-3"}}'
```
Response:
```
{
    "success": true,
    "event": {
        "id": "44",
        "description": "Socket3GetAllStatus",
        "data": {
            "input": {
                "sensor0": {
                    "sign": "+",
                    "temperature": 21
                },
                "sensor1": {
                    "sign": "+",
                    "temperature": 31
                }
            },
            "relay": {
                "relay0": "Off",
                "relay1": "Off"
            }
        }
    }
}
```

Example of recording in a log file:
```
2024-11-08 11:42:11 | pid: 24169 | info: Start |  
2024-11-08 11:42:11 | pid: 24169 | info: {"module":{"host":"192.168.4.191","port":9761,"type":"Socket-3"}} |  
2024-11-08 11:42:11 | pid: 24169 | debug: {"success":true,"event":{"id":"44","description":"Socket3GetAllStatus","data":["15","1f","00","00"]}} | CommandToJson: {"command":{"id":"44","description":"Socket3GetAllStatus","data":null}} | HexCommandData:  
2024-11-08 11:42:11 | pid: 24169 | info: ResponseToJson: {"success":true,"event":{"id":"44","description":"Socket3GetAllStatus","data":{"input":{"sensor0":{"sign":"+","temperature":21},"sensor1":{"sign":"+","temperature":31}},"relay":{"relay0":"Off","relay1":"Off"}}}} |  
2024-11-08 11:42:11 | pid: 24169 | info: End |   
```

## API

Functionally and in syntax, all API commands correspond to Cli commands.

Differences:
* there is no recording of debugging information about the command and module response in the Log file;
* all API commands return a JSON string - the result of parsing the module response;
* all API command names have the prefix "api_" ("Api" for command classes);


To use the API as part of any framework or with any HTTP server, you can
use the example from the `./public/index_api.php` file.
The file accepts a request with two string parameters:
1. cmd - command name;
2. query - JSON query string (optional);

The query string is similar to the string for Cli commands.
### Api commands

Common commands (supported by all modules):
```
api_connection
api_firmware
api_reboot
api_uid
```
API commands for control and monitoring of modules:
```
api_full_control **
api_input_analog
api_input_setup *
api_input_status *
api_input_temperature0 
api_input_temperature1
api_relay_control *
api_relay_group_control *
api_relay_off *
api_relay_on *
api_status
```
[* Notes](#notes-)

### Unit Tests

In progress...
