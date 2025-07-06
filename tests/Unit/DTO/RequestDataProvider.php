<?php

declare(strict_types=1);

namespace Tests\Unit\DTO;

trait RequestDataProvider
{
    public static function requestDataProvider(): array
    {
        return [
            ['{"command":{"id":"01"},"module":{"host":"localhost","port":9761,"type":"Socket-1"}}'],
            ['{"command":{"id":"02"},"connector":{"timeOut":3,"type":"TCP"},"module":{"host":"localhost","port":9761,"type":"Socket-2"}}'],
            ['{"command":{"id":"03"},"connector":{"timeOut":5,"type":"TCP"},"module":{"host":"localhost","port":9761,"type":"Socket-3"}}'],
            ['{"command":{"id":"04"},"module":{"host":"localhost","port":9761,"type":"Socket-4"}}'],
            ['{"command":{"id":"20","data":{"input":{"inputNumber":0,"action":1,"antiBounce":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-2"}}'],
            ['{"command":{"id":"21","data":{"input":{"inputNumber":0}}},"connector":{"timeOut":5,"type":"TCP"},"module":{"host":"localhost","port":9761,"type":"Socket-2"}}'],
            ['{"command":{"id":"22","data":{"relay":{"relayNumber":0,"action":1,"interval":30}}},"connector":{"type":"TCP","timeOut":5},"module":{"ip":"localhost","port":9761,"type":"Socket-2"}}'],
            ['{"command":{"id":"23"},"connector":{"type":"TCP","timeOut":5},"module":{"ip":"localhost","port":9761,"type":"Socket-2"}}'],
            ['{"command":{"id":"24"},"connector":{"timeOut":5,"type":"TCP"},"module":{"host":"localhost","port":9761,"type":"Socket-2"}}'],
            ['{"command":{"id":"25","data":{"relayGroup":{"relayGroupAction":"ffff"}}},"connector":{"type":"TCP","timeOut":3},"module":{"ip":"localhost","port":9761,"type":"Socket-Giant"}}'],
            ['{"command":{"id":"30","data":{"input":{"inputNumber":0,"action":1,"antiBounce":5}}},"module":{"host":"localhost","port":9761,"type":"Socket-1"}}'],
            ['{"command":{"id":"31","data":{"input":{"inputNumber":0}}},"connector":{"timeOut":5,"type":"TCP"},"module":{"host":"localhost","port":9761,"type":"Socket-1"}}'],
            ['{"command":{"id":"32"},"connector":{"type":"TCP","timeOut":5},"module":{"ip":"localhost","port":9761,"type":"Socket-1"}}'],
            ['{"command":{"id":"41"},"connector":{"timeOut":5,"type":"TCP"},"module":{"host":"localhost","port":9761,"type":"Socket-3"}}'],
            ['{"command":{"id":"42"},"connector":{"timeOut":5,"type":"TCP"},"module":{"host":"localhost","port":9761,"type":"Socket-3"}}'],
            ['{"command":{"id":"43","data":{"relay":{"relayNumber":1,"action":1,"interval":50}}},"connector":{"type":"TCP","timeOut":10},"module":{"ip":"localhost","port":9761,"type":"Socket-3"}}'],
            ['{"command":{"id":"44"},"connector":{"timeOut":10,"type":"TCP"},"module":{"host":"localhost","port":9761,"type":"Socket-3"}}'],
        ];
    }
}
