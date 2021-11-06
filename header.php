<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Alumni
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="user-scalable=no width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.9/css/all.css" integrity="sha384-5SOiIsAziJl6AWe0HWRKTXlfcSHKmYV4RBF18PPJ173Kzn7jzMyFuTtk8JA7QQG1" crossorigin="anonymous">
	<?php wp_head(); ?>
</head>

<body>

<header role="banner">		
	<nav class="navbar navbar-expand-md navbar-main" id="mainmenu" role="navigation">			
		<a class="navbar-brand" id="triangle-logo" href="<?php echo esc_url(home_url('/')); ?>" rel="home">
			<img src="<?php echo get_template_directory_uri() . '/images/logo-black.svg'; ?>" alt="Triangle Alumni"></img>
		</a>
		
		<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target=".navbar-toggle" aria-controls="navbar-toggle" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		
		<?php /* Global site navigation bar. Member-only areas only appear when user is signed in. */ ?>
		<div class="collapse navbar-collapse navbar-toggle" id="navbar-links">
			<ul class="navbar-nav navbar-nav-main">
				<li class="nav-item">
					<a class="nav-link" href="/">Home</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="dropdown-members" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">About</a>
					<div class="dropdown-menu" aria-labelledby="dropdown-members">
						<a href="/about" class="dropdown-item">About The Triangle</a>
						<a href="/news" class="dropdown-item">News</a>
						<a href="/contact" class="dropdown-item">Contact Us</a>
					</div>
				</li>
				
				<?php if (is_user_logged_in()): /* Only print these links if member is logged in */ ?>
				<li class="nav-item">
					<a class="nav-link" href="/members">Members</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="/events">Events</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="/forums">Forum</a>
				</li>
				<?php endif ?>
				
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="dropdown-members" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Get Involved</a>
					<div class="dropdown-menu" aria-labelledby="dropdown-members">
						<a href="/join" class="dropdown-item">Join the Association</a>
						<a href="/volunteer" class="dropdown-item">Volunteer</a>
						<a href="https://secureia.drexel.edu/s/1683/form/16/form.aspx?sid=1683&gid=2&pgid=477&cid=1122&dids=343&bledit=1" class="dropdown-item">Donate</a>
					</div>
				</li>
			</ul>
		</div>
		
		<?php /* Navigation bar for user tools. Will only show sign in button if user is not logged in. Will show tools otherwise. */ ?>
		<div class="collapse navbar-collapse navbar-toggle justify-content-end" id="navbar-profile">
			<ul class="navbar-nav navbar-nav-profile">				
				<?php if (is_user_logged_in()): /* Only print these links if member is logged in */ ?>
				
				<!-- Messages button -->
				<li id="nav-messages" class="nav-item nav-icon dropdown">
					<a class="dropdown-toggle" href="#" id="dropdown-messages" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<?php if(bp_get_total_unread_messages_count() > 0): ?>
							<i class="far fa-envelope" style="color: red"></i>
						<?php else: ?>
							<i class="far fa-envelope-open"></i>
						<?php endif ?>
					</a>
					<div id="dropdown-messages" class="dropdown-menu dropdown-icon dropdown-menu-right" aria-labelledby="dropdown-messages">
						<?php
							// BUG: messages are not output for administrators on non-BP pages
						
							if(bp_has_message_threads(array('max' => 5)))
							{
								// TODO: put buttons 'mark all as read' and 'go to inbox'
								
								while(bp_message_threads())
								{
									bp_message_thread();
									printf('<div class="dropdown-divider"></div>');
									printf('<a href="%1$s" class="dropdown-item">%2$s...<br>From: %3$s</a>',
											bp_get_message_thread_view_link(),
											bp_get_message_thread_excerpt(),
											wp_strip_all_tags(bp_get_message_thread_from()));
								}
								
								printf('<div class="dropdown-divider"></div>');
								printf('<a href="%1$smessages" class="dropdown-item">See all messages...</a>', bp_loggedin_user_domain());
							}
							else
							{
								// If users has no unread messages, tell them and give a link to their full inbox
								printf('<a href="%1$smessages" class="dropdown-item">You have no messages</a>', bp_loggedin_user_domain());
							}
						?>
					</div>
				</li>
				
				<!-- Notifications button -->
				<li id="nav-notifications" class="nav-item nav-icon dropdown">
					<a id="dropdown-notifications" class="dropdown-toggle" href="#" id="dropdown-messages" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<?php if(bp_notifications_get_unread_notification_count() > 0): ?>
							<i class="far fa-bell" style="color: red"></i>
						<?php else: ?>
							<i class="far fa-bell"></i>
						<?php endif ?>
					</a>
					<div class="dropdown-menu dropdown-icon dropdown-menu-right" aria-labelledby="dropdown-notifications">
						<?php
							if(bp_has_notifications(array('type' => 'unread')))
							{
								while(bp_the_notifications())
								{
									bp_the_notification();
									printf('<a href="%1$s" class="dropdown-item">%2$s</a>',
											'',
											bp_get_the_notification_description());
									//bp_the_notification_mark_read_url();
								}							
							}
							else
							{
								// If users has no unread notifications, tell them and give a link to their read notifications inbox
								printf('<a href="%1$s/notifications/read/" class="dropdown-item">You have no new notifications</a>', bp_loggedin_user_domain());
							}
						?>
					</div>
				</li>
				
				<!-- Avatar button -->
				<li id="nav-profile" class="nav-item dropdown">
					<a id="dropdown-profile" class="dropdown-toggle" href="#" id="dropdown-avatar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<?php echo bp_core_fetch_avatar(array(
						  'item_id' => bp_loggedin_user_id(),
						  'width' => 35,
						  'height' => 35,
						  'class' => 'header-navbar-avatar')
						); ?>
					</a>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-profile">
						<a href="<?php echo bp_loggedin_user_domain() ?>" class="dropdown-item">Profile</a>
						<a href="#" class="dropdown-item">Friends</a>
						<a href="#" class="dropdown-item">Groups</a>
						<a href="#" class="dropdown-item">My Forum Posts</a>
						<div class="dropdown-divider"></div>
						<a href="<?php echo wp_logout_url('/') ?>" class="dropdown-item">Sign Out</a>
					</div>
				</li>
				<?php else: ?>
				<li class="nav-item">
					<a class="nav-link" href="<?php echo wp_login_url('/') ?>">Sign In</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="/join">Register</a>
				</li>
				<?php endif ?>
			</ul>
		</div>
	</nav>
</header>