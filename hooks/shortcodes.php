<?php

use Illuminate\Support\Arr;

#
#   Shortcodes
#


#   Students
add_shortcode('axcelerate_students', function () {

    $students = axcelerate_students();

    if (!$students) { ?>
        <div class="alert alert-danger" role="alert">
            Oops! API connection error.
        </div><?php
        return;
    }

    foreach ($students as $student) {
        $student->ENROLMENTS = $student->CUSTOMFIELD_URLFIELD ? 'YES' : 'NO';
    } ?>

    <form action="/students">
        <div class="row g-3 align-items-center mt-5">
            <div class="col-auto">
                <label class="col-form-label">Search</label>
            </div>
            <div class="col-auto">
                <input type="text" class="form-control" name="keyword" value="<?= $_GET['keyword'] ?>">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">GO</button>
            </div>
        </div>
    </form>

    <div class="row gx-4 gy-4 mt-3">
        <?php foreach ($students as $student) : ?>
            <div class="col-4">
                <div class="card w-100 shadow h-100">
                    <div class="card-body bg-primary text-light">
                        <h5 class="card-title"><?= $student->GIVENNAME ?></h5>
                        <p class="card-text"><?= $student->COMMENT ?></p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><b>ID:</b> <?= $student->CONTACTID ?></li>
                        <li class="list-group-item"><b>Position:</b> <?= $student->POSITION ?></li>
                        <li class="list-group-item"><b>Email:</b> <?= $student->EMAILADDRESS ?></li>
                        <li class="list-group-item <?= ($student->ENROLMENTS == 'YES') ? 'active' : '' ?>"><b>Enrolments:</b> <?= $student->ENROLMENTS ?></li>
                    </ul>
                    <div class="card-body">
                        <a href="/student/<?= $student->CONTACTID ?>" class="btn btn-primary">View</a>
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

    if (!$student) { ?>
        <div class="alert alert-danger" role="alert">
            Oops! API connection error.
        </div><?php
                return;
            }

            $student->ENROLMENTS = axcelerate_query('contact/enrolments/' . $student_id); ?>

    <div class="row gx-4 gy-4 mt-3">
        <div class="col-4">
            <div class="card w-100">
                <div class="card-body">
                    <h4 class="card-title"><?= $student->GIVENNAME ?></h4>
                    <p class="card-text"><?= $student->COMMENT ?></p>
                </div>
                <ul class="list-group list-group-flush">
                    <?php foreach ($student as $key => $data) :
                        if (!$data) {
                            continue;
                        }
                    ?>
                        <li class="list-group-item"><b><?= $key ?>:</b> <?= $data ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="col-8">
            <?php if ($student->CUSTOMFIELD_URLFIELD) : ?>
                <h2 class="mt-5">Enrolments & Certificates</h2>
                <div class="row gx-3 gy-3 mt-3">
                    <?php foreach ($student->ENROLMENTS as $enrolment) : ?>
                        <div class="col-6">
                            <div class="card w-100 shadow h-100 rounded-3" style="overflow:hidden;">
                                <div class="card-body bg-primary text-light">
                                    <h5 class="card-title"><?= $enrolment->NAME ?></h5>
                                    <p class="card-text"><?= $enrolment->ACTIVITYTYPE ?></p>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><b>ID:</b> <?= $enrolment->ENROLID ?></li>
                                    <li class="list-group-item"><b>Commenced Date:</b> <?= $enrolment->COMMENCEDDATE ?></li>
                                    <li class="list-group-item"><b>Status:</b> <?= $enrolment->STATUS ?></li>
                                </ul>
                                <?php if ($enrolment->STATUS == "Completed") : ?>
                                    <div class="card-body">
                                        <a href="/certificate/<?= $enrolment->ENROLID ?>" class="btn btn-primary w-100">Certificate</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <h2 class="mt-5">No Enrolments & Certificates</h2>
            <?php endif; ?>
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
                <?php if ($org->HTMLBADGE) : ?>
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

            <?php if (!empty($org->KEYCONTACTS)) : ?>
                <h2 class="mt-5">Contacts</h2>

                <?php foreach ($org->KEYCONTACTS as $k => $contact) : ?>
                    <ul class="list-group mb-3">
                        <li class="list-group-item active" aria-current="true">
                            <?= $contact->GIVENNAME . ' ' . $contact->SURNAME ?>
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



#   Certificate
add_shortcode('axcelerate_certificate', function () {
    $id = get_query_var('certID');

    $certificate = axcelerate_query('contact/enrolment/certificate?enrolID=' . $id); ?>

    <?php if ($certificate->ERROR) : ?>
        <div class="alert alert-danger" role="alert">
            <?= $certificate->MESSAGES ?>
        </div>
    <?php elseif ($certificate == false) : ?>
        <div class="alert alert-danger" role="alert">
            API connection error!
        </div>
    <?php else : ?>
        <?php
        dump($certificate);
        ?>
<?php endif;
});
