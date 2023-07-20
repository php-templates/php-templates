{!! '<'.'div class="'.(true ? 'some-class' : '').'">' !!}
    <p p-foreach="[1,2] as $i"></p>
{!! '<'.'/div>' !!}
=====
<div class="some-class">
    <p></p>
    <p></p>
</div>

