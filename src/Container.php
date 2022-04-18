<?php
declare(strict_types=1);

namespace App;

use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    /**
     * @param array<string,object> $instances
     */
    public function __construct(private readonly array $instances)
    {
    }
    
    public function get(string $id)
    {
        return $this->instances[$id] ?? null;
    }

    public function has(string $id): bool
    {
        return isset($this->instances[$id]);
    }
}
