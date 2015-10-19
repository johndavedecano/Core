<?php
namespace Jdecano\Core\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MakeRepository extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'make:repository';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description.';
    /**
     * @var string
     */
    private $path;

    /**
     *
     */
	public function __construct()
	{
		parent::__construct();
        $this->path = base_path('app/Repositories');
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        $name = $this->argument('model');
        $model = ucwords(camel_case($name));
        if (class_exists("\\App\\Models\\".$model)) {
            $this->create_repository($model);
            $this->create_repository_interface($model);
            echo $model.'Repository has been successfully created.'.PHP_EOL;
            exec("composer dump-autoload");
            $this->append_to_registry($model);
        } else {
            echo "Model does not exists.".PHP_EOL;
        }
	}
    /**
     * @param $model string
     */
    private function append_to_registry($model) {
        $path = base_path('app/Providers/AppServiceProvider.php');
        $appends = file_get_contents(__DIR__.'/../Views/repository_provider.tpl');
        $appends = str_replace("MODEL", $model, $appends);
        $appends = "register() { \n \t \t".$appends;
        $contents = file_get_contents($path);
        $contents = str_replace("register() {", $appends, $contents);
        \File::put($path, $contents);
    }
    /**
     * @param $model string
     */
    private function create_repository($model) {
        $template = file_get_contents(__DIR__.'/../Views/repository.tpl');
        $contents = str_replace("MODEL", $model, $template);
        $path = $this->path.'/'.$model.'Repository.php';
        \File::put($path, $contents);
    }
    private function create_repository_interface($model) {
        $template = file_get_contents(__DIR__.'/../Views/repository_interface.tpl');
        $contents = str_replace("MODEL", $model, $template);
        $path = $this->path.'/Contracts/'.$model.'RepositoryInterface.php';
        \File::put($path, $contents);
    }
	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('model', InputArgument::REQUIRED, 'Eloquent model.'),
		);
	}
}
