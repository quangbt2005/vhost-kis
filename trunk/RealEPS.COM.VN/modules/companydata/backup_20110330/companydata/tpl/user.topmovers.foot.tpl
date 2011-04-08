{literal}
<script>
function onSubmit(){    
	var se = $('#tm_se').val();    
    var industry = $('#tm_industry').val();
    var orderby = $('#tm_orderby').val();
    var ordertype = $('#tm_ordertype').val();
    var view = $('#tm_view').val();
    var limit = $('#tm_limit').val();
    var link = '/doanh-nghiep/cong-ty/index.html';
    link += '?se=' + se + '&industry=' + industry + '&orderby=' + orderby + '&ordertype=' + ordertype + '&view=' + view + '&limit=' + limit;
    window.location = link;
    //var industry = $('se').val();    
}
</script>
{/literal}