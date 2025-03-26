<?php

namespace common\helper;

use Yii;
//Yii::$app->user->can('مدير')
class Permissions
{

    const CUSTOMERS = 'العملاء';
    const ROUTE = 'الجذر';
    const ASSIGNMENT = 'اسناد الصلاحيات  للموظفين';
    const ROLE = 'القواعد';
    const PERMISSION = 'الصلاحيات';
    const LOAN_SCHEDULING = 'التسويات الماليه';
    const EXPENSES = 'المصاريف';
    const FINANCIAL_TRANSACTION = 'الحركات المالية';
    const EXPENSE_CATEGORIES = 'فئات المصايف';
    const EMPLOYEE = 'الموظفين';
    const INCOME = 'الدخل';
    const FOLLOW_UP_REPORT = 'تقرير المتابعة';
    const CONTRACTS = 'العقود';
    const INVENTORY_ITEMS = 'عناصر المخزون';
    const INVENTORY_STOCK_LOCATIONS = 'مواقع المخزون';
    const INVENTORY_SUPPLIERS = 'موردي المخزون';
    const COMPANIES = 'الشركات';
    const INVENTORY_ITEMS_QUANTITY = 'كمية عناصر المخزون';
    const TRANSFER_TO_LEGAL_DEPARTMENT = 'التحويل إلى الدائره القانونية';
    const LAWYERS = 'المحامون';
    const COURT = 'المحاكم';
    const JUDICIARY_TYPE = 'انواع القضايا';
    const JUDICIARY = 'القضاء';
    const JUDICIARY_ACTION = 'الإجراءات القضائية';
    const JUDICIARY_CUSTOMERS_ACTION = 'إجراءات العملاء القضائية';
    const Notification = 'الاشعارات';
    const HOLIDAYS = 'العطل';
    const LEAVE_POLICY = 'سياسات الاجازات';
    const LEAVE_TYPES = 'أنواع الإجازات';
    const WORKDAYS = 'أيام العمل';
    const  LEAVE_REQUEST = 'طلب إجازة';
    const  ARCHEVE = 'أرشيف';
    const  DOCUMENT_HOLDER = 'حامل الوثيقة';
    const  MANAGER = 'الاداره';
    const  JOBS = 'الوظائف';
    const  DETERMINATION = 'تحديد';
    const  COLLECTION = 'الحسميات';
    const COMPAINES = 'المستثمرين';
    const REPORTS = 'التقارير';
    const STATUS = 'الحالات';
    const COUSINS = 'الاقارب';
    const CITIZEN = 'الجنسيه';
    const BANCKS = 'البنوك';
    const HEAR_ABOUT_US = 'كيف سمعت عنا';
    const CITY = 'المدن';
    const PAYMENT_TYPE = 'طرق الدفع';
    const FEELINGS = 'الانفعالات';
    const CONTACT_TYPE = 'طريقة الاتصال';
    const CONNECTION_RESPONSE = 'نتيجة الاتصال';
    const  DOCYUMENT_TYPE = 'انواع الوثائق';
    const Document_STATUS = 'حالات الوثائق';
    const INVENTORY_INVOICES = 'فواتير المخزون';
    const INVENTORY_IEMS_QUERY = 'استعلام عناصر المخزون';
    const FINANCIAL_TRANSACTION_TO_EXPORT_DATA = 'الحركات المالية لتصدير ونقل البيانات';
    const COLLECTION_MANAGER = 'مدير التحصيل';
    const JUDICIARY_INFORM_ADDRESS = 'الموطن المختار';

    public static function hasPermissionOn($permission)
    {
        $permission = is_array($permission) ? $permission : [$permission];
        $hasPermission = true;
        foreach ($permission as $key => $permissionName) {
            if (!Yii::$app->user->can($permissionName)) {
                $hasPermission = false;
                break;
            }
        }
        return $hasPermission;
    }

    public static function checkMainMenuItems($items)
    {
        foreach ($items as $key => $menuItem) {
            if (isset($menuItem['privilege']) && !Permissions::hasPermissionOn($menuItem['privilege'])) {
                unset($items[$key]);
            }

            if (isset($menuItem['items'])) {
                $items[$key]['items'] = self::checkMainMenuItems($menuItem['items']);
            }

            if ((!isset($menuItem['privilege']) && !isset($menuItem['items'])) || (isset($menuItem['items']) && count($menuItem['items']) == 0)) {
                unset($items[$key]);
            }
        }
        return $items;
    }
}