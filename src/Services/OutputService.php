<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\OutputSettingDto;
use App\Dto\PositionDto;
use App\Enum\OutputEnum;
use InvalidArgumentException;

class OutputService
{
    private OutputSettingDto $outputSetting;

    public function __construct()
    {
        $this->outputSetting = new OutputSettingDto();
    }


    /**
     * @param int $axisX
     * @param int $axisY
     * @param int $command
     */
    public function addPosition(int $axisX, int $axisY, int $command): void
    {
        $position = new PositionDto();
        $position->setX($axisX);
        $position->setY($axisY);

        switch ($command) {
            case OutputEnum::VISITED:
                if ($this->checkPresentPosition($position, $this->outputSetting->getVisited())) {
                    $this->outputSetting->addVisited($position);
                }
                break;
            case OutputEnum::CLEANED:
                if ($this->checkPresentPosition($position, $this->outputSetting->getCleaned())) {
                    $this->outputSetting->addCleaned($position);
                }
                break;
            default:
                throw new InvalidArgumentException("Output Argument $command does not exist");
        }
    }

    public function getOutputSetting(): OutputSettingDto
    {
        return $this->outputSetting;
    }

    /**
     * @param PositionDto   $position
     * @param PositionDto[] $visitPositions
     *
     * @return bool
     */
    private function checkPresentPosition(PositionDto $position, array $visitPositions): bool
    {
        foreach ($visitPositions as $visitPosition) {
            if ($position == $visitPosition) {
                return false;
            }
        }

        return true;
    }
}
