<?php


use SendGrid\Mail\Mail;

class Adpc
{
    const SETTINGS_SECTION_CAP_RATE = 'adpc_cap_rate';
    const SETTINGS_PAGE = 'adpc_settings';
    const OPTION_CLASS_A_MIN = 'class_a_min';
    const OPTION_CLASS_B_MIN = 'class_b_min';
    const OPTION_CLASS_C_MIN = 'class_c_min';
    const OPTION_CLASS_A_CAP_RATE = 'class_a_cap_rate';
    const OPTION_CLASS_B_CAP_RATE = 'class_b_cap_rate';
    const OPTION_CLASS_C_CAP_RATE = 'class_c_cap_rate';
    const OPTION_CLASS_D_CAP_RATE = 'class_d_cap_rate';
    const OPTION_CLASS_A_MAX_AGE = 'class_a_max_age';
    const OPTION_CLASS_B_MAX_AGE = 'class_b_max_age';
    const OPTION_CLASS_B_MIN_AGE = 'class_b_min_age';
    const OPTION_CLASS_C_MAX_AGE = 'class_c_max_age';
    const OPTION_CLASS_C_MIN_AGE = 'class_c_min_age';
    const OPTION_CLASS_D_MIN_AGE = 'class_d_min_age';
    const OPTION_SENDGRID_KEY = 'sendgrid_key';
    const TABLE_LEADS = 'adpc_leads';

    const OPTION_DEFAULT_CLASS_A_MIN = 100000;
    const OPTION_DEFAULT_CLASS_B_MIN = 60000;
    const OPTION_DEFAULT_CLASS_C_MIN = 40000;
    const OPTION_DEFAULT_CLASS_A_CAP_RATE = 0.045;
    const OPTION_DEFAULT_CLASS_B_CAP_RATE = 0.0475;
    const OPTION_DEFAULT_CLASS_C_CAP_RATE = 0.07;
    const OPTION_DEFAULT_CLASS_D_CAP_RATE = 0.095;
    const OPTION_DEFAULT_CLASS_A_MAX_AGE = 20;
    const OPTION_DEFAULT_CLASS_B_MAX_AGE = 45;
    const OPTION_DEFAULT_CLASS_B_MIN_AGE = 15;
    const OPTION_DEFAULT_CLASS_C_MAX_AGE = 60;
    const OPTION_DEFAULT_CLASS_C_MIN_AGE = 43;
    const OPTION_DEFAULT_CLASS_D_MIN_AGE = 60;

    public static function addLead($zip, $units, $rent, $age, $value)
    {
        global $wpdb;
        $table = $wpdb->prefix . self::TABLE_LEADS;
        $data = [
            'zip' => $zip,
            'units' => $units,
            'rent' => $rent,
            'age' => $age,
            'property_value' => $value
        ];
        $format = ['%s', '%s', '%s', '%s', '%s'];
        $wpdb->insert($table, $data, $format);

        return $wpdb->insert_id;
    }

    public static function updateLead(string $leadId, string $name, string $email, $addressLine)
    {
        global $wpdb;
        $table = $wpdb->prefix . self::TABLE_LEADS;
        $data = [
            'the_name' => $name,
            'email' => $email,
            'address_line' => $addressLine,
        ];
        $where = [
            'id' => $leadId
        ];
        $wpdb->update($table, $data, $where);
    }

    public static function getLead($id)
    {
        global $wpdb;
        $table = $wpdb->prefix . self::TABLE_LEADS;
        $records = $wpdb->get_results("select * from $table where id = $id");
        return reset($records);
    }

    public static function sendEmail($leadId)
    {
        require_once ADPC_PLUGIN_DIR . '/lib/Emailer.php';
        $lead = self::getLead($leadId);
        $from = new \SendGrid\Mail\From('info@k-madduxinvestments.com', 'Maddux Investments');
        $to = new \SendGrid\Mail\To(
            $lead->email,
            $lead->the_name,
            [
                'name' => $lead->the_name,
                'address' => $lead->zip,
                'property_value' => $lead->property_value
            ]
        );
        $email = new Mail(
            $from,
            $to
        );
        $email->setTemplateId(Emailer::TEMPLATE_ID);

        $sendgrid = new SendGrid(
            Emailer::API_KEY,
            [
                'curl' => [
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_SSL_VERIFYPEER => false,
                ]
            ]
        );
        $response = $sendgrid->send($email);
    }

    public static function sendLeadInfoToAdmin($leadId)
    {
        $lead = self::getLead($leadId);
        $from = new \SendGrid\Mail\From('info@k-madduxinvestments.com', 'Maddux Investments');
        $to = new \SendGrid\Mail\To('info@k-madduxinvestments.com', 'Admin');
        $email = new Mail($from, $to);
        $email->addContent('text/html', json_encode($lead));
        $email->setSubject('New lead from Property Calculator version ' . ADPC_VERSION);
        $sendgrid = new SendGrid(
            Emailer::API_KEY,
            [
                'curl' => [
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_SSL_VERIFYPEER => false,
                ]
            ]
        );
        $response = $sendgrid->send($email);
        var_dump($response);
    }
}