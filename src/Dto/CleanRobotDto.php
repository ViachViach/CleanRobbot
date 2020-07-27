<?php

declare(strict_types=1);

namespace App\Dto;

class CleanRobotDto
{
    private int $axisX;

    private int $axisY;

    private string $direction;

    private int $chargingOfBattery;

    /**
     * @var string[]
     */
    private array $command;

    /**
     * @var int[][]
    */
    private array $map;

    /**
     * @return int
     */
    public function getAxisX(): int
    {
        return $this->axisX;
    }

    /**
     * @param int $axisX
     */
    public function setAxisX(int $axisX): void
    {
        $this->axisX = $axisX;
    }

    /**
     * @return int
     */
    public function getAxisY(): int
    {
        return $this->axisY;
    }

    /**
     * @param int $axisY
     */
    public function setAxisY(int $axisY): void
    {
        $this->axisY = $axisY;
    }

    /**
     * @return string
     */
    public function getDirection(): string
    {
        return $this->direction;
    }

    /**
     * @param string $direction
     */
    public function setDirection(string $direction): void
    {
        $this->direction = $direction;
    }

    /**
     * @return int
     */
    public function getChargingOfBattery(): int
    {
        return $this->chargingOfBattery;
    }

    /**
     * @param int $chargingOfBattery
     */
    public function setChargingOfBattery(int $chargingOfBattery): void
    {
        $this->chargingOfBattery = $chargingOfBattery;
    }

    /**
     * @return string[]
     */
    public function getCommand(): array
    {
        return $this->command;
    }

    /**
     * @param string[] $command
     */
    public function setCommand(array $command): void
    {
        $this->command = $command;
    }

    /**
     * @return int[][]
     */
    public function getMap(): array
    {
        return $this->map;
    }

    /**
     * @param int[][] $map
     */
    public function setMap(array $map): void
    {
        $this->map = $map;
    }
}
