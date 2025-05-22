<?php
    include_once 'database.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;
    
    require('..\vendor\phpmailer\phpmailer\src\PHPMailer.php');
    require('..\vendor\phpmailer\phpmailer\src\SMTP.php');
    require('..\vendor\phpmailer\phpmailer\src\Exception.php');


    function adminLogin(){
        // session_start();
        if(!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true)){
            echo "<script>
                window.location.href = '../login.php';
            </script>";
        }
        session_regenerate_id(true);
    }

    function userLogin(){
        // session_start();
        if(!(isset($_SESSION['userLogin']) && $_SESSION['userLogin'] == true)){
            echo "<script>
                window.location.href = 'login.php';
            </script>";
        }
        session_regenerate_id(true);
    }
  
    function redirect($url){
        echo "<script>
            window.location.href = '$url';
        </script>";
    }

    function alert($type, $msg){
        $bs_class = ($type == 'success') ? "alert-success" : "alert-danger";
        echo <<< alert
            <div class="alert $bs_class alert-dismissible fade show custom-alert" role="alert">
                <strong>$msg</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        alert;
    }



    function sendEmail($to, $subject, $body, $file)
    {
        $mail = new PHPMailer(true);

        try {
            $headers = 'X-Mailer: PHP/' . phpversion();
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
            // SMTP Configuration
            $mail->IsSMTP(); // telling the class to use SMTP
            // $mail->SMTPDebug  = 2;                // enables SMTP debug information (for testing)
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
            $mail->Host       = 'smtp.gmail.com';      // sets GMAIL as the SMTP server
            $mail->Port       = 465;                   // set the SMTP port for the GMAIL server
            $mail->Username   = "krishpanasara9265@gmail.com";  // GMAIL username(from)
            $mail->Password   = "qrhw dkho zrjx ckgv";            // GMAIL password(from)
            $mail->SetFrom('krishpanasara9265@gmail.com', 'CooKing'); //from
            $mail->AddReplyTo("krishpanasara9265@gmail.com", "CooKing"); //to
            $mail->Subject    = $subject;
            $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
            if ($file) {
                $mail->AddAttachment($file);
            }
            $mail->MsgHTML($body);

            $mail->AddAddress($to);
            // Send email
            if ($mail->Send()) {
                return true;
            }
            // return "Email sent successfully!";
        } catch (Exception $e) {
            return "Email failed: " . $mail->ErrorInfo;
        }
    }
?>