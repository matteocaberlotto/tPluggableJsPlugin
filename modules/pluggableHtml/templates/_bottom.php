<?php $ns = sfConfig::get('app_pluggable_js_plugin_javascript_namespace', 'jqPluggable'); ?>
<script>

(function($){
    var context = document;
    jQuery.each(<?php echo $ns ?>.init, function() {
      this(context);
    });
})(jQuery)

</script>
