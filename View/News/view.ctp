<?php
$this->append('header')
?>
<h2><?php echo h($news['News']['title']); ?></h2>
<?php
$this->end();
?>
<?php echo $news['News']['body']; ?>

<?php
if ( isset($sidebars) ) {
	foreach( $sidebars as $sidebar ) :

	if( empty( $sidebar['News']['title']) ) continue;
	if( empty( $sidebar['News']['body']) ) continue;

	$this->append('sidebar'); ?>
	<h3><?php echo $sidebar['News']['title']; ?></h3>
	<p><?php echo $sidebar['News']['body']; ?></p>		
	<?php $this->end(); ?>
<?php endforeach;
}
?>
