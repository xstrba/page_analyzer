<div class="result-item border-left border-bottom bg-white
    {{ $border }}
    ">
    <h2 class="{{ $text }}">PageSpeed Insights</h2>
    <div class="result-item {{ $text }} item-big border-left border-primary bg-grey">
        <span class="font-weight-bold mr-2">Score:</span>
        {{ $score }}
    </div>
    @foreach($audits as $key => $val)
        <div class="result-item border-left border-primary bg-grey">
            <span class="mr-2 font-weight-bold">{{ $key }}:</span>
            {{ $val }}
        </div>
    @endforeach
</div>
