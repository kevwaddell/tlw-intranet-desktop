<?php if ($total_users > $number) { 
	if ( !isset($_GET['list_style']) ) {
	$format = '?paged=%#%';
	} else {
	$format = '&paged=%#%';
	}
?>

<div class="pagination-links user-pag user-pag-bot">
<?php echo paginate_links(array(  
              'base' => get_pagenum_link(1) . '%_%',  
              'format' => $format,  
              'current' => $paged,  
              'total' => $total_pages,  
              'prev_text' => 'Previous',  
              'next_text' => 'Next'  
            )); 
            
 ?>
</div>	

<?php } ?>
