<?php

declare(strict_types=1);

namespace App\Factory\CleanRobotCommand;

use App\Dto\CleanRobotDto;
use App\Enum\DirectionEnum;
use App\Enum\OutputEnum;
use App\Exception\NonCleanableSpaceException;
use InvalidArgumentException;

class BackCommand extends AbstractCommand
{
    private const STEP = 1;

    private const UNIT_OF_DISCHARGE = 3;

    /**
     * @param CleanRobotDto $cleanRobotDto
     *
     * @return int
     *
     * @throws NonCleanableSpaceException
     */
    public function execute(CleanRobotDto $cleanRobotDto): int
    {
        $axisX = $cleanRobotDto->getAxisX();
        $axisY = $cleanRobotDto->getAxisY();

        switch ($cleanRobotDto->getDirection()) {
            case DirectionEnum::NORTH:
                $axisY = $axisY + self::STEP;
                break;
            case DirectionEnum::WEST:
                $axisX = $axisX + self::STEP;
                break;
            case DirectionEnum::SOUTH:
                $axisY = $axisY - self::STEP;
                break;
            case DirectionEnum::EAST:
                $axisX = $axisX - self::STEP;
                break;
            default:
                throw new InvalidArgumentException();
        };

        if ($axisX < 0) {
            throw new NonCleanableSpaceException();
        }

        if ($axisY < 0) {
            throw new NonCleanableSpaceException();
        }

        $this->checkPointInMap($cleanRobotDto);

        $cleanRobotDto->setAxisX($axisX);
        $cleanRobotDto->setAxisY($axisY);

        $this->getOutputService()->addPosition($axisX, $axisY, OutputEnum::VISITED);

        return $this->getUnitOfDischarge();
    }

    public function getUnitOfDischarge(): int
    {
        return self::UNIT_OF_DISCHARGE;
    }
}
