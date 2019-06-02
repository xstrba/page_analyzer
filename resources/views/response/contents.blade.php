<div class="result-item border-left
    @if(!$altsMiss && !$altsEmpty)
        bg-white
        border-primary
    @else
        bg-danger
        border-danger
    @endif">
    <span class="font-weight-bold mr-2">Number of images:</span>{{ $imgCount }}<br/>
    <span class="font-weight-bold mr-2">Number of alt properties missing:</span>{{ $altsMiss }}<br/>
    <span class="font-weight-bold mr-2">Number of empty alt properties:</span>{{ $altsEmpty }}<br/>
</div>

<div class="result-item border-left bg-white border-primary">
    <span class="font-weight-bold mr-2">Support of indexing (meta tags):</span>
    @if($robotsAllowed)
        <i class="fas fa-check text-success"></i>
    @else
        <i class="fas fa-times text-danger"></i>
    @endif
</div>
