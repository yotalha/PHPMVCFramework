<?php
/** @var $this \app\core\View */


use app\models\Course;
use app\models\Enroll;

$this->title = 'Courses';
?>
<h1>Student Courses</h1>

<?php
    $courses = Course::findAll();
    $enrolls = Enroll::findAll();
?>

<table class="table">
    <thead>
    <tr>
        <th scope="col">Name</th>
        <th scope="col">Start Time</th>
        <th scope="col">End Time</th>
        <th scope="col">Enroll</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($courses as $course): ?>
        <tr>
            <td><?php echo $course['name'] ?></td>
            <td><?php echo $course['start'] ?></td>
            <td><?php echo $course['end'] ?></td>
            <td>
            <form action="/enroll" method="post" class="ajax-form">
                <input hidden type="number" class="btn btn-primary" name="course_id" value=<?php echo $course['id'] ?>>
                <input type="submit" class="btn btn-primary" value="submit">
                <div class="invalid-feedback"></div>
            </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

