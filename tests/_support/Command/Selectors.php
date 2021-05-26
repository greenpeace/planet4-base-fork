<?php

namespace Command;

use \Symfony\Component\Console\Command\Command;
use \Codeception\CustomCommandInterface;
use \Selector\Admin\GutenbergEditor;
use \Selector\Admin\GutenbergEditor\BlockSelector;
use Selector\Admin\GutenbergEditor\Sidebar;
use \Symfony\Component\Console\Input\InputInterface;
use \Symfony\Component\Console\Output\OutputInterface;
use \Symfony\Component\Console\Helper\Table;
use \Symfony\Component\Console\Helper\TableCell;
use \Symfony\Component\Console\Helper\TableSeparator;

/**
 * Prints all css/xpath selectors available
 */
class Selectors extends Command implements CustomCommandInterface
{
    /**
     * Selectors classes to list
     *
     * @var string[]
     */
    private $selectorClasses = [
        GutenbergEditor::class,
        Sidebar::class,
    ];

    /**
     * Returns the name of the command
     *
     * @return string
     */
    public static function getCommandName(): string
    {
        return "p4:selectors";
    }

    /**
     * Configures the current command.
     */
    protected function configure(): void
    {
        parent::configure();
    }

    /**
     * Returns the description for the command.
     *
     * @return string The description for the command
     */
    public function getDescription(): string
    {
        return "Listing P4 selectors";
    }

    /**
     * Displays a list of available selectors
     * Highlights variable parts
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $table = new Table($output);
        $table->setHeaders(['Method', 'Selector']);
        //$table->setColumnMaxWidth(1, 70);

        while ($class = current($this->selectorClasses)) {
            $table->addRows([
                [new TableCell(sprintf('<options=bold>%s</>', $class), ['colspan' => 2])],
                new TableSeparator()
            ]);
            $table->addRows(array_map(
                function ($key, $val) use ($class) { return [
                    $this->constToMethod($key, $class),
                    str_replace('%s', '<fg=yellow;options=bold>%s</>', $val)
                ]; } ,
                $class::keys(),
                $class::values()
            ));

            next($this->selectorClasses);
            if (current($this->selectorClasses)) {
                $table->addRows([new TableSeparator()]);
            }
        }
        $table->render();

        return self::SUCCESS;
    }

    /**
     * Qualifies php-enum const as methods, check if they have specific parameters declaration
     *
     * @param string $const Constant name
     * @param string $class Class name
     *
     * @return string
     */
    private function constToMethod(string $const, string $class): string
    {
        try {
            $rfl = new \ReflectionMethod($class, $const);
            $params = implode(', ', array_map(
                function ($param) use ($class) {
                    $ns = (new \ReflectionClass($class))->getNamespaceName();
                    return str_replace($ns . '\\', '', $param->getType())
                        . ' $' . $param->getName();
                },
                $rfl->getParameters()
            ));

            return $const . '(<fg=yellow>' . $params . '</>)';
        } catch (\ReflectionException $e) {
            return $const . '()';
        }
    }
}
