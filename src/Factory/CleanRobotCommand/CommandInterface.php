<?php

declare(strict_types=1);

namespace App\Factory\CleanRobotCommand;

use App\Dto\CleanRobotDto;

interface CommandInterface
{
    /**
     * @param CleanRobotDto $cleanRobotDto
     *
     * @return int
     */
    public function execute(CleanRobotDto $cleanRobotDto): int;

    public function getUnitOfDischarge(): int;
}
