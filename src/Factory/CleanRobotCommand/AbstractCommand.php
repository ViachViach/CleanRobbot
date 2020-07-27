<?php

declare(strict_types=1);

namespace App\Factory\CleanRobotCommand;

use App\Dto\CleanRobotDto;
use App\Enum\MapPointEnum;
use App\Exception\NonCleanableSpaceException;
use App\Services\OutputService;
use InvalidArgumentException;

abstract class AbstractCommand implements CommandInterface
{
    private OutputService $outputService;

    /**
     * @return OutputService
     */
    public function getOutputService(): OutputService
    {
        return $this->outputService;
    }

    /**
     * @param OutputService $outputService
     */
    public function setOutputService(OutputService $outputService): void
    {
        $this->outputService = $outputService;
    }

    /**
     * @param CleanRobotDto $cleanRobotDto
     *
     * @throws NonCleanableSpaceException
     */
    protected function checkPointInMap(CleanRobotDto $cleanRobotDto): void
    {
        $map = $cleanRobotDto->getMap();

        if (!isset($map[$cleanRobotDto->getAxisX()][$cleanRobotDto->getAxisY()]))
        {
            throw new InvalidArgumentException(
                "X: {$cleanRobotDto->getAxisX()} and Y {$cleanRobotDto->getAxisY()} does not contain in map"
            );
        }

        $point = $map[$cleanRobotDto->getAxisX()][$cleanRobotDto->getAxisY()];

        if ($point !== MapPointEnum::CLEANABLE_SPACE) {
            throw new NonCleanableSpaceException();
        }
    }
}
