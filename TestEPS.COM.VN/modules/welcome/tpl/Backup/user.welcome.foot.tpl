<iframe name="pushdata" id="pushdata" src ="/index.php?mod=welcome&page=push" frameborder="0" width="0" height="0"></iframe>

<script type="text/javascript" src="/js/jquery.cross-slide.js"></script>
<script type="text/javascript">
var source = [];
<!-- LAY CAC QUANG CAO -->
{ads alias="SLIDER"}
{if count($SLIDER) >= 2}
{foreach from=$SLIDER item="item"}
source[source.length] = {ldelim}src: '{$item.image}', href:'{$item.link}'{rdelim};
{/foreach}
{/if}
<!-- /LAY CAC QUANG CAO -->

{literal}
$(document).ready(function(){	
	if (source.length >= 2){
		$('#slideshow').crossSlide({sleep: 2,fade: 1}, source);
	}	
});
{/literal}
</script>