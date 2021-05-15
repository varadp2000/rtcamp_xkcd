    
    <?php

    // $file = file_get_contents("https://awik.io/wp-content/uploads/2018/06/unsplash.jpg");
    // $encoded_file = chunk_split(base64_encode($file));

    // $attachments[] = array(
    //     'name' => 'image.jpg', // Set File Name
    //     'data' => $encoded_file, // File Data
    //     'type' => 'application/pdf', // Type
    //     'encoding' => 'base64' // Content-Transfer-Encoding
    // );
        ini_set("SMTP", "smtp.mailtrap.io");
        ini_set("auth_username", "c2848f14bdeffa");
        ini_set("auth_password", "8ab109b4c9792c");

    if(mail("varadrpatil27@gmail.com", "Hello Their", "If you're reading this", "From: varad"))
        print_r(error_get_last());
    else
        print_r(error_get_last());


    // function sendMail(
    //     $email = "",
    //     $text = "",
    //     $subject = "",
    //     $attachments = array()
    // ) {
    //     if (!$email || !$text) {
    //         return false;
    //     }

    //     $headers   = array();
    //     $headers[] = "To: {$email}";
    //     $headers[] = "From: CAPS Consortium <contact@capsconsortium.com>";
    //     $headers[] = "Reply-To: CAPS Consortium <contact@capsconsortium.com>";
    //     $headers[] = "Subject: {$subject}";
    //     $headers[] = "X-Mailer: PHP/" . phpversion();

    //     $headers[] = "MIME-Version: 1.0";

    //     if (!empty($attachments)) {
    //         $boundary = md5(time());
    //         $headers[] = "Content-type: multipart/mixed;boundary=\"" . $boundary . "\"";
    //         // Have attachment, different content type and boundary required.
    //     } else {
    //         $headers[] = "Content-type: text/html; charset=UTF-8";
    //     }

    //     $html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    // <html xmlns="http://www.w3.org/1999/xhtml">
    //     <head>
    //         <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    //         <title>CAPS Consortium</title>
    //         <style>table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }</style>
    //     </head>
    //     <body style="font-family: arial;" width="100%">
    //         [text]
    //     </body>
    // </html>';
    //     $generated = date('jS M Y H:i:s');  
    //     $subject = ($subject ? $subject : 'Default Subject');
    //     $message = $html;

    //     $message = str_replace("[text]", $text, $message);

    //     if (!empty($attachments)) {
    //         $output   = array();
    //         $output[] = "--" . $boundary;
    //         $output[] = "Content-type: text/html; charset=\"utf-8\"";
    //         $output[] = "Content-Transfer-Encoding: 8bit";
    //         $output[] = "";
    //         $output[] = $message;
    //         $output[] = "";
    //         foreach ($attachments as $attachment) {
    //             $output[] = "--" . $boundary;
    //             $output[] = "Content-Type: " . $attachment['type'] . "; name=\"" . $attachment['name'] . "\";";
    //             if (isset($attachment['encoding'])) {
    //                 $output[] = "Content-Transfer-Encoding: " . $attachment['encoding'];
    //             }
    //             $output[] = "Content-Disposition: attachment;";
    //             $output[] = "";
    //             $output[] = $attachment['data'];
    //             $output[] = "";
    //         }
    //         return mail($email, $subject, implode("\r\n", $output), implode("\r\n", $headers));
    //     } else {
    //         return mail($email, $subject, $message, implode("\r\n", $headers));
    //     }
    // }

    ?>