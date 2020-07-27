<?php

declare(strict_types=1);

namespace App\Factory\CleanRobotCommand;

use App\Dto\CleanRobotDto;
use App\Dto\OutputSettingDto;
use App\Enum\CommandEnum;
use App\Services\BatteryService;
use App\Services\OutputService;
use InvalidArgumentException;
use App\Exception\BatteryDischargedException;

class CommandFactory
{
    private BatteryService $batteryService;

    private OutputService $outputService;

    /**
     * CommandFactory constructor.
     *
     * @param BatteryService $batteryService
     */
    public function __construct(BatteryService $batteryService, OutputService $outputService)
    {
        $this->batteryService = $batteryService;
        $this->outputService = $outputService;
    }


    /**
     * @param CleanRobotDto $cleanRobot
     * @param string        $command
     *
     * @throws BatteryDischargedException
     */
    public function execute(CleanRobotDto $cleanRobot, string $command): void
    {
        $command = $this->createCommand($command);
        $command->setOutputService($this->outputService);
        $unitOfDischarge = $command->execute($cleanRobot);
        $this->batteryService->chargeBattery($cleanRobot, $unitOfDischarge);
    }

    public function getOutputSetting(): OutputSettingDto
    {
        return $this->outputService->getOutputSetting();
    }

    /**
     * @param string $command
     *
     * @return AbstractCommand
     */
    private function createCommand(string $command): AbstractCommand
    {
        $commandName = CommandEnum::MAP[$command];
        if (!class_exists($commandName)) {
            throw new InvalidArgumentException("Class $commandName does not exist");
        }

        return new $commandName;
    }
}
