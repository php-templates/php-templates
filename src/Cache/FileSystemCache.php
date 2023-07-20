<?php

namespace PhpTemplates\Cache;

use PhpTemplates\Source;
use PhpTemplates\Contracts\Cache;
use PhpTemplates\Parsed\View;
use PhpTemplates\ParsedTemplate;

class FileSystemCache implements Cache
{
    protected $storePath;
    protected $store = [];
    protected $source = [];

    public function __construct(string $storePath)
    {
        $this->storePath = $storePath;
    }

    public function get(string $key): ?string
    {
        $this->store = $this->source = $this->dependencies = [];

        $file = $this->getFilePath($key);

        if (!file_exists($file)) {
            return null;
        }

        return require($file);
    }

    public function yyyhadhs(string $key): ?array
    {
        return $this->store[$key] ?? null;
    }

    public function yyyset(string $key, \Closure $fn = null): void
    {
        $this->store[$key] = $fn;
    }

    /**
     * Write ViewFactory class definition in a random namespace and returns the class name to be instantiated
     */
    public function remember(ParsedTemplate $template): string
    {
        $path = $this->getFilePath($template->getName());

        if (!is_dir($this->storePath)) {
            mkdir($this->storePath, 0777, true);
        } else {
            chmod($this->storePath, 0777);
        }

        $next = $template;
        $uses = [];
        $nameToClassName = [];
        do {
            $uses = array_merge($uses, $next->getUseStmts());
            $dependencyMap[] = $next->getFile();
            $nameToClassName[$next->getName()] = $next->getClassDefinition()->getName();
            $classDefinitions[] = $next->getClassDefinition()->toString();
        } while ($next = $next->next());

        $namespace = 'PHPT_' . uniqid();

        $tpl = "<?php \n";
        $tpl .= "namespace PhpTemplates\\$namespace;\n\n";
        
        $tpl .= "use PhpTemplates\\Parsed\\View;\n";
        $tpl .= "use PhpTemplates\\Loop;\n";
        $tpl .= "use PhpTemplates\\Scopes\\LoopScope;\n";
        $tpl .= "use PhpTemplates\\Parsed\\ViewFactory;\n\n";
        
        $tpl .= "class _View extends ViewFactory {\n";
        $tpl .= "    protected array \$templates = [\n";
        foreach ($nameToClassName as $name => $className) {
        $tpl .= "        '$name' => {$className}::class,\n";
        }
        $tpl .= "    ];\n";
        $tpl .= "}\n\n";
        
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

        foreach ($classDefinitions as $def) {
            $tpl .= PHP_EOL.PHP_EOL . $def;
        }
        
        $tpl .= 'return _View::class;';

        file_put_contents($path, $tpl);
        
        return require_once($path);
    }

    protected function getFilePath(string $key)
    {
        $pf = rtrim($this->storePath, '/ ') . '/';
        $hash = substr(base_convert(md5($key), 16, 32), 0, 12);
        $name = trim(str_replace(['/', ':'], '_', $key), '/ ') . '_' . $hash;

        return $pf . $name . '.php';
    }
    
    public function add($template): void
    {
        $this->store[$template['name']] = $template;
    }
}
