<?php

define('DOING_AJAX', true);

/** Load WordPress Bootstrap */
require_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/wp-load.php');

/** Allow for cross-domain requests (from the front end). */
//send_origin_headers();

// Require an action parameter
if (empty($_REQUEST['action']))
    die('0');

@header('Content-Type: application/json');
@header('X-Robots-Tag: noindex');

send_nosniff_header();
nocache_headers();

if ($_REQUEST['action'] == 'make_order') {
    $error = apply_filters('cptch_verify', true);
    if (true === $error) { /* the CAPTCHA answer is right */
        $email = trim($_POST['email']);
        $name = trim($_POST['name']);
        $phone = trim($_POST['phone']);
        $mailMessage = <<<ORDER
Сделан заказ окна.

Имя пользователя: $name
E-mail: $email
Телефон: $phone

Информация о заказе:
$_POST[window]
ORDER;
        if (wp_mail(get_option('admin_email'), 'Заказано окно', $mailMessage)) {
            $res = ['status' => 'success', 'msg' => 'Заказ успешно создан'];
        } else {
            $res = ['status' => 'error', 'msg' => 'Ошибка создания заказа. Попробуйте пожалуйста позже.'];
        }
        die(json_encode($res));
    } else { /* the CAPTCHA answer is wrong or there are some other errors */
        $res = ['status' => 'captcha_error', 'msg' => $error];
        die(json_encode($res));
    }
} else {
    die('0');
}
