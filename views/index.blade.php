<script>
    function getVersion() {
        return '{{ getVersion() }}';
    }
    function returnButtons() {
        let supportLink = $($("#ext_menu").find("button")[1]).attr("onclick")
        let settingLink = $($("#ext_menu").find("button")[0]).attr("onclick")
        return {
            support: supportLink.substring(24, supportLink.length - 1),
            settings: settingLink.substring(24, settingLink.length - 1),
        }
    }
    function permissions() {
        let perms = JSON.parse('{!! json_encode($GLOBALS['limanData']['permissions']) !!}');
        return perms;
    }
    function can(perm) {
        return permissions().includes(perm);
    }
    function userStatus() {
        return '{{ $GLOBALS['limanData']['user']['status'] }}';
    }
</script>
<link href="{{ publicPath('js/app.js?v=' . md5(getVersion())) }}" rel=preload as=script>
<noscript><strong>We're sorry but this extension doesn't work properly without JavaScript enabled. Please enable it to continue.</strong></noscript>
<div locale="{{ $GLOBALS['limanData']['locale'] }}" id=app></div>
<script src="{{ publicPath('js/app.js?v=' . md5(getVersion())) }}"></script>
