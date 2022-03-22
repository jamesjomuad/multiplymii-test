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
                        <li class="list-group-item"><b>ID:</b> <?= $contact->CONTACTID ?></li>
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
        <div class="col-4">
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
        <div class="col-8">
            <?php if( $student->CUSTOMFIELD_URLFIELD ) : ?>
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
                                <?php if($enrolment->STATUS=="Completed") : ?>
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



#   Certificate
add_shortcode('axcelerate_certificate', function(){
    $id = get_query_var('certID');

    $certificate = axcelerate_query('contact/enrolment/certificate?enrolID='.$id);

    dump([
        'id' => $id,
        'cert' => $certificate
    ]); ?>

    <div class="alert alert-danger" role="alert">
        A simple danger alert—check it out!
    </div>

    <?php
});