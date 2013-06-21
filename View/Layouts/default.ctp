<?php

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');

$elements = Configure::read('BostonConference.Elements');

function includeElements( View $view, $element, $path )
{
	if ( is_string($element) )
	{
		echo $view->element($element);
	}
	else if ( is_array($element) && count($element) > 0 )
	{
		foreach ( $element as $i => $child )
		{
			if ( is_int($i) )
				includeElements($view, $child, $path);
		}

		if ( count($path) > 0 && array_key_exists($path[0],$element) )
		{
			$childPath = $path;
			includeElements($view, $element[array_shift($childPath)], $childPath);
		}
	}
}

if ( $elements )
{
	$this->start('after-content');
	$path = isset($element_path) ? $element_path : array();

	if ( !isset($is_admin_area) || !$is_admin_area )
		includeElements($this, $elements, $path);
	else if ( array_key_exists('Admin',$elements) )
		includeElements($this, $elements['Admin'], $path);

	$this->end();
}

?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title><?php if( empty( $title_for_layout ) ) {
				echo Configure::read('BostonConference.siteName');
	} else {
				echo $title_for_layout.' | '.Configure::read('BostonConference.siteName');
	}?></title>
	<?php
		echo $this->fetch('meta');
		echo $this->Html->meta('icon');

		echo $this->Html->css('/boston_conference/css/base.css');
		echo $this->fetch('css');

		echo $this->Html->script('//ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js', array('inline' => true));
		echo $this->fetch('script');
		echo $this->fetch('before_closing_head');
	?>
</head>
<body id='<?php echo $this->params->controller; ?>'>
	<div id="container">
		<div id="header">
		<?php
			echo $this->Html->link(
				$this->Html->image('/boston_conference/img/logo.png', array('alt'=> Configure::read('BostonConference.siteName'))),
				array('plugin' => 'BostonConference', 'controller' => 'news', 'action' => 'index'),
				array('escape' => false)
			);
		?>
		</div>
		<div id="contentWrapper">
<?php

$sidebar_content = $this->fetch('before-sidebar').$this->fetch('sidebar').$this->fetch('after-sidebar');

$content_class = '';

if ( preg_match('/[^\s]/',$sidebar_content) == 0 )
	$content_class = 'no-sidebar';
else if ( isset($skinny_sidebar) && $skinny_sidebar )
	$content_class = 'skinny-sidebar';

?>
			<div id="content" class="<?php echo $content_class; ?>">

				<div id="navigation">
					<ul class="nav-main">
					<?php
                    foreach( $navigation_links as $link ) {

						$class = ($link[1]['controller'] == $this->params['controller']) ? 'current' : null;

						// Hack
						if( ($link[0] == 'Talks' && $this->params['action']=='agenda') ||
						   ( $link[0] == 'Agenda' && $this->params['action']!='agenda')) $class = null;


						echo $this->Html->tag('li', $this->Html->link(__($link[0]),$link[1]), array('class'=>$class));
                    }
                    ?>
                    </ul>
                    <ul class="nav-auth">
    					<li>
    					<?php
    					if ( !empty($authentication['greeting']) ) {
    						echo $this->Html->clean($authentication['greeting']).'.';
    					}

    					if ( !empty($authentication['login_url']) ) {
    						if( !Configure::read('BostonConference.hide_login_menu') ) {
    							echo $this->Html->link(__('Create an account'),$authentication['register_url']);
    							echo "</li><li>";
    							echo $this->Html->link(__('Login'),$authentication['login_url']);
    						}
    					}

    					if ( !empty($authentication['logout_url']) ) {
    						echo $this->Html->link(__('Logout'),$authentication['logout_url'], array('class'=>'logout'));
    					} ?>
    					</li>
					</ul>
					<div class="sidebar-block"> </div>
				</div>
				<div id="sidebar">
					<?php
						echo $sidebar_content;
					?>
				</div>
				<div id="mainContent">
					<?php echo $this->Session->flash();?>
					<?php
						echo $this->fetch('before-header');
						echo $this->fetch('header');
						echo $this->fetch('before-content');
						echo $this->fetch('content');
						echo $this->fetch('after-content');
					?>
				</div>
			</div>
		</div>
	</div>
	<div id="footer">
		<p>
			Copyright &copy; <?php
				echo date('Y');

				$organizationName = Configure::read('BostonConference.organizationName');
				echo ' '.( $organizationName ? $organizationName : Configure::read('BostonConference.siteName') );?>
				| <?php echo $this->Html->link(__('About us'), array('admin'=>false,'plugin'=>null,'controller'=>'about'));?>
				| <?php echo $this->Html->link(__('Contact us'), array('admin'=>false,'plugin'=>null,'controller'=>'contact'));?>
				| <?php echo $this->Html->link(__('Code of Conduct'), array('admin'=>false,'plugin'=>null,'controller'=>'conduct')); ?>
			<?php echo $this->fetch('footer'); ?>
		</p>

		<?php
			echo $this->Html->link(
				$this->Html->image('BostonConference.boston.power.gif', array('alt'=> __('BostonConference: the open source conference framework', true))),
				'http://www.github.com/andrewcurioso/BostonConference',
				array('target' => '_blank', 'escape' => false)
			);
			echo '&nbsp;';
			echo $this->Html->link(
				$this->Html->image('cake.power.gif', array('alt'=> __('CakePHP: the rapid development php framework', true))),
				'http://www.cakephp.org/',
				array('target' => '_blank', 'escape' => false)
			);
		?>
	</div>

        <div class="water-light right"> </div>
        <div class="water-light left"> </div>

	<?php
		echo $this->element('sql_dump');
	?>
</body>
</html>
