<?php
/*
Template Name: Department page
*/
?>

<?php get_header(); ?>

<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>	

<?php 
$icon = get_field('icon');
$color = get_field('col');
$team_members = get_field('team');
$parent = get_page($post->post_parent);
$children = get_pages('parent='.$parent->ID.'&sort_column=menu_order');
?>	
		<article <?php post_class(); ?>>
			<h1 class="block-header<?php echo (!empty($color)) ? " col-".$color:""; ?>"><?php if (!empty($icon)) {  echo '<i class="fa '.$icon.' fa-lg"></i>'; }?><?php the_title(); ?></h1>
			
			<?php include (STYLESHEETPATH . '/_/inc/global/banner-imgs.php'); ?>
			
			<?php the_content(); ?>
			
			<?php if ($team_members) { ?>
			<div class="rule"></div>
			
			<?php if ($children) { ?>
			<div class="action-btns<?php echo (!empty($color)) ? " col-".$color:" col-gray"; ?>">
				<div id="department-links" class="links-dropdown inactive">
					
					<div class="links-dropdown-inner">
						
						<button id="links-dropdown-btn" class="btn btn-default btn-block no-arrow"><?php echo $parent->post_title;  ?>
						<i class="fa fa-plus-circle fa-lg"></i><i class="fa fa-minus-circle fa-lg"></i></button>
						
						<ul class="list-unstyled clearfix">
							<?php foreach ($children as $child) { 
							$child_icon = get_field('icon', $child->ID);
							$child_col = get_field('col', $child->ID);
							?>
							<li>
								<a href="<?php echo get_permalink($child->ID);  ?>" class="col-<?php echo $child_col;  ?>" title="View: <?php echo $child->post_title;  ?> ">
								<i class="fa <?php echo $child_icon;  ?>"></i>
								<?php echo $child->post_title;  ?>
								</a>
							</li>
							<?php } ?>
						</ul>
					
					</div>	
					
				</div>
			</div>
			
			<div class="rule"></div>
			<?php } ?>
		
			<section id="department-list" class="grid-list">
			
				<div class="row">
				
				<?php foreach ($team_members as $t_member) { 
				//print_r($t_member);
				$job_title = get_user_meta($t_member['team_member']['ID'],'job_title', true);	
				$avatar = get_avatar( $t_member['team_member']['ID'], 150 );
				$ext = get_user_meta($t_member['team_member']['ID'],'extension', true);	
				?>
					<div class="col-xs-6">
						<div class="list-item">
							<div class="row">
								
								<div class="col-xs-4">
									<figure class="profile-img">
										<?php echo $avatar; ?>
									</figure>
								</div>
								
								<div class="col-xs-8">
									<div class="user-info">
										<div class="info-text name">
											<?php echo $t_member['team_member']['display_name']; ?> <?php echo ($ext) ? '<span class="pull-right"><i class="fa fa-phone-square"></i> '.$ext.'</span>':''; ?>
										</div>
										<div class="info-text position">
											<?php echo $job_title; ?>
										</div>
										<div class="info-text email">
											<i class="fa fa-envelope fa-lg"></i> <a href="mailto:<?php echo $t_member['team_member']['user_email']; ?>"><?php echo $t_member['team_member']['user_email']; ?></a>
										</div>
										
										<div class="action-btns<?php echo (!empty($color)) ? " col-".$color:""; ?>">
											<a href="<?php echo get_author_posts_url($t_member['team_member']['ID']);?>" class="btn btn-default btn-block"><i class="fa fa-eye fa-lg"></i> View Profile</a>
										</div>
									</div>
								</div>
							
							</div>
						</div>
					</div>
				<?php } ?>
				
				</div>
				
			</section>	
			<?php } ?>
			
			
		</article>
		
<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
