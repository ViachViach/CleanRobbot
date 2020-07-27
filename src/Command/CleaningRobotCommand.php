<?php

declare(strict_types=1);

namespace App\Command;

use App\Dto\CleanRobotDto;
use App\Dto\InputSettingDto;
use App\Dto\PositionDto;
use App\Services\CleanRobotService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use App\Exception\RobotStuckException;
use App\Exception\BatteryDischargedException;

class CleaningRobotCommand extends Command
{
    private CleanRobotService $cleanRobotService;

    private SerializerInterface $serializer;

    /**
     * CleaningRobotCommand constructor.
     *
     * @param CleanRobotService   $cleanRobotService
     * @param SerializerInterface $serializer
     */
    public function __construct(CleanRobotService $cleanRobotService, SerializerInterface $serializer)
    {
        $this->cleanRobotService = $cleanRobotService;
        $this->serializer = $serializer;
        parent::__construct(null);
    }

    protected function configure(): void
    {
        $this
            ->setName('cleaning:robot')
            ->addArgument('source', InputArgument::OPTIONAL, 'Path to input json file')
            ->addArgument('result', InputArgument::OPTIONAL, 'Path to output json file')
        ;
    }


    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     * @throws RobotStuckException
     * @throws BatteryDischargedException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $pathInputFile = $input->getArgument('source');
        $pathOutputFile = $input->getArgument('result');

        if ($pathInputFile === null) {
            $pathInputFile = __DIR__ . '/../../source.json';
        }

        if ($pathOutputFile === null) {
            $pathOutputFile = __DIR__ .'/../../result.json';
        }

        $jsonParams = file_get_contents($pathInputFile);

        /**
         * @var InputSettingDto $inputSetting
        */
        $inputSetting = $this->serializer->deserialize(
            $jsonParams,
            InputSettingDto::class,
            JsonEncoder::FORMAT
        );

        $cleanRobotDto = $this->createDto($inputSetting);
        $outputSetting = $this->cleanRobotService->handle($cleanRobotDto);

        $finalPosition = new PositionDto();
        $finalPosition->setY($cleanRobotDto->getAxisY());
        $finalPosition->setX($cleanRobotDto->getAxisX());
        $finalPosition->setFacing($cleanRobotDto->getDirection());

        $outputSetting->setFinal($finalPosition);
        $outputSetting->setBattery($cleanRobotDto->getChargingOfBattery());

        $outputResult = $this->serializer->serialize(
            $outputSetting,
            JsonEncoder::FORMAT,
            [AbstractObjectNormalizer::SKIP_NULL_VALUES => true]
        );

        $output->writeln($outputResult);

        file_put_contents($pathOutputFile, $outputResult);

        return Command::SUCCESS;
    }

    /**
     * @param InputSettingDto $inputSetting
     *
     * @return CleanRobotDto
     */
    private function createDto(InputSettingDto $inputSetting): CleanRobotDto
    {
        $cleanRobotDto = new CleanRobotDto();
        $cleanRobotDto->setAxisY($inputSetting->getStart()->getY());
        $cleanRobotDto->setAxisX($inputSetting->getStart()->getX());
        $cleanRobotDto->setDirection($inputSetting->getStart()->getFacing());
        $cleanRobotDto->setChargingOfBattery($inputSetting->getBattery());
        $cleanRobotDto->setMap($inputSetting->getMap());
        $cleanRobotDto->setCommand($inputSetting->getCommands());

        return $cleanRobotDto;
    }
}
