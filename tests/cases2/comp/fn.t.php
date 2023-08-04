<div>
    <slot></slot>
    {{ $this->doSomething() }}
    {{ $this->doSomethingElse() }}
    {{ $this->doSomethingCommon(3) }}
</div>

<?php

return new class extends PhpTemplates\View
{
    public function doSomethingElse() {
        return $this->cfgKey().':doSomethingElse';
    }
};