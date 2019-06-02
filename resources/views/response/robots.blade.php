<div class="result-item border-left bg-white border-primary">
    <span class="font-weight-bold mr-2">
        Support of indexing
        @if( !empty($link))
            <a href="{{ $link }}" target="_blank">robots.txt</a>
        @else
            (didn't find robots.txt)
        @endif
        :
    </span>
    @if( empty($robotsDisallowed) )
        <i class="fas fa-check text-success"></i>
    @else
        <i class="fas fa-times text-danger"></i>
        @if( !in_array(7, $robotsDisallowed, true ))
            <a data-toggle="collapse" href="#collapseAgents" role="button"
                aria-expanded="false" aria-controls="collapseAgents">
                ...
            </a>
            <div class="collapse" id="collapseAgents">
                    <span class="font-weight-bold mr-2">Agents disallowed: </span>
                    @foreach($robotsDisallowed as $item)
                        {{ $item.', '}}
                    @endforeach
            </div>
        @endif
    @endif
</div>
