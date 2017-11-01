<?php
global $add_holiday_errors;	
?>

<?php if (array_key_exists('date-next-year', $add_holiday_errors)) { ?>
<div class="alert alert-danger text-center">
	<?php echo $add_holiday_errors['date-next-year']; ?>
</div>
<?php } ?>

<?php if (array_key_exists('date-error-from', $add_holiday_errors)) { ?>
<div class="alert alert-danger text-center">
	<?php echo $add_holiday_errors['date-error-from']; ?>
</div>
<?php } ?>