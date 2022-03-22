<?php

use Illuminate\Support\Arr;

#
#   Shortcodes
#
add_shortcode('axcelerate_students', function () {

    $contacts = axcelerate_students(); ?>

    <div class="row gx-4 gy-4 mt-3">
        <?php foreach ($contacts as $contact) : ?>
            <div class="col-4">
                <div class="card w-100">
                    <div class="card-body">
                        <h5 class="card-title"><?= $contact->GIVENNAME ?></h5>
                        <p class="card-text"><?= $contact->COMMENT ?></p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><b>Position:</b> <?= $contact->POSITION ?></li>
                        <li class="list-group-item"><b>Email:</b> <?= $contact->EMAILADDRESS ?></li>
                    </ul>
                    <div class="card-body">
                        <a href="/student/<?= $contact->CONTACTID ?>" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
});

add_shortcode('axcelerate_student', function () {

    $student_id = get_query_var('studentID');

    $student = axcelerate_student($student_id);

    dump(
        $student
    );

    ?>

    <div class="row gx-4 gy-4 mt-3">
        <div class="col-12 d-flex flex-fill">
            <div class="card w-100">
                <div class="card-body">
                    <h5 class="card-title"><?= $student->GIVENNAME ?></h5>
                    <p class="card-text"><?= $student->COMMENT ?></p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Position: <?= $student->POSITION ?></li>
                    <li class="list-group-item">Email: <?= $student->EMAILADDRESS ?></li>
                </ul>
                <div class="card-body">
                    <a href="/student/<?= $student->CONTACTID ?>" class="btn btn-primary">More</a>
                </div>
            </div>
        </div>
    </div>
    <?php
});