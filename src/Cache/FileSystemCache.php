<?php

namespace PhpTemplates\Cache;

use PhpTemplates\Source;
use PhpTemplates\Contracts\Cache;
use PhpTemplates\View;
use PhpTemplates\ParsingTemplate;

class FileSystemCache implements Cache
{
    protected $storePath;
    protected $store = [];
    protected $source = [];

    public function __construct(string $storePath)
    {
        $this->storePath = $storePath;
    }

    public function get(string $key): ?View
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

    public function remember(ParsingTemplate $template): void
    {
        $path = $this->getFilePath($template->getName());

        if (!is_dir($this->storePath)) {
            mkdir($this->storePath, 0777, true);
        } else {
            chmod($this->storePath, 0777);
        }
dd($template->defineClass());
        $namespace = 'PHPT_' . uniqid();

        $tpl = '<?php ';
        $tpl .= PHP_EOL . "namespace PhpTemplates\\$namespace;";
        $tpl .= PHP_EOL . "use function PhpTemplates\\check_dependencies;";
        $tpl .= PHP_EOL . "use function PhpTemplates\\e;";
        $tpl .= PHP_EOL . "use function PhpTemplates\\resolve_class;";
        $tpl .= PHP_EOL . "use function PhpTemplates\\e_bind;";
        $tpl .= PHP_EOL . "use function PhpTemplates\\arr_except;";
        $tpl .= PHP_EOL . "use PhpTemplates\\Loop;";
        $tpl .= PHP_EOL . "use PhpTemplates\\Slot;";
        $tpl .= PHP_EOL . "use PhpTemplates\\View;";
        $tpl .= PHP_EOL . "use PhpTemplates\\Cache\\FileSystemCache;";
        $tpl .= PHP_EOL . "use PhpTemplates\\Context;";
        foreach ($this->registry->uses as $use) {
            $tpl .= PHP_EOL . "use \\$use;";
        }
        $tpl .= PHP_EOL;

        $dependencies = [];
        foreach ($this->store as $template) {
            if ($template['file']) {
                $dependencies[$template['file']] = filemtime($template['file']);
            }
        }
        $tpl .= PHP_EOL . 'if (!check_dependencies(' . var_export($dependencies, true) . ')) { return false; }' . PHP_EOL;

        foreach ($this->store as $name => $template) {
            $tpl .= PHP_EOL.PHP_EOL . $template['class'];
        }
        
        $tpl .= PHP_EOL.PHP_EOL . 'return ' . $template['class']->getName() . '::class;';

        file_put_contents($path, $tpl);
        
        require_once($path);
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
