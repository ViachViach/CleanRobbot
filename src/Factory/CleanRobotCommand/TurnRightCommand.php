<?php

declare(strict_types=1);

namespace App\Factory\CleanRobotCommand;

use App\Dto\CleanRobotDto;
use App\Enum\DirectionEnum;
use InvalidArgumentException;

class TurnRightCommand extends AbstractCommand
{
    private const UNIT_OF_DISCHARGE = 1;

    /**
     * @param CleanRobotDto $cleanRobotDto
     *
     * @return int
     */
    public function execute(CleanRobotDto $cleanRobotDto): int
    {
        switch ($cleanRobotDto->getDirection()) {
            case DirectionEnum::NORTH:
                $cleanRobotDto->setDirection(DirectionEnum::EAST);
                break;
            case DirectionEnum::EAST:
                $cleanRobotDto->setDirection(DirectionEnum::SOUTH);
                break;
            case DirectionEnum::SOUTH:
                $cleanRobotDto->setDirection(DirectionEnum::WEST);
                break;
            case DirectionEnum::WEST:
                $cleanRobotDto->setDirection(DirectionEnum::NORTH);
                break;

            default:
                throw new InvalidArgumentException();
        };

        return $this->getUnitOfDischarge();
    }

    public function getUnitOfDischarge(): int
    {
        return self::UNIT_OF_DISCHARGE;
    }
}
