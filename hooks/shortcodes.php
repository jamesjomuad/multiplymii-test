<?php

use Illuminate\Support\Arr;

#
#   Shortcodes
#


#   Students
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


#   Student Details
add_shortcode('axcelerate_student', function () {

    $student_id = get_query_var('studentID');

    $student = axcelerate_student($student_id);

?>

    <div class="row gx-4 gy-4 mt-3">
        <div class="col-12 d-flex flex-fill">
            <div class="card w-100">
                <div class="card-body">
                    <h4 class="card-title"><?= $student->GIVENNAME ?></h4>
                    <p class="card-text"><?= $student->COMMENT ?></p>
                </div>
                <ul class="list-group list-group-flush">
                    <?php foreach ($student as $key => $data) : ?>
                        <li class="list-group-item"><b><?= $key ?>:</b> <?= $data ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
<?php
});


#   Organisations
add_shortcode('axcelerate_organisations', function () {

    $lists = axcelerate_query('organisations');
?>

    <div class="row gx-4 gy-4 mt-3">
        <?php foreach ($lists as $list) : ?>
            <div class="col-4">
                <div class="card w-100">
                    <div class="card-body">
                        <h5 class="card-title"><?= $list->NAME ?></h5>
                        <p class="card-text"><?= $list->LEGALNAME ?></p>
                    </div>
                    <div class="card-body">
                        <a href="/organisation/<?= $list->ORGID ?>" class="btn btn-primary">More Details</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php
});



#   Organisations Details
add_shortcode('axcelerate_organisation', function () {

    $id = get_query_var('orgID');

    $org = axcelerate_query('organisation/' . $id);
?>

    <div class="row gx-4 gy-4 mt-3 justify-content-center">
        <div class="col-12">
            <div class="card w-100">
                <?php if($org->HTMLBADGE) : ?>
                <img src="<?= $org->HTMLBADGE ?>" class="card-img-top" alt="<?= $org->NAME ?>" style=" object-fit: none; 
                object-position: center; ">
                <?php endif; ?>

                <div class="card-body">
                    <h4 class="card-title"><?= $org->NAME ?></h4>
                    <p class="card-text"><?= $org->LEGALNAME ?></p>
                </div>
                <?php if (isset($org->DETAILS[0])) : ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($org->DETAILS[0] as $key => $data) : ?>
                            <li class="list-group-item"><b><?= $key ?>:</b> <?= $data ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>

            <?php if( !empty($org->KEYCONTACTS) ) : ?>
                <h2 class="mt-5">Contacts</h2>

                <?php foreach($org->KEYCONTACTS as $k=>$contact) : ?>
                    <ul class="list-group mb-3">
                        <li class="list-group-item active" aria-current="true">
                            <?= $contact->GIVENNAME.' '.$contact->SURNAME ?>
                        </li>
                        <li class="list-group-item">EMAIL: <?= $contact->EMAIL ?></li>
                        <li class="list-group-item">POSITION: <?= $contact->POSITION ?></li>
                        <li class="list-group-item">MOBILEPHONE: <?= $contact->MOBILEPHONE ?></li>
                    </ul>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <?php
});
