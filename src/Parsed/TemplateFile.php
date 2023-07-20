<?php

namespace PhpTemplates\Parsed;

use PhpTemplates\Source;
use PhpTemplates\Contracts\Cache;
use PhpTemplates\Parsed\View;
use PhpTemplates\ParsingTemplate;

class TemplateFile
{
    protected string $rootPath;
    protected string $name;
    protected string $file;
    protected array $templates = [];

    public function __construct(string $rootPath, string $name)
    {
        $this->rootPath = $rootPath;
        $this->name = $name;
        $this->file = $this->getfile($name);
    }

    public function load(): ?string
    {
        if (!file_exists($this->file)) {
            return null;
        }

        return require($file);
    }

    public function has(string $key): bool
    {
        return isset($this->templates[$key]);
    }

    public function add(string $key, \Closure $template): void
    {
        $this->templates[$key] = $template;
    }

    /**
     * Write ViewFactory class definition in a random namespace and returns the class name to be instantiated
     */
    public function write(): string
    {
        if (!is_dir($this->rootPath)) {
            mkdir($this->rootPath, 0777, true);
        } else {
            chmod($this->rootPath, 0777);
        }
        
        // this gonna call parsed events
        array_walk($this->templates, function(&$t) {
            if (is_callable($t)) {
                $t = $t();
            }
        });

        $nameToClassName = [];
        foreach ($this->templates as $template) {
            $dependencyMap[] = $template->getFile();
            $nameToClassName[$template->getName()] = $template->getClassDefinition()->getFullName();
        }

        $viewClass = 'View_' . uniqid();

        $tpl = "<?php \n";
        
/*        $tpl .= PHP_EOL . "use function PhpTemplates\\check_dependencies;";
        $tpl .= PHP_EOL . "use function PhpTemplates\\e;";
        $tpl .= PHP_EOL . "use function PhpTemplates\\resolve_class;";
        $tpl .= PHP_EOL . "use function PhpTemplates\\e_bind;";
        $tpl .= PHP_EOL . "use function PhpTemplates\\arr_except;";
        $tpl .= PHP_EOL . "use PhpTemplates\\Loop;";
        $tpl .= PHP_EOL . "use PhpTemplates\\Slot;";
        $tpl .= PHP_EOL . "use PhpTemplates\\Parsed\\View;";
        $tpl .= PHP_EOL . "use PhpTemplates\\Cache\\FileSystemCache;";
        //foreach ($this->registry->uses as $use) {
            //$tpl .= PHP_EOL . "use \\$use;";
        //}
        $tpl .= PHP_EOL;*/

        $dependencies = [];
        //foreach ($this->store as $template) {
            //if ($template['file']) {
                //$dependencies[$template['file']] = filemtime($template['file']);
            //}
        //}
        //$tpl .= PHP_EOL . 'if (!check_dependencies(' . var_export($dependencies, true) . ')) { return false; }' . PHP_EOL;


     
        $tpl .= "namespace {\n";
/*        
        $tpl .= "use PhpTemplates\\Parsed\\View as BaseView;\n";
        $tpl .= "use PhpTemplates\\Loop;\n";
        $tpl .= "use PhpTemplates\\Scopes\\LoopScope;\n";
        $tpl .= "use PhpTemplates\\Parsed\\Slot;\n";
        $tpl .= "use PhpTemplates\\Parsed as t;\n";
        $tpl .= "require_once(PHPT_ROOT .'/Parsed/helpers.php');\n\n";
*/        
        $tpl .= "\tclass {$viewClass} extends \\PhpTemplates\\Parsed\\View {\n";
        $tpl .= "\t\tprivate array \$templates = [\n";
        foreach ($nameToClassName as $name => $className) {
            $tpl .= "\t\t\t'$name' => {$className}::class,\n";
        }
        $tpl .= "\t\t];\n\n";
        $tpl .= "\t\tfinal public function make(string \$name, \$data) {\n";
        $tpl .= "\t\t\treturn parent::make(\$this->templates[\$name], \$data);\n";
        $tpl .= "\t\t}\n";
        $tpl .= "\t}\n";
        $tpl .= "}\n\n";     
 
        foreach ($this->templates as $t) {
            $tpl .= $t->getClassDefinition()->extends("\\{$viewClass}") . "\n\n";
        } 
        
        $tpl .= "namespace {\n\treturn {$viewClass}::class;\n}";
        
        file_put_contents($this->file, $tpl);
        
        return require_once($this->file);
    }

    protected function getFile(string $key)
    {
        $pf = rtrim($this->rootPath, '/ ') . '/';
        $hash = substr(base_convert(md5($key), 16, 32), 0, 12);
        $name = trim(str_replace(['/', ':'], '_', $key), '/ ') . '_' . $hash;

        return $pf . $name . '.php';
    }
}
