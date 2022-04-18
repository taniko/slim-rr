<?php
declare(strict_types=1);

namespace App\Domain\Model;

class User
{
    /**
     * @param string $id
     * @param string $name
     */
    public function __construct(private readonly string $id, private readonly string $name)
    {
    }

    /**
     * @return string
     */
    public function getID(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}