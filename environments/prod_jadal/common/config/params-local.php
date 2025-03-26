<?php
return [
    /* sms information*/
    'sender'=>'JADAL',
    'user'=>'jadalSMS',
    'pass'=>'18409245',
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'user.passwordResetTokenExpire' => 3600,
    'lawyer_type'=>[Yii::t('app','agent'),Yii::t('app','authorized')],
    /*key name for cach*/
    'key_customers' => "key_customers",
    'key_income_by' => "key_income_by",
    'key_users' => "key_users",
    'key_company' => "key_company",
    'key_company_name' => "key_company_name",
    'key_payment_type' => "key_payment_type",
    'key_income_category' => "key_income_category",
    'key_document_number' => "document_number",
    'key_contract_id' => "contract_id",
    'key_contract_status' => "contract_status",
    'key_expenses_contract' => "expenses_contract",
    'key_loan_contract' => "loan_contract",
    'key_status' => "status",
    'key_expenses_category' => "expenses_category",
    'key_court' => "court",
    'key_judiciary_type' => "judiciary_type",
    'key_lawyer' => "lawyer",
    'key_judiciary_contract' => "judiciary_contract",
    'key_judiciary_year' => "judiciary_year",
    'key_customers_name' => 'customers_name',
    'key_city' => 'city',
    'key_jobs' => 'jobs',
    'key_citizen' => 'citizen',
    'key_hear_about_us' => 'hear_about_us',
    'key_banks' => 'banks',
    'key_job_title' => 'job_title',
    'key_jobs_type' => 'jobs_type',
    'key_judiciary_actions' => 'judiciary_actions',
    'key_contract_customers' => 'contract_customer',
    'key_company_bank_id' => 'company_bank_',
    'key_job_type' => 'job_type',
    'job_type_query' => 'SELECT id , name FROM {{%jobs_type}}',
    /*query  for cach*/
    'court_query' => 'SELECT id , name FROM {{%court}}',
    'customers_query' => 'SELECT id , name FROM {{%customers}}',
    'customers_name_query' => 'SELECT  name FROM {{%customers}}',
    'users_query' => 'SELECT id , username FROM {{%user}}',
    'payment_type_query' => 'SELECT id , name FROM {{%payment_type}}',
    'income_by_query' => 'SELECT id ,_by FROM {{%income}}',
    'company_query' => 'SELECT id , name FROM {{%companies}}',
    'company_name_query' => 'SELECT name FROM {{%companies}}',
    'status_query' => 'SELECT id,name FROM {{%status}}',
    'city_query' => 'SELECT id,name FROM {{%city}}',
    'jobs_query' => 'SELECT id,name FROM {{%jobs}}',
    'contract_status_query' => 'SELECT status FROM {{%contracts}}',
    'citizen_query' => 'SELECT id,name FROM {{%citizen}}',
    'hear_about_us_query' => 'SELECT id,name FROM {{%hear_about_us}}',
    'banks_query' => 'SELECT id,name FROM {{%bancks}}',
    'income_category_query' => 'SELECT id,name FROM {{%income_category}}',
    'payment_type_query' => 'SELECT id,name FROM {{%payment_type}}',
    'document_number_query' => 'SELECT document_number FROM {{%financial_transaction}}',
    'income_category_query' => 'SELECT id ,name FROM {{%income_category}}',
    'expenses_contract_query' => 'SELECT contract_id FROM {{%expenses}}',
    'contract_id_query' => 'SELECT id FROM {{%contracts}}',
    'expenses_category_query' => 'SELECT id , name FROM {{%expense_categories}}',
    'status_query' => 'SELECT id , name FROM {{%status}}',
    'judiciary_type_query' => 'SELECT id , name FROM {{%judiciary_type}}',
    'lawyer_query' => 'SELECT id , name FROM {{%lawyers}}',
    'judiciary_contract_query' => 'SELECT contract_id FROM {{%judiciary}}',
    'judiciary_year_query' => 'SELECT year FROM {{%judiciary}}',
    'job_title_query' => 'SELECT id, name FROM {{%jobs}}',
    'jobs_type_query' => 'SELECT id, name FROM {{%jobs_type}}',
    'judiciary_actions_query' => 'SELECT id , name FROM {{%judiciary_actions}}',
    'contract_customers_query' => 'SELECT * FROM {{%contracts_customers}}',
    'company_bank_id_query' => 'SELECT bank_id FROM  {{%company_banks}}',
    /*duration time for cach*/
    'time_duration' => 31536000,
    'socialSecuritySources' => [
        'social_security' => 'الضمان الاجتماعي',
        'retirement_directorate' => 'مديرية التقاعد المدني والعسكري',
        'both' => 'كلاهما',
    ],
];
