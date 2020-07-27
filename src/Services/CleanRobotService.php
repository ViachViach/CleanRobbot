<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\CleanRobotDto;
use App\Dto\OutputSettingDto;
use App\Enum\CommandEnum;
use App\Exception\NonCleanableSpaceException;
use App\Exception\RobotStuckException;
use App\Factory\CleanRobotCommand\CommandFactory;
use App\Exception\BatteryDischargedException;

class CleanRobotService
{
    private BatteryService $batteryService;

    private CommandFactory $commandFactory;

    /**
     * CleanRobotService constructor.
     *
     * @param BatteryService $batteryService
     * @param CommandFactory $commandFactory
     */
    public function __construct(BatteryService $batteryService, CommandFactory $commandFactory)
    {
        $this->batteryService = $batteryService;
        $this->commandFactory = $commandFactory;
    }


    /**
     * @param CleanRobotDto $cleanRobot
     *
     * @return OutputSettingDto
     *
     * @throws RobotStuckException
     * @throws BatteryDischargedException
     */
    public function handle(CleanRobotDto $cleanRobot): OutputSettingDto
    {
        foreach ($cleanRobot->getCommand() as $command) {
            try {
                $this->commandFactory->execute($cleanRobot, $command);
            } catch (NonCleanableSpaceException $e) {
                $this->processingStepBackStrategy($cleanRobot);
            }
        }

        return $this->commandFactory->getOutputSetting();
    }

    /**
     * @param CleanRobotDto $cleanRobot
     *
     * @throws RobotStuckException
     * @throws BatteryDischargedException
     */
    private function processingStepBackStrategy(CleanRobotDto $cleanRobot): void
    {
        $commandStrategy = CommandEnum::STEP_BACK_STRATEGY;

        foreach ($commandStrategy as $strategy) {
            try {
                foreach ($strategy as $command) {
                    $this->commandFactory->execute($cleanRobot, $command);
                }
                return;
            } catch (NonCleanableSpaceException $e) {
                continue;
            }
        }

        throw new RobotStuckException('Robot stuck');
    }
}
