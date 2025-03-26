<?php

use backend\modules\contracts\models\Contracts;
use yii\helpers\Html;
use yii\helpers\Url;
?>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">نص الرسالة</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="phone_number" value="0">
                <textarea id="sms_text" name="sms_text" rows="4" cols="50"></textarea>

                <label for="sms_text">عدد الاحرف :</label>
                <div id="char_count">0</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="send_sms" data-dismiss="modal">Send</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="changeStatse" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> تغيير حالة العقد</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <select class="status-content">
                    <option value="pending"> Pending</option>
                    <option value="active"> Active</option>
                    <option value="reconciliation"> Reconciliation</option>
                    <option value="judiciary"> Judiciary</option>
                    <option value="canceled"> Canceled</option>
                    <option value="refused"> Refused</option>
                    <option value="legal_department"> Legal Department</option>
                    <option value="finished"> finished</option>
                    <option value="settlement"> settlement</option>

                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary statse-change" contract-id="<?= $contractCalculations->contract_model->id ?>">
                    Save changes
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle2">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="exampleModal12" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel12" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel12"></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
                        <label>الاسم</label>
                        <input type="text" class="cu-name" disabled>
                    </div>
                    <div class="col-lg-6">
                        <label>الرقم الوطني</label>
                        <input type="text" class="cu-id-number" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label>تاريخ الميلاد</label>
                        <input type="text" class="cu-birth-date" disabled>
                    </div>
                    <div class="col-lg-6">
                        <label>مدينة الميلاد</label>
                        <input type="text" class="cu-city" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label>الجنس</label>
                        <input type="text" class="cu-sex" disabled>
                    </div>
                    <div class="col-lg-6">
                        <label> الوظيفه</label>
                        <input type="text" class="cu-job-title" disabled>
                    </div>


                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label> الرقم الوظيفي</label>
                        <input type="text" class="cu-job-number" disabled>
                    </div>
                    <div class="col-lg-6">
                        <label>البريد الالكتروني</label>
                        <input type="text" class="cu-email" disabled>
                    </div>


                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label>اسم البنك</label>
                        <input type="text" class="cu-bank-name" disabled>
                    </div>
                    <div class="col-lg-6">
                        <label>رقم الحساب</label>
                        <input type="text" class="cu-account-number" disabled>
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label>فرع بنك</label>
                        <input type="text" class="cu-bank-branch" disabled>
                    </div>
                    <div class="col-lg-6">
                        <label>مشترك بالضمان</label>
                        <input type="text" class="cu-is-social-security" disabled>
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label>رقم الضمان الاجتماعي</label>
                        <input type="text" class="cu-social-security-number" disabled>
                    </div>
                    <div class="col-lg-6">
                        <label>لديه املاك</label>
                        <input type="text" class="cu-do-have-any-property" disabled>
                    </div>
                    <div class="col-lg-6">
                        <label>كيف سمعت عنا</label>
                        <input type="text" class="cu-hear-about-us" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <label> ملاحظات</label>
                        <textarea class="cu-notes" disabled></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a class="btn btn-primary" id="cus-link">Edit</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div id='display' ondblclick='copyText(this)'>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <br>
                    <h2 class="modal-title" id="exampleModalLabel" style="text-align: right"> تدقيق عقد رقم
                        : <?= $contract_id ?></h2>
                </div>
                <div class="modal-body">
                    <div>
                        <div style="text-align: right">
                            <h3>:معلومات العملاء</h3>
                            <?php
                            $custamer = contracts::findOne($contract_id)->customersAndGuarantor;
                            foreach ($custamer

                                as $custamers) {
                            ?> : العميل <?= $custamers->name ?> -
                                <br>
                                صاحب الرقم الوطني : <?= $custamers->id_number ?>
                                <br>
                                المدينه:
                                :<?php if (!empty($custamers->city)) {
                                        $custamer_city = \backend\modules\city\models\City::findOne(['id' => $custamers->city]);
                                        echo $custamer_city->name;
                                    } else {
                                        echo '  لا يوجد';
                                    }
                                    ?>

                                <br>
                                <bre>
                                    العمل :<?php if (!empty($custamers->job_title)) {
                                                $jod = \backend\modules\jobs\models\Jobs::findOne(['id' => $custamers->job_title]);
                                                echo $jod->name;
                                            } else {
                                                echo 'لا يوجد';
                                            }; ?>
                                <?php
                                $address = \backend\modules\address\models\Address::find()->where(['customers_id' => $custamers->id])->all();
                                echo '  <h5>: عناوين ' . '  ';
                                echo $custamers->name . '  </h5>';
                                if (!empty($address)) {
                                    foreach ($address as $addressHome) {
                                        echo "<br>";
                                        echo ($addressHome->address_type == 1) ? 'مكان العمل:  ' : '   مكان السكن:  ';
                                        echo !empty($addressHome->address) ? $addressHome->address : 'لا يوجد';
                                        echo "<br>";
                                        echo "  نوع العنوان : ";
                                        echo !empty($addressHome->address_type) ? ($addressHome->address_type == 1) ? 'عنوان العمل' : 'عنوان السكن' : 'لا يوجد';
                                        echo "<br>";
                                    }
                                }
                            } ?>
                        </div>
                        <div style="text-align: right">
                            <h3>المعرفين</h3>
                            <?php
                            $result = Contracts::findOne($contract_id);
                            if (!empty($result)) {
                                foreach ($result->contractsCustomers as $key => $value) {
                                    foreach ($value->customer->phoneNumbers as $phoneNumbers) {
                                        echo "الاسم: ";
                                        echo $phoneNumbers->owner_name;
                                        echo " ,صلة القرابه:  ";
                                        $relation = \backend\modules\cousins\models\Cousins::findOne($phoneNumbers->phone_number_owner);
                                        echo $relation->name;
                                        echo "-";
                                        echo "<br>";
                                        echo "<br>";
                                    }
                                }
                            }
                            ?>
                        </div>
                        <div style="text-align: right">
                            <?php
                            $judicarys = backend\modules\judiciary\models\Judiciary::find()->where(['contract_id' => $contract_id])->all();
                            if (!empty($judicarys)) {
                                echo "  <h3>:المعلومات القضائية</h3>";
                                foreach ($judicarys as $judicary) {
                                    echo ":معلومات القضية رقم ";
                                    echo (!empty($judicary->judiciary_number)) ? (!empty($judicary->year)) ? $judicary->judiciary_number . '/' . $judicary->year : '' : '';
                                    echo "-";

                                    echo "<br>";
                                    echo "تاريخ الورود :";
                                    echo (!empty($judicary->income_date)) ? $judicary->income_date : 'لا يوجد';

                                    echo "<br>";
                                    $lawyer = \backend\modules\lawyers\models\Lawyers::findOne(['id' => $judicary->lawyer_id]);
                                    if (!empty($lawyer)) {
                                        echo ' المحامي:  ';
                                        echo (!empty($lawyer->name)) ? $lawyer->name : 'لا يوجد';
                                    }
                                    echo "</br>";
                                    $court = \backend\modules\court\models\Court::findOne(['id' => $judicary->court_id]);
                                    if (!empty($court)) {
                                        echo ' المحكمة:  ';
                                        echo (!empty($court->name)) ? $court->name : 'لا يوجد';
                                    }
                                    echo "<br>";
                                    echo "<br>";
                                }
                            }
                            ?>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                $custamers_image = \backend\modules\imagemanager\models\Imagemanager::find()->innerJoin('os_contracts_customers', 'os_contracts_customers.customer_id = os_ImageManager.contractId')->where(['groupName' => 'coustmers'])->andWhere(['os_contracts_customers.contract_id' => $contractCalculations->contract_model->id])->all();
                $custmer_document_images = \backend\modules\customers\models\CustomersDocument::find()->innerJoin('os_contracts_customers', 'os_contracts_customers.customer_id = os_customers_document.customer_id')->andWhere(['os_contracts_customers.contract_id' => $contractCalculations->contract_model->id])->all();
                if (empty($custmer_document_images)) {
                    echo "لم يتم العثور على نتائج";
                    echo "<br/>";
                } else {
                    foreach ($custmer_document_images as $image) {
                        if ($image->images != 0) {
                            echo '<div class="col-lg-4">';
                            echo Html::img(Url::to(['/images/imagemanager/' . $image->images]), ['style' => 'width:100px;height:100px; object-fit: contain; margin: 20px', 'class' => 'img img-circle']);
                            echo '</div>';
                        } else {
                            echo "";
                        }
                    }
                    foreach ($custmer_document_images as $image) {
                        if ($image->images != 0) {
                            echo ' <div class="col-lg-4">';
                            echo "<center>";
                            switch ($image->document_number) {
                                case 0:
                                    echo "هوية";
                                    break;
                                case 1:
                                    echo 'جواز سفر';
                                    break;
                                case 2:
                                    echo 'رخصة';
                                    break;
                                case 3:
                                    echo 'شهادة ميلاد';
                                    break;
                                default:
                                    echo ' شهادة تعيين';
                            }
                            echo "</center>";
                            echo '</div>';
                        } else {
                            echo "";
                        }
                    }
                }

                if (empty($custamers_image)) {
                    echo "لم يتم العثور على  وثائق اخرى";
                } else {
                    foreach ($custamers_image as $image) {
                        $imagePath = \Yii::$app->imagemanager->getImagePath($image->id);
                        echo "<image src ='{$imagePath}' style = 'width:100px;height:100px; object-fit: contain; margin: 20px' class = 'img img-circle' />";
                    }
                }

                ?>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="tas" tabindex="-1" role="dialog" aria-labelledby="tasc" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="tasc" style="text-align: right">اضافة تسوية</h3>
            </div>
            <div class="modal-body">
                <div class="alert alert-info loan-alert" style="display: none">
                </div>
                <div>
                    <div class="row">
                        <form>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="monthly_installment">القسط الشهري</label>
                                    <input type="text" class="form-control" id="monthly_installment" aria-describedby="emailHelp" placeholder="القسط الشهري">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="new_installment_date">تاريخ اول دفعة</label>
                                    <input type="date" class="form-control" id="new_installment_date" aria-describedby="emailHelp" placeholder="تاريخ النسويه">
                                </div>
                            </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="first_installment_date">تاريخ النسويه</label>
                                <input type="date" class="form-control" id="first_installment_date" aria-describedby="emailHelp" placeholder="تاريخ اول دفعة">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" value='<?= $contractCalculations->contract_model->id ?>' id="contract_id">
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id='closeModel'>الغاء</button>
                <button type="button" class="btn btn-primary" id="save">حفظ التغييرات</button>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-12 " style="text-align: right">
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div id='display' ondblclick='copyText(this)'>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <br>
                    <h2 class="modal-title" id="exampleModalLabel" style="text-align: right"> تدقيق عقد رقم
                        : <?= $contract_id ?></h2>
                </div>
                <div class="modal-body">
                    <div>
                        <div style="text-align: right">
                            <h3>:معلومات العملاء</h3>
                            <?php
                            $custamer = contracts::findOne($contract_id)->customersAndGuarantor;
                            foreach ($custamer
                                as $custamers) {
                            ?> : العميل <?= $custamers->name ?> -
                                <br>
                                صاحب الرقم الوطني : <?= $custamers->id_number ?>
                                <br>
                                المدينه:
                                :<?php if (!empty($custamers->city)) {
                                        $custamer_city = \backend\modules\city\models\City::findOne(['id' => $custamers->city]);
                                        echo $custamer_city->name;
                                    } else {
                                        echo '  لا يوجد';
                                    }
                                    ?>
                                <br>
                                <bre>
                                    العمل :<?php if (!empty($custamers->job_title)) {
                                                $jod = \backend\modules\jobs\models\Jobs::findOne(['id' => $custamers->job_title]);
                                                echo $jod->name;
                                            } else {
                                                echo 'لا يوجد';
                                            }; ?>
                                <?php
                                $address = \backend\modules\address\models\Address::find()->where(['customers_id' => $custamers->id])->all();
                                echo '  <h5>: عناوين ' . '  ';
                                echo $custamers->name . '  </h5>';
                                if (!empty($address)) {
                                    foreach ($address as $addressHome) {
                                        echo "<br>";
                                        echo ($addressHome->address_type == 1) ? 'مكان العمل:  ' : '   مكان السكن:  ';
                                        echo !empty($addressHome->address) ? $addressHome->address : 'لا يوجد';
                                        echo "<br>";
                                        echo "  نوع العنوان : ";
                                        echo !empty($addressHome->address_type) ? ($addressHome->address_type == 1) ? 'عنوان العمل' : 'عنوان السكن' : 'لا يوجد';
                                        echo "<br>";
                                    }
                                }
                            } ?>
                        </div>
                        <div style="text-align: right">
                            <h3>المعرفين</h3>
                            <?php
                            $result = Contracts::findOne($contract_id);
                            if (!empty($result)) {
                                foreach ($result->contractsCustomers as $key => $value) {
                                    foreach ($value->customer->phoneNumbers as $phoneNumbers) {
                                        echo "الاسم: ";
                                        echo $phoneNumbers->owner_name;
                                        echo " ,صلة القرابه:  ";
                                        $relation = \backend\modules\cousins\models\Cousins::findOne($phoneNumbers->phone_number_owner);
                                        echo $relation->name;
                                        echo "-";
                                        echo "<br>";
                                        echo "<br>";
                                    }
                                }
                            }
                            ?>
                        </div>
                        <div style="text-align: right">
                            <?php
                            $judicarys = backend\modules\judiciary\models\Judiciary::find()->where(['contract_id' => $contract_id])->all();
                            if (!empty($judicarys)) {
                                echo "  <h3>:المعلومات القضائية</h3>";
                                foreach ($judicarys as $judicary) {
                                    echo ":معلومات القضية رقم ";
                                    echo (!empty($judicary->judiciary_number)) ? (!empty($judicary->year)) ? $judicary->judiciary_number . '/' . $judicary->year : '' : '';
                                    echo "-";
                                    echo "<br>";
                                    echo "تاريخ الورود :";
                                    echo (!empty($judicary->income_date)) ? $judicary->income_date : 'لا يوجد';
                                    echo "<br>";
                                    $lawyer = \backend\modules\lawyers\models\Lawyers::findOne(['id' => $judicary->lawyer_id]);
                                    if (!empty($lawyer)) {
                                        echo ' المحامي:  ';
                                        echo (!empty($lawyer->name)) ? $lawyer->name : 'لا يوجد';
                                    }
                                    echo "</br>";
                                    $court = \backend\modules\court\models\Court::findOne(['id' => $judicary->court_id]);
                                    if (!empty($court)) {
                                        echo ' المحكمة:  ';
                                        echo (!empty($court->name)) ? $court->name : 'لا يوجد';
                                    }
                                    echo "<br>";
                                    echo "<br>";
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>