<div class="result-item border-left bg-white border-primary">
    <span class="font-weight-bold mr-2">
        Robots allowed
        @if( !empty($link))
            <a href="{{ $link }}" target="_blank">robots.txt</a>
        @else
            (didn't find robots.txt)
        @endif
        :
    </span>
    @if($robotsAllowed)
        <i class="fas fa-check text-success"></i>
    @else
        <i class="fas fa-times text-danger"></i>
    @endif
</div>
