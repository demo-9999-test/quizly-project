@if(isset($data->content))
<div class="ai-text-result scroll-down">
    <div class="ai-copy-icon">
        <button type="button" class="copy-button" title="Copy" onclick="copyText()">
            <i class="feather icon-copy"></i>
        </button>
    </div>
    <p id="myInput">{{ is_array($data->content) ? json_encode($data->content) : $data->content }}</p>
</div>
@endif
