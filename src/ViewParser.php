<?php

namespace PhpTemplates;

class ViewParser
{
    public function __construct(ConfigHolder $configs, EventHolder $eventHolder) 
    {
        //todo
    }
    
    public function parse(Document $document): string // return result path
    {
        kfgk = obtaining gfgkey by tpl name
        rfp = obtainin file path without cfg prefix
        cfg = cfg->_getConfigholder getcfh(kfgk)
        new Root(document, cfg, nullode, name, context);
        document->addtf cfgpf + rfpath
        
        (new Root($process, null, $rfilepath))->rootContext();
        $this->document->setContent($process->getResult());
        $path = $this->document->save();
        
        
        
    }
}