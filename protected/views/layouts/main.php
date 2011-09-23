<!doctype html> 
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]--> 
<!--[if IE 7]>		<html class="no-js ie7 oldie" lang="en"> <![endif]--> 
<!--[if IE 8]>		<html class="no-js ie8 oldie" lang="en"> <![endif]--> 
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]--> 
<head> 
	<meta charset="utf-8"> 
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
 
	<title><?php echo CHtml::encode($this->pageTitle); ?></title> 
	<meta name="viewport" content="width=device-width"> 
	<link rel="icon" href="favicon.ico" type="image/x-icon" /> 
	<link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/favicon.ico"/> 
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css"> 
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/libs/modernizr-2.0.6.min.js"></script> 
</head> 
 
<body> 
 
	<div id="container"> 
		<div id="header" class="clearfix"> 
			<div id="brand" class="ir"><a href="/site/index"><h1>OpenEyes</h1></a></div> 
			<?php echo $this->renderPartial('//base/_form', array()); ?>
		</div> <!-- #header --> 
		<!--div id="mainmenu">
			<?php $this->widget('zii.widgets.CMenu',array(
				'items'=>array(
					array('label'=>'Home', 'url'=>array('/site/index'), 'visible'=>!Yii::app()->user->isGuest),
					array('label'=>'Admin', 'url'=>array('/admin'), 'visible'=>!Yii::app()->user->isGuest),
					array('label'=>'Search Patients', 'url'=>array('/patient/admin'), 'visible'=>!Yii::app()->user->isGuest),
					array('label'=>'Phrases for this firm', 'url'=>array('/phraseByFirm/index'), 'visible'=>!Yii::app()->user->isGuest),
					array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
					array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
				),
			)); ?>
		</div--><!-- mainmenu -->

		<div id="content"> 
			<?php echo $content; ?>
		</div> <!-- #content --> 
		<div id="help" class="clearfix"> 
			<div class="hint">
				<p><strong>Do you need help with OpenEyes?</strong></p>
				<p>Before you contact the helpdesk...</p>
				<p>Is there a "Super User" in your office available? (A "Super User" is...)</p>
				<p>Have you checked the <a href="#">Quick Reference Guide?</a></p>
			</div>
			<div class="hint">
				<p><strong>Searching by patient details.</strong></p>
				<p>Although the Last Name is required it doesn't have to be complete. For example if you search for "Smi", the results will include all last names starting with "Smi...". Any other information you can add will help narrow the search results.</p>
			</div>

			<div class="hint">
				<p><strong>Still need help?</strong></p>
				<p>Contact the helpdesk:</p>
				<p>Telephone: 01234 12343567 ext. 0000</p>
				<p>Email: <a href="#">helpdesk@openeyes.org.uk</a></p>
			</div>
		</div> <!-- #help --> 
	</div> 
	<!--#container --> 
	
	<div id="footer"> 
		<h6>&copy; Copyright OpenEyes Foundation 2011 &nbsp;&nbsp;|&nbsp;&nbsp; Terms of Use &nbsp;&nbsp;|&nbsp;&nbsp; Legals</h6> 
	</div> <!-- #footer --> 
 
 
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script> 
	<script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script> 
 
	<script defer src="<?php echo Yii::app()->request->baseUrl; ?>/js/plugins.js"></script>
	<script defer src="<?php echo Yii::app()->request->baseUrl; ?>/js/script.js"></script>
	
	<script type="text/javascript">
		$('select[id=selected_firm_id]').live('change', function() {
			var firmId = $('select[id=selected_firm_id]').val();
			$.ajax({
				type: 'post',
				url: '<?php echo Yii::app()->createUrl('site'); ?>',
				data: {'selected_firm_id': firmId },
				success: function(data) {
					console.log(data);
					window.location.href = '<?php echo Yii::app()->createUrl('site'); ?>';
				}
			});
		});
	</script>

</body> 
</html>
