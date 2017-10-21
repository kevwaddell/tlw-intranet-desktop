
			</section>
			<!-- MAIN CONTENT END -->
			<footer id="app-info" class="main-footer" role="contentinfo">
				<?php 
				global $current_user;
				global $post;
				$date_format = get_option('date_format');
				$time_format = get_option('time_format');
				$timeZone = 'Europe/London';
				$now_dateTime = new DateTime("now", new DateTimeZone($timeZone));
				$now_ts = $now_dateTime->getTimestamp();
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
				$rem_later = get_field('remind_later', $rem->ID);
				$priority = get_field('reminder_priority', $rem->ID);
				
					if (in_array_r($rem->ID, $reminders_completed) && $priority == 'never') {
					unset($reminders[$k]);	
					}	
					if (!empty($rem_later)) {
					$rem_later_dateTime = new DateTime($rem_later, new DateTimeZone($timeZone));
					//debug($rem_later_dateTime->getTimestamp()." -- ".$now_ts);
						if ( $rem_later_dateTime->getTimestamp() > $now_ts) {
						unset($reminders[$k]);
						}		
					}
				}	
				sort($reminders);
				//debug($reminders);
				foreach ($reminders as $k => $rem) {
				$priority = get_field('reminder_priority', $rem->ID);
				$group_id = get_field('reminder_group', $rem->ID);
				$rem_date = get_field('reminder_date', $rem->ID);
				$rem_time = get_field('reminder_time', $rem->ID);
				$rem_dateTime = new DateTime($rem_date." ".$rem_time, new DateTimeZone($timeZone));
					
					if ( $now_ts > $rem_dateTime->getTimestamp() ) {
					$rem_date = "";
					$interval = $rem_dateTime->diff($now_dateTime);	
					if ($interval->y != 0) {
					$y = ($interval->y > 1) ? 'Yrs':'Yr';
					$rem_date .= $interval->format("%y $y ");	
					}
					if ($interval->m != 0) {
					$m = ($interval->m > 1) ? 'Mths':'Mth';
					$rem_date .= $interval->format("%m $m ");	
					}
					if ($interval->d != 0) {
					$d = ($interval->d > 1) ? 'Dys':'Dy';
					$rem_date .= $interval->format("%d $d ");		
					}
					if ($interval->h != 0) {
					$h = ($interval->h > 1) ? 'Hrs':'Hr';
					$rem_date .= $interval->format("%h $h ");		
					}
					if ($interval->i != 0) {
					$rem_date .= $interval->format('and %i mins ');		
					}
					$rem_date .= "ago";
					//echo '<pre>';print_r($interval);echo '</pre>';
					}
					
					if ($priority == 'low') {
					$low_p[] = array('reminder-id' => $rem->ID, 'group-id' => $group_id, 'rem-date' => $rem_date );	
					}
					if ($priority == 'med') {
					$med_p[] = array('reminder-id' => $rem->ID, 'group-id' => $group_id , 'rem-date' => $rem_date);	
					}	
					if ($priority == 'high') {
					$high_p[] = array('reminder-id' => $rem->ID, 'group-id' => $group_id , 'rem-date' => $rem_date);	
					}
					if ($priority == 'none') {
					$no_p[] = array('reminder-id' => $rem->ID, 'group-id' => $group_id , 'rem-date' => $rem_date);	
					}
				}
				//debug($med_p);
				?>
				<?php if (!empty($reminders) && $post->ID != $reminders_pg->ID) { ?>
				<div class="reminder-alerts-btn">
					<button id="reminders-alert-btn" class="btn btn-default closed"><i class="fa fa-bell fa-2x"></i><div class="badge"><?php echo count($reminders); ?></div></button>
				</div>
				<div class="reminder-alerts reminders-closed">
					<div class="reminder-alerts-inner">
					<?php if (!empty($high_p)) { ?>
					<form action="<?php echo get_permalink($reminders_pg->ID); ?>" class="reminder-alerts-form" method="post">
						<?php foreach ($high_p as $hp) { ?>
							<div id="reminder-<?php echo $hp['reminder-id']; ?>" class="reminder-alert high-p">
								<div class="title">!!! <?php echo get_the_title($hp['reminder-id']); ?></div>
								<div class="time"><?php echo $hp['rem-date']; ?></div>
								<div class="actions">
									<input type="hidden" name="group-id" value="<?php echo $hp['group-id']; ?>">
									<button type="submit" name="status" value="<?php echo $hp['reminder-id']; ?>" class="complete-btn btn btn-default">Complete</button>
									<button type="submit" class="btn btn-default" name="status-later" value="<?php echo $hp['reminder-id']; ?>">Later</button>
								</div>
							</div>
						<?php } ?>
					</form>
					<?php } ?>
					<?php if (!empty($med_p)) { ?>
					<form action="<?php echo get_permalink($reminders_pg->ID); ?>" class="reminder-alerts-form" method="post">
						<?php foreach ($med_p as $mp) { ?>
							<div id="reminder-<?php echo $mp['reminder-id']; ?>" class="reminder-alert med-p">
								<div class="title">!! <?php echo get_the_title($mp['reminder-id']); ?></div>
								<div class="time"><?php echo $mp['rem-date']; ?></div>
								<div class="actions">
									<input type="hidden" name="group-id" value="<?php echo $mp['group-id']; ?>">
									<button type="submit" name="status" value="<?php echo $mp['reminder-id']; ?>" class="complete-btn btn btn-default">Complete</button>
									<button type="submit" class="btn btn-default" name="status-later" value="<?php echo $mp['reminder-id']; ?>">Later</button>
								</div>
							</div>
						<?php } ?>
					</form>
					<?php } ?>
					<?php if (!empty($low_p)) { ?>
					<form action="<?php echo get_permalink($reminders_pg->ID); ?>" class="reminder-alerts-form" method="post">
						<?php foreach ($low_p as $lp) { ?>
							<div id="reminder-<?php echo $lp['reminder-id']; ?>" class="reminder-alert low-p">
								<div class="title">! <?php echo get_the_title($lp['reminder-id']); ?></div>
								<div class="time"><?php echo $lp['rem-date']; ?></div>
								<div class="actions">
									<input type="hidden" name="group-id" value="<?php echo $lp['group-id']; ?>">
									<button type="submit" name="status" value="<?php echo $lp['reminder-id']; ?>" class="complete-btn btn btn-default">Complete</button>
									<button type="submit" class="btn btn-default" name="status-later" value="<?php echo $mp['reminder-id']; ?>">Later</button>
								</div>
							</div>
						<?php } ?>
					</form>
					<?php } ?>
					<?php if (!empty($no_p)) { ?>
					<form action="<?php echo get_permalink($reminders_pg->ID); ?>" class="reminder-alerts-form" method="post">
						<?php foreach ($no_p as $np) { ?>
							<div id="reminder-<?php echo $np['reminder-id']; ?>" class="reminder-alert">
								<div class="title"><?php echo get_the_title($np['reminder-id']); ?></div>
								<div class="time"><?php echo $np['rem-date']; ?></div>
								<div class="actions">
									<input type="hidden" name="group-id" value="<?php echo $np['group-id']; ?>">
									<button type="submit" name="status" value="<?php echo $np['reminder-id']; ?>" class="complete-btn btn btn-default">Complete</button>
									<button type="submit" class="btn btn-default" name="status-later" value="<?php echo $mp['reminder-id']; ?>">Later</button>
								</div>
							</div>
						<?php } ?>
					</form>
					<?php } ?>
					</div>
				</div>
				<?php } ?>
			</footer>
			
		</div>
		<!-- APP WRAPPER END -->
							
		<?php wp_footer(); ?>

	</body>
</html>