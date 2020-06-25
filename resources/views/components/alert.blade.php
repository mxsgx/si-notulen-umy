<div {{ $attributes->merge(['class' => $classes]) }} role="alert">
    {{ $content }}

    @if($dismissible)
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    @endif
</div>
