@error('url')
    <h1>{{ $message }}</h1>
@enderror
<div class="result-item border-left border-bottom border-success bg-white">
    <span class="font-weight-bold">Page tested:</span>
    <a href="{{ $url }}" target="_blank" class="text-primary">
        {{ ' '.$url }}
    </a>
</div>
<div class="result-item border-left border-primary bg-white">
    <span class="font-weight-bold">Response code:</span>{{ ' '.$code }}
</div>
<div class="result-item border-left border-primary bg-white">
    <span class="font-weight-bold mr-2">Support of HTTP/2.0:</span>
    @if($httpSup)
        <i class="fas fa-check text-success"></i>
    @else
        <i class="fas fa-times text-danger"></i>
    @endif
</div>
<div class="result-item border-left border-primary bg-white">
    <span class="font-weight-bold mr-2">Support of gzip:</span>
    @if($gzipSup)
        <i class="fas fa-check text-success"></i>
    @else
        <i class="fas fa-times text-danger"></i>
    @endif
</div>
