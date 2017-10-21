
			</section>
			<!-- MAIN CONTENT END -->
			<footer id="app-info" class="main-footer" role="contentinfo">
				<?php 
				global $current_user;
				$reminders_pg = get_page_by_path('reminders');
				$reminders_completed_raw = get_user_meta($current_user->ID, 'reminders_completed', true);
				$reminders_completed = unserialize($reminders_completed_raw);
				$low_p = array();
				$med_p = array();
				$high_p = array();
				$no_p = array();
				$reminders_args = array(
				'posts_per_page' => -1,
				'post_type' => 'tlw_reminder',
				'meta_key' => 'reminder_date',
				'meta_value'	=> date('Ymd'),
				'meta_compare'	=> "<=",
				'orderby' => 'meta_value_num',
				'order'	=> 'ASC'	
				);
				$reminders = get_posts($reminders_args);	
				//debug($reminders_completed);
				foreach ($reminders as $k => $rem) {
					if (in_array_r($rem->ID, $reminders_completed)) {
					unset($reminders[$k]);	
					}	
				}	
				sort($reminders);
				foreach ($reminders as $k => $rem) {
				$priority = get_field('reminder_priority', $rem->ID);
				$group_id = get_field('reminder_group', $rem->ID);
					if ($priority == 'low') {
					$low_p[] = array('reminder-id' => $rem->ID, 'group-id' => $group_id);	
					}
					if ($priority == 'med') {
					$med_p[] = array('reminder-id' => $rem->ID, 'group-id' => $group_id);	
					}	
					if ($priority == 'high') {
					$high_p[] = array('reminder-id' => $rem->ID, 'group-id' => $group_id);	
					}
					if ($priority == 'none') {
					$no_p[] = array('reminder-id' => $rem->ID, 'group-id' => $group_id);	
					}
				}
				//debug($med_p);
				?>
				<button id="reminders-alert-btn" class="btn btn-default"><i class="fa fa-bell fa-2x"></i><div class="badge"><?php echo count($reminders); ?></div></button>
				<div class="reminder-alerts reminders-open">
					<?php if (!empty($high_p)) { ?>
						<?php foreach ($high_p as $hp) { ?>
							<div class="reminder-alert high-p">
								<div class="title">!!! <?php echo get_the_title($hp['reminder-id']); ?></div>
								<div class="actions">
									<a href="" class="btn btn-default">Complete</a>
									<a href="" class="btn btn-default">Later</a>
								</div>
							</div>
						<?php } ?>
					<?php } ?>
					<?php if (!empty($med_p)) { ?>
						<?php foreach ($med_p as $mp) { ?>
							<div class="reminder-alert med-p">
								<div class="title">!! <?php echo get_the_title($mp['reminder-id']); ?></div>
								<div class="actions">
									<a href="" class="btn btn-default">Complete</a>
									<a href="" class="btn btn-default">Later</a>
								</div>
							</div>
						<?php } ?>
					<?php } ?>
					<?php if (!empty($low_p)) { ?>
						<?php foreach ($low_p as $lp) { ?>
							<div class="reminder-alert low-p">
								<div class="title">! <?php echo get_the_title($lp['reminder-id']); ?></div>
								<div class="actions">
									<a href="" class="btn btn-default">Complete</a>
									<a href="" class="btn btn-default">Later</a>
								</div>
							</div>
						<?php } ?>
					<?php } ?>
					<?php if (!empty($no_p)) { ?>
						<?php foreach ($no_p as $np) { ?>
							<div class="reminder-alert">
								<div class="title"><?php echo get_the_title($np['reminder-id']); ?></div>
								<div class="actions">
									<a href="" class="btn btn-default">Complete</a>
									<a href="" class="btn btn-default">Later</a>
								</div>
							</div>
						<?php } ?>
					<?php } ?>

				</div>
			</footer>
			
		</div>
		<!-- APP WRAPPER END -->
							
		<?php wp_footer(); ?>

	</body>
</html>