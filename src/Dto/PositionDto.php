<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Serializer\Annotation\SerializedName;

class PositionDto
{
    /**
     * @SerializedName("X")
     */
    private int $x;

    /**
     * @SerializedName("Y")
     */
    private int $y;

    private ?string $facing = null;

    /**
     * @return int
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * @param int $x
     */
    public function setX(int $x): void
    {
        $this->x = $x;
    }

    /**
     * @return int
     */
    public function getY(): int
    {
        return $this->y;
    }

    /**
     * @param int $y
     */
    public function setY(int $y): void
    {
        $this->y = $y;
    }

    /**
     * @return string|null
     */
    public function getFacing(): ?string
    {
        return $this->facing;
    }

    /**
     * @param string $facing
     */
    public function setFacing(string $facing): void
    {
        $this->facing = $facing;
    }
}
