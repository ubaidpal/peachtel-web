<?php /* Smarty version Smarty-3.1.8, created on 2012-12-15 00:20:03
         compiled from "/var/www/prestashop/modules/blocksearch/blocksearch-instantsearch.tpl" */ ?>
<?php /*%%SmartyHeaderCode:23573265150cc08839a9680-06128858%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bd4d151bfcf196793172835cc18d2986e08dba12' => 
    array (
      0 => '/var/www/prestashop/modules/blocksearch/blocksearch-instantsearch.tpl',
      1 => 1355372793,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '23573265150cc08839a9680-06128858',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'instantsearch' => 0,
    'blocksearch_type' => 0,
    'search_ssl' => 0,
    'link' => 0,
    'cookie' => 0,
    'ajaxsearch' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_50cc0883a1b906_26761507',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50cc0883a1b906_26761507')) {function content_50cc0883a1b906_26761507($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['instantsearch']->value){?>
	<script type="text/javascript">
	// <![CDATA[
		function tryToCloseInstantSearch() {
			if ($('#old_center_column').length > 0)
			{
				$('#center_column').remove();
				$('#old_center_column').attr('id', 'center_column');
				$('#center_column').show();
				return false;
			}
		}
		
		instantSearchQueries = new Array();
		function stopInstantSearchQueries(){
			for(i=0;i<instantSearchQueries.length;i++) {
				instantSearchQueries[i].abort();
			}
			instantSearchQueries = new Array();
		}
		
		$("#search_query_<?php echo $_smarty_tpl->tpl_vars['blocksearch_type']->value;?>
").keyup(function(){
			if($(this).val().length > 0){
				stopInstantSearchQueries();
				instantSearchQuery = $.ajax({
					url: '<?php if ($_smarty_tpl->tpl_vars['search_ssl']->value==1){?><?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('search',true);?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('search');?>
<?php }?>',
					data: {
						instantSearch: 1,
						id_lang: <?php echo $_smarty_tpl->tpl_vars['cookie']->value->id_lang;?>
,
						q: $(this).val()
					},
					dataType: 'html',
					type: 'POST',
					success: function(data){
						if($("#search_query_<?php echo $_smarty_tpl->tpl_vars['blocksearch_type']->value;?>
").val().length > 0)
						{
							tryToCloseInstantSearch();
							$('#center_column').attr('id', 'old_center_column');
							$('#old_center_column').after('<div id="center_column" class="' + $('#old_center_column').attr('class') + '">'+data+'</div>');
							$('#old_center_column').hide();
							$("#instant_search_results a.close").click(function() {
								$("#search_query_<?php echo $_smarty_tpl->tpl_vars['blocksearch_type']->value;?>
").val('');
								return tryToCloseInstantSearch();
							});
							return false;
						}
						else
							tryToCloseInstantSearch();
					}
				});
				instantSearchQueries.push(instantSearchQuery);
			}
			else
				tryToCloseInstantSearch();
		});
	// ]]>
	</script>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['ajaxsearch']->value){?>
	<script type="text/javascript">
	// <![CDATA[
		$('document').ready( function() {
			$("#search_query_<?php echo $_smarty_tpl->tpl_vars['blocksearch_type']->value;?>
")
				.autocomplete(
					'<?php if ($_smarty_tpl->tpl_vars['search_ssl']->value==1){?><?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('search',true);?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('search');?>
<?php }?>', {
						minChars: 3,
						max: 10,
						width: 500,
						selectFirst: false,
						scroll: false,
						dataType: "json",
						formatItem: function(data, i, max, value, term) {
							return value;
						},
						parse: function(data) {
							var mytab = new Array();
							for (var i = 0; i < data.length; i++)
								mytab[mytab.length] = { data: data[i], value: data[i].cname + ' > ' + data[i].pname };
							return mytab;
						},
						extraParams: {
							ajaxSearch: 1,
							id_lang: <?php echo $_smarty_tpl->tpl_vars['cookie']->value->id_lang;?>

						}
					}
				)
				.result(function(event, data, formatted) {
					$('#search_query_<?php echo $_smarty_tpl->tpl_vars['blocksearch_type']->value;?>
').val(data.pname);
					document.location.href = data.product_link;
				})
		});
	// ]]>
	</script>
<?php }?><?php }} ?>