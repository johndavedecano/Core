<?php
namespace Jdecano\Core\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MakeService extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'make:service';
    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $domain;

    /**
     * @var string
     */
    private $service_path;
	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description.';
	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
        $this->path = base_path('app/Services');
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        $this->domain = ucwords(camel_case($this->argument('domain')));
        $this->service_path = $this->check_domain($this->domain);
        return $this->start_generation(
            ucfirst(camel_case($this->argument('service')))
        );
	}
    private function start_generation($service) {
        try {
            $this->create_class($service);
            $this->create_inteface($service);
            exec("composer dump-autoload");
            $this->create_provider($service);
            echo "Service has been created $service".PHP_EOL;
        } catch(\Exception $e) {
            return false;
        }
    }

    private function create_class($service) {

        $contents = file_get_contents(__DIR__.'/../Views/service.tpl');
        $contents = str_replace("SERVICE", $service, $contents);
        $contents = str_replace("DOMAIN", $this->domain, $contents);

        \File::put($this->service_path.'/'.$service.'.php', $contents);
    }

    private function create_inteface($service) {

        $contents = file_get_contents(__DIR__.'/../Views/service_interface.tpl');
        $contents = str_replace("SERVICE", $service, $contents);
        $contents = str_replace("DOMAIN", $this->domain, $contents);

        \File::put($this->service_path.'/Contracts/'.$service.'Interface.php', $contents);
    }

    private function create_provider($service) {
        $path = base_path('app/Providers/AppServiceProvider.php');
        $appends = file_get_contents(__DIR__.'/../Views/service_provider.tpl');
        $appends = str_replace("SERVICE", $service, $appends);
        $appends = str_replace("DOMAIN", $this->domain, $appends);
        $appends = "register() { \n \t \t".$appends;
        $contents = file_get_contents($path);
        $contents = str_replace("register() {", $appends, $contents);
        \File::put($path, $contents);
    }
    /**
     * @param $domain
     * @return string
     */
    private function check_domain($domain) {

        $path = $this->path.'/'.$domain;

        if (!file_exists($path)) {
            mkdir($path);
        }

        if (!file_exists($path.'/Contracts')) {
            mkdir($path.'/Contracts');
        }
        return $path;
    }
	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
            array('domain', InputArgument::REQUIRED, 'An example argument.'),
			array('service', InputArgument::REQUIRED, 'An example argument.')
		);
	}
}
