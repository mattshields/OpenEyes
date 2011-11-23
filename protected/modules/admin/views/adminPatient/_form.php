<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'patient-form',
        'enableAjaxValidation' => false,));
    $address = $model->address;
	if ($address == null) {
		$address = Address::model();
	}
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'pas_key'); ?>
        <?php echo $form->textField($model, 'pas_key', array('size' => 10, 'maxlength' => 10)); ?>
        <?php echo $form->error($model, 'pas_key'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'title'); ?>
        <?php echo $form->textField($model, 'title', array('size' => 8, 'maxlength' => 8)); ?>
        <?php echo $form->error($model, 'title'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'first_name'); ?>
        <?php echo $form->textField($model, 'first_name', array('size' => 40, 'maxlength' => 40)); ?>
        <?php echo $form->error($model, 'first_name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'last_name'); ?>
        <?php echo $form->textField($model, 'last_name', array('size' => 40, 'maxlength' => 40)); ?>
        <?php echo $form->error($model, 'last_name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'dob'); ?>
        <?php echo $form->textField($model, 'dob'); ?>
        <?php echo $form->error($model, 'dob'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'gender'); ?>
        <?php echo $form->textField($model, 'gender', array('size' => 1, 'maxlength' => 1)); ?>
        <?php echo $form->error($model, 'gender'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'hos_num'); ?>
        <?php echo $form->textField($model, 'hos_num', array('size' => 40, 'maxlength' => 40)); ?>
        <?php echo $form->error($model, 'hos_num'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'nhs_num'); ?>
        <?php echo $form->textField($model, 'nhs_num', array('size' => 40, 'maxlength' => 40)); ?>
        <?php echo $form->error($model, 'nhs_num'); ?>
    </div>

    <!-- inserted address fields -->
    <div class="row">
        <?php echo $form->labelEx($address, 'address1'); ?>
        <?php echo $form->textField($address, 'address1', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($address, 'address1'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($address, 'address2'); ?>
        <?php echo $form->textField($address, 'address2', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($address, 'address2'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($address, 'city'); ?>
        <?php echo $form->textField($address, 'city', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($address, 'city'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($address, 'postcode'); ?>
        <?php echo $form->textField($address, 'postcode', array('size' => 10, 'maxlength' => 10)); ?>
        <?php echo $form->error($address, 'postcode'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($address, 'county'); ?>
        <?php echo $form->textField($address, 'county', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($address, 'county'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($address, 'country_id'); ?>
        <?php echo $form->dropDownList($address, 'country_id', CHtml::listData(Country::model()->findAll(), 'id', 'name'),
            array('prompt' => 'Select a Country')); ?>
        <?php echo $form->error($address, 'country_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($address, 'email'); ?>
        <?php echo $form->textField($address, 'email', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($address, 'email'); ?>
    </div>

    <!-- end address -->

    <div class="row">
        <?php echo $form->labelEx($model, 'primary_phone'); ?>
        <?php echo $form->textField($model, 'primary_phone', array('size' => 20, 'maxlength' => 20)); ?>
        <?php echo $form->error($model, 'primary_phone'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->