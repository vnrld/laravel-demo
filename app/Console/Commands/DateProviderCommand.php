<?php
declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command as BaseCommand;
use Psr\Log\LoggerInterface;

/**
 * Class DateProviderCommand
 * @package App\Console\Commands
 */
class DateProviderCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'date:provider {init} {--out}';

    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * DateProviderCommand constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        parent::__construct();
        $this->logger = $logger;
    }

    /**
     * The console command description.
     *
     * @var string|null
     */
    protected $description = 'Provides the current time to the logs ';

    /**
     *
     */
    public function handle(): void
    {
        if ($this->argument('init') !== 'init') {
            $this->error($this->getHelp());
            exit(1);
        }

        $currentDatetime = new \DateTime('now');

        $data = [
            'DATE_ISO8601' => $currentDatetime->format(DATE_ISO8601),
            'DATE_RFC3339_EXTENDED' => $currentDatetime->format(DATE_RFC3339_EXTENDED)
        ];

        $json = json_encode($data);

        if ($this->option('out') === true) {
            $this->info($json);
        } else {
            $this->logger->info($json, [__METHOD__]);
        }
    }

    /**
     * @return string
     */
    public function getHelp(): string
    {
        $help = 'Usage: ' . str_replace(['{', '}'], '', $this->signature) . PHP_EOL . PHP_EOL;
        $help .= 'The start argument has to be "init". "' . $this->argument('init') . '" given!';
        return $help;
    }
}
