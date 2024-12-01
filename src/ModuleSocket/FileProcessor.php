<?php declare(strict_types=1);

namespace Autodoctor\ModuleSocket;

use Autodoctor\ModuleSocket\Exceptions\ModuleException;

class FileProcessor
{
    /**
     * @throws ModuleException
     */
    public static function getContent(string $fileName): string
    {
        $data = file_get_contents($fileName);

        if ($data === false) {
            throw new ModuleException(sprintf('Error reading file: %s.', $fileName));
        }
        return $data;
    }

    /**
     * @throws ModuleException
     */
    public static function putContent(string $fileName, mixed $data, int $flag = 0): int
    {
        $result = file_put_contents($fileName, $data, $flag);

        if ($result === false) {
            throw new ModuleException(sprintf('Error writing to file: %s.', $fileName));
        }
        return $result;
    }
}
