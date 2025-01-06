<?php declare(strict_types = 1);

namespace LDTech\Scheduler\DI;

use Nette\DI\CompilerExtension;
use Nette\DI\Definitions\Statement;
use Nette\PhpGenerator\ClassType;
use Nette\Schema\Expect;
use Nette\Schema\Schema;
use stdClass;
use Tracy\Bar;
use LDTech\Messenger\Providers\ServiceProvider;
use Symfony\Component\Scheduler\Command;
/**
 * @method stdClass getConfig()
 */
class SchedulerExtension extends CompilerExtension
{

	public function getConfigSchema(): Schema
	{
		return Expect::structure([
			'debug' => Expect::bool(false),
			'loggers' => Expect::arrayOf(Expect::type(Statement::class)),
		]);
		
	}

	public function loadConfiguration(): void
	{
		$builder = $this->getContainerBuilder();
		$config = $this->getConfig();

		$serviceProvider = $builder->getDefinitionByType('LDTech\Messenger\Providers\ServiceProvider');
		
		$builder->addDefinition($this->prefix('command.DebugCommand'))
		->setFactory(Command\DebugCommand::class, [$serviceProvider])
		->setAutowired(false);

	}

	public function beforeCompile(): void 
	{

	}

	public function afterCompile(ClassType $class): void
	{

	}

}
