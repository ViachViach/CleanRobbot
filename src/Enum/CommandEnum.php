<?php

declare(strict_types=1);

namespace App\Enum;

use App\Factory\CleanRobotCommand\AdvanceCommand;
use App\Factory\CleanRobotCommand\BackCommand;
use App\Factory\CleanRobotCommand\CleanCommand;
use App\Factory\CleanRobotCommand\TurnLeftCommand;
use App\Factory\CleanRobotCommand\TurnRightCommand;

class CommandEnum
{
    public const TURN_LEFT = 'TL';

    public const TURN_RIGHT = 'TR';

    public const ADVANCE = 'A';

    public const BACK = 'B';

    public const CLEAN = 'C';

    public const MAP = [
        self::TURN_LEFT => TurnLeftCommand::class,
        self::TURN_RIGHT => TurnRightCommand::class,
        self::ADVANCE => AdvanceCommand::class,
        self::BACK => BackCommand::class,
        self::CLEAN => CleanCommand::class,
    ];

    public const STEP_BACK_STRATEGY = [
        [self::TURN_RIGHT, self::ADVANCE, self::TURN_LEFT],
        [self::TURN_RIGHT, self::ADVANCE, self::TURN_RIGHT],
        [self::TURN_RIGHT, self::ADVANCE, self::TURN_RIGHT],
        [self::TURN_RIGHT, self::BACK, self::TURN_RIGHT, self::ADVANCE],
        [self::TURN_LEFT, self::TURN_LEFT, self::ADVANCE],
    ];
}
