<?php
use yii\widgets\Breadcrumbs;

?>
<!-- start page content wrapper-->
<div class="page-content-wrapper">
    <!-- start page content-->
    <div class="page-content">
        <!--start breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <!--   <div class="breadcrumb-title pe-3">Tables</div>-->
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0 align-items-center">
                        <li class="breadcrumb-item "><a href="javascript:;"><ion-icon name="home-outline"></ion-icon></a>
                        </li>
                        <!-- <li class="breadcrumb-item active" aria-current="page">Data Table</li>-->
                        <ol class="breadcrumb">
                            <?php

                            echo Breadcrumbs::widget([
                                'itemTemplate' => "<li class=\"breadcrumb-item active\" aria-current=\"page\"></li>", // template for all links
                                'links' => [
                                    [
                                        'label' =>$this->title,
                                        'url' => [''],
                                        'template' => "<li class='breadcrumb-item active padding' aria-current=\"page\">{link}</li>\n", // template for this link only
                                    ],

                                ],
                            ]);
                            ?>
                        </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-primary">Settings</button>
                    <button type="button" class="btn btn-outline-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">	<span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">	<a class="dropdown-item" href="javascript:;">Action</a>
                        <a class="dropdown-item" href="javascript:;">Another action</a>
                        <a class="dropdown-item" href="javascript:;">Something else here</a>
                        <div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Separated link</a>
                    </div>
                </div>
            </div>
        </div>
        <!--end breadcrumb-->




          <?= $content;?>

    </div>
    <!-- end page content-->
</div>




<!--Start Back To Top Button-->
<a href="javaScript:;" class="back-to-top"><ion-icon name="arrow-up-outline"></ion-icon></a>
<!--End Back To Top Button-->
