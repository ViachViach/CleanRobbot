<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\CleanRobotDto;
use App\Exception\BatteryDischargedException;

class BatteryService
{
    /**
     * @param CleanRobotDto $cleanRobot
     * @param int $unit
     *
     * @throws  BatteryDischargedException
     */
    public function chargeBattery(CleanRobotDto $cleanRobot, int $unit): void
    {
        $unit = $cleanRobot->getChargingOfBattery() - $unit;

        if ($unit <= 0) {
            throw new BatteryDischargedException('Battery discharged');
        }

        $cleanRobot->setChargingOfBattery($unit);
    }
}
