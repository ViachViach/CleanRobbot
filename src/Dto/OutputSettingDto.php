<?php

declare(strict_types=1);

namespace App\Dto;

class OutputSettingDto
{
    /**
     * @var PositionDto[]
    */
    private array $visited = [];

    /**
     * @var PositionDto[]
     */
    private array $cleaned = [];

    /**
     * @var PositionDto
     */
    private PositionDto $final;

    private int $battery;

    /**
     * @return PositionDto[]
     */
    public function getVisited(): array
    {
        return $this->visited;
    }

    /**
     * @param PositionDto[] $visited
     */
    public function setVisited(array $visited): void
    {
        $this->visited = $visited;
    }

    /**
     * @param PositionDto $positionDto
     */
    public function addVisited(PositionDto $positionDto): void
    {
        $this->visited[] = $positionDto;
    }

    /**
     * @return PositionDto[]
     */
    public function getCleaned(): array
    {
        return $this->cleaned;
    }

    /**
     * @param PositionDto[] $cleaned
     */
    public function setCleaned(array $cleaned): void
    {
        $this->cleaned = $cleaned;
    }

    /**
     * @param PositionDto $positionDto
     */
    public function addCleaned(PositionDto $positionDto): void
    {
        $this->cleaned[] = $positionDto;
    }

    /**
     * @return PositionDto
     */
    public function getFinal(): PositionDto
    {
        return $this->final;
    }

    /**
     * @param PositionDto $positionDto
     */
    public function setFinal(PositionDto $positionDto)
    {
        $this->final = $positionDto;
    }

    /**
     * @return int
     */
    public function getBattery(): int
    {
        return $this->battery;
    }

    /**
     * @param int $battery
     */
    public function setBattery(int $battery): void
    {
        $this->battery = $battery;
    }
}
