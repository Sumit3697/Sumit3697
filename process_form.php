<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Adjust the path based on your project structure

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assigndatabase";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $mobile = $_POST["mobile"];
    $message = $_POST["message"];

    // Upload file
    $uploadDir = "uploads/"; // Change this to your desired upload directory
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
        // Insert data into database
        $sql = "INSERT INTO form_data (name, email, mobile, message, file_path) VALUES ('$name', '$email', '$mobile', '$message', '$targetFilePath')";

        if ($conn->query($sql) === TRUE) {
            // Send email
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'smpubg420@gmail.com';
                $mail->Password = 'dubs kfvn bzni hchu';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('smpubg420@gmail.com', 'sumit mishra');
                $mail->addAddress($email, $name);

                $mail->isHTML(true);
                $mail->Subject = 'Form Submission Received';
                $mail->Body = "Dear $name,<br><br>We have received a form from your end. Below is the information you provided:<br><br>
                                Name: $name<br>
                                Email: $email<br>
                                Mobile: $mobile<br>
                                Message: $message<br><br>
                                Attached Image:<br><br><img src='cid:uploaded_image'>";
                $mail->AltBody = "Dear $name,\n\nWe have received a form from your end. Below is the information you provided:\n\n
                                Name: $name\n
                                Email: $email\n
                                Mobile: $mobile\n
                                Message: $message\n\n
                                Attached Image:\n\n[Image is attached]";

                $mail->addAttachment($targetFilePath, 'uploaded_image.jpg', 'base64', 'image/jpeg');
                $mail->addEmbeddedImage($targetFilePath, 'uploaded_image');

                $mail->send();

                echo "Form submitted successfully and email sent!";
            } catch (Exception $e) {
                echo "Error sending email: {$mail->ErrorInfo}";
            }
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error uploading file.";
    }
}

// Close connection
$conn->close();
?>
