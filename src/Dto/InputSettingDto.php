<?php

declare(strict_types=1);

namespace App\Dto;

class InputSettingDto
{
    private array $map;

    private PositionDto $start;

    private array $commands;

    private int $battery;

    /**
     * @return array
     */
    public function getMap(): array
    {
        return $this->map;
    }

    /**
     * @param array $map
     */
    public function setMap(array $map): void
    {
        $this->map = $map;
    }

    /**
     * @return PositionDto
     */
    public function getStart(): PositionDto
    {
        return $this->start;
    }

    /**
     * @param PositionDto $start
     */
    public function setStart(PositionDto $start): void
    {
        $this->start = $start;
    }

    /**
     * @return array
     */
    public function getCommands(): array
    {
        return $this->commands;
    }

    /**
     * @param array $commands
     */
    public function setCommands(array $commands): void
    {
        $this->commands = $commands;
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
