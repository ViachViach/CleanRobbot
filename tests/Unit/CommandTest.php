<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Dto\CleanRobotDto;
use App\Exception\BatteryDischargedException;
use App\Exception\NonCleanableSpaceException;
use App\Factory\CleanRobotCommand\AdvanceCommand;
use App\Factory\CleanRobotCommand\TurnLeftCommand;
use App\Factory\CleanRobotCommand\TurnRightCommand;
use App\Services\CleanRobotService;
use Error;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CommandTest extends KernelTestCase
{
    private CleanRobotDto $cleanRobot;

    private TurnRightCommand $turnRightCommand;

    private TurnLeftCommand $turnLeftCommand;

    private AdvanceCommand $advanceCommand;

    protected function setUp(): void
    {
        $command = [ "TL","A","C","A","C","TR","A","C"];
        $map = [
            ["S", "S", "S", "S"],
            ["S", "S", "C", "S"],
            ["S", "S", "S", "S"],
            ["S", null, "S", "S"]
        ];

        $this->cleanRobot = new CleanRobotDto();
        $this->cleanRobot->setChargingOfBattery(80);
        $this->cleanRobot->setAxisX(3);
        $this->cleanRobot->setAxisY(0);
        $this->cleanRobot->setCommand($command);
        $this->cleanRobot->setMap($map);
        $this->cleanRobot->setDirection('N');

        $this->turnLeftCommand = new TurnLeftCommand();
        $this->turnRightCommand = new TurnRightCommand();
        $this->advanceCommand = new AdvanceCommand();
    }

    public function testTurnLeft()
    {
        $this->turnLeftCommand->execute($this->cleanRobot);
        $this->assertEquals($this->cleanRobot->getDirection(), 'W');
        $this->turnLeftCommand->execute($this->cleanRobot);
        $this->assertEquals($this->cleanRobot->getDirection(), 'S');
        $this->turnLeftCommand->execute($this->cleanRobot);
        $this->assertEquals($this->cleanRobot->getDirection(), 'E');
        $this->turnLeftCommand->execute($this->cleanRobot);
        $this->assertEquals($this->cleanRobot->getDirection(), 'N');
    }

    public function testTurnRight()
    {
        $this->turnRightCommand->execute($this->cleanRobot);
        $this->assertEquals($this->cleanRobot->getDirection(), 'E');
        $this->turnRightCommand->execute($this->cleanRobot);
        $this->assertEquals($this->cleanRobot->getDirection(), 'S');
        $this->turnRightCommand->execute($this->cleanRobot);
        $this->assertEquals($this->cleanRobot->getDirection(), 'W');
        $this->turnRightCommand->execute($this->cleanRobot);
        $this->assertEquals($this->cleanRobot->getDirection(), 'N');
    }

    public function testWithoutStartPoint()
    {
        $this->expectException(NonCleanableSpaceException::class);
        $this->advanceCommand->execute($this->cleanRobot);
    }

    public function testWithoutStartParams()
    {
        $command = [ "TL","A","C","A","C","TR","A","C"];
        $map = [
            ["S", "S", "S", "S"],
            ["S", "S", "C", "S"],
            ["S", "S", "S", "S"],
            ["S", null, "S", "S"]
        ];

        $this->cleanRobot = new CleanRobotDto();
        $this->cleanRobot->setChargingOfBattery(80);
        $this->cleanRobot->setCommand($command);
        $this->cleanRobot->setMap($map);
        $this->cleanRobot->setDirection('N');

        self::bootKernel();
        /**
         * @var CleanRobotService $cleanRobotService
        */
        $cleanRobotService = static::$kernel->getContainer()->get(CleanRobotService::class);
        $this->expectException(Error::class);
        $cleanRobotService->handle($this->cleanRobot);
    }

    public function testWrongStartParams()
    {
        $command = [ "TL","A","C","A","C","TR","A","C"];
        $map = [
            ["S", "S", "S", "S"],
            ["S", "S", "C", "S"],
            ["S", "S", "S", "S"],
            ["S", null, "S", "S"]
        ];

        $this->cleanRobot = new CleanRobotDto();
        $this->cleanRobot->setChargingOfBattery(80);
        $this->cleanRobot->setCommand($command);
        $this->cleanRobot->setMap($map);
        $this->cleanRobot->setAxisX(30);
        $this->cleanRobot->setAxisY(100);
        $this->cleanRobot->setDirection('N');

        self::bootKernel();
        /**
         * @var CleanRobotService $cleanRobotService
         */
        $cleanRobotService = static::$kernel->getContainer()->get(CleanRobotService::class);
        $this->expectExceptionMessage(
            "X: {$this->cleanRobot->getAxisX()} and Y {$this->cleanRobot->getAxisY()} does not contain in map"
        );
        $cleanRobotService->handle($this->cleanRobot);
    }

    public function testRobotStuck()
    {
        $command = [ "TL","A","C","A","C","TR","A","C"];
        $map = [
            ["C", "C", "S", "C"],
            ["C", "C", "C", "C"],
            ["C", "C", "C", "C"],
            ["S", null, "S", "S"]
        ];

        $this->cleanRobot = new CleanRobotDto();
        $this->cleanRobot->setChargingOfBattery(80);
        $this->cleanRobot->setCommand($command);
        $this->cleanRobot->setMap($map);
        $this->cleanRobot->setAxisX(3);
        $this->cleanRobot->setAxisY(0);
        $this->cleanRobot->setDirection('N');

        self::bootKernel();
        /**
         * @var CleanRobotService $cleanRobotService
         */
        $cleanRobotService = static::$kernel->getContainer()->get(CleanRobotService::class);
        $this->expectExceptionMessage('Robot stuck');
        $cleanRobotService->handle($this->cleanRobot);
    }

    public function testBatteryIsLow()
    {
        $command = [ "TL","A","C","A","C","TR","A","C"];
        $map = [
            ["S", "S", "S", "S"],
            ["S", "S", "C", "S"],
            ["S", "S", "S", "S"],
            ["S", null, "S", "S"]
        ];

        $this->cleanRobot = new CleanRobotDto();
        $this->cleanRobot->setChargingOfBattery(0);
        $this->cleanRobot->setAxisX(3);
        $this->cleanRobot->setAxisY(0);
        $this->cleanRobot->setCommand($command);
        $this->cleanRobot->setMap($map);
        $this->cleanRobot->setDirection('N');

        self::bootKernel();
        /**
         * @var CleanRobotService $cleanRobotService
         */
        $cleanRobotService = static::$kernel->getContainer()->get(CleanRobotService::class);
        $this->expectException(BatteryDischargedException::class);
        $cleanRobotService->handle($this->cleanRobot);
    }
}
