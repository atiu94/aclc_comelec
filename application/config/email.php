<?php

$config['useragent'] = 'CodeIgniter';
$config['protocol'] = 'smtp';
$config['mailpath'] = '/usr/sbin/sendmail';

$config['smtp_host'] = 'ssl://rs11.websitehostserver.net';
$config['smtp_user'] = 'test-email+zeaple.com';
$config['smtp_pass'] = 'tester123';
$config['smtp_port'] = 465;
$config['smtp_timeout'] = 5;

$config['wordwrap'] = false;
$config['wrapchars'] = 76;
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';

$config['validate'] = false;
$config['priority'] = 3;

$config['crlf'] = "\r\n";
$config['newline'] = "\r\n";

$config['bcc_batch_mode'] = false;
$config['bcc_batch_size'] = 200;

$config['from_email'] = "test-email@zeaple.com";
$config['from_email_name'] = "Zeaple Test Email";