<?php


namespace Lancelot\Log\Application\Clean;

use Shared\Domain\Bus\CommandInterface;
use Shared\Infrastructure\Application\ApplicationCommand;

#[ApplicationCommand(name: "CLEAN_LOGS")]
class CleanLogsCommand implements CommandInterface
{

}
