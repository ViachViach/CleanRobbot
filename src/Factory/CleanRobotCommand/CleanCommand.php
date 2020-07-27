<?php

declare(strict_types=1);

namespace App\Factory\CleanRobotCommand;

use App\Dto\CleanRobotDto;
use App\Enum\OutputEnum;

class CleanCommand extends AbstractCommand
{
    private const UNIT_OF_DISCHARGE = 5;

    /**
     * @param CleanRobotDto $cleanRobotDto
     *
     * @return int
     */
    public function execute(CleanRobotDto $cleanRobotDto): int
    {
        $this->getOutputService()->addPosition(
            $cleanRobotDto->getAxisX(),
            $cleanRobotDto->getAxisY(),
            OutputEnum::CLEANED
        );

        return $this->getUnitOfDischarge();
    }

    public function getUnitOfDischarge(): int
    {
        return self::UNIT_OF_DISCHARGE;
    }
}
