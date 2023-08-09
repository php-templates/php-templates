<div>
    <div>{{ $this->doSomething() }}</div>
    <div>{{ $this->doSomethingElse() }}</div>
    <div>{{ $this->doSomethingCommon(1) }}</div>
    <tpl is="cases2:comp/fn">
        <div>{{ $this->doSomething() }}</div>
        <div>{{ $this->doSomethingElse() }}</div>
        <div>{{ $this->doSomethingCommon(2) }}</div>
    </tpl>
</div>
<?php
return new class {
    public function doSomethingElse() {
        return $this->cfgKey().':doSomethingElse';
    }
}; ?>
=====
<div>
    <div>default:doSomething</div>
    <div>default:doSomethingElse</div>
    <div>default:doSomethingCommonWith 1</div>
    <div>
        <div>default:doSomething</div>
        <div>default:doSomethingElse</div>
        <div>default:doSomethingCommonWith 2</div>
        cases2:doSomething
        cases2:doSomethingElse
        cases2:doSomethingCommonWith 3
    </div>
</div>