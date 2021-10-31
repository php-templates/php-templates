<div class="card">
    <div class="card-body">
        <slot name="title">
            <h5 p-if="isset($title)" class="card-title">{{ $title }}</h5>
        </slot>
        <slot></slot>
    </div>
</div>