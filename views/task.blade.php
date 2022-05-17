<link href="{{ publicPath("lib/task.js") }}" rel=preload as=script>
<noscript>
    <strong>We're sorry but this extension doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
</noscript>
<div data-api-url="{{ API("") }}" id="task" tasks='{{ json_encode($tasks) }}'></div>
<script src="{{ publicPath("lib/task.js") }}"></script>