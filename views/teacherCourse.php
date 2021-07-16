<?php
/** @var $this \app\core\View */
/** @var $model \app\models\Course */


use app\core\form\Form;

$this->title = 'myCourses';
?>
<h1>Teacher Courses</h1>


<?php $form = Form::begin('', 'post', 'ajax-form') ?>
    <?php echo $form->field($model, 'name') ?>
    <?php echo $form->field($model, 'start')->timeField() ?>
    <?php echo $form->field($model, 'end')->timeField() ?>
    <button type="submit" class="btn btn-primary">Submit</button>
<?php Form::end() ?>



