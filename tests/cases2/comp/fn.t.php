<div>
    <slot></slot>
    {{ $this->doSomething() }}
    {{ $this->doSomethingElse() }}
    {{ $this->doSomethingCommon(3) }}
</div>

<?php

return new class
{
    public function doSomethingElse() {
        return $this->cfgKey().':doSomethingElse';
    }
};