<?php

// Include the necessary libraries
require 'C:\Users\pstma\OneDrive\Documents\PHPMailer-master\src\PHPMailer.php';
require 'C:\Users\pstma\OneDrive\Documents\PHPMailer-master\src\Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Function to send the email with the ticket
function sendTicketEmail($participant)
{
    // Create a new PHPMailer instance
    $mailer = new PHPMailer(true);

    try {
        // SMTP configuration
        $mailer->isSMTP();
        $mailer->Host = 'smtp.example.com';
        $mailer->SMTPAuth = true;
        $mailer->Username = 'your-email@example.com';
        $mailer->Password = 'your-email-password';
        $mailer->SMTPSecure = 'tls';
        $mailer->Port = 587;

        // Set the email details
        $mailer->setFrom('your-email@example.com', 'Your Name');
        $mailer->addAddress($participant['email'], $participant['first_name']);
        $mailer->isHTML(true);
        $mailer->Subject = 'Your Event Ticket';

        // Generate the ticket content
        $ticketContent = '
            <h1>Event Ticket</h1>
            <p>Dear ' . $participant['first_name'] . ',</p>
            <p>Thank you for registering for the event! Below are your ticket details:</p>
            <ul>
                <li>Name: ' . $participant['first_name'] . ' ' . $participant['last_name'] . '</li>
                <li>Age: ' . $participant['age'] . '</li>
                <li>Gender: ' . $participant['gender'] . '</li>
                <li>Email: ' . $participant['email'] . '</li>
                <li>Phone Number: ' . $participant['phone_number'] . '</li>
                <li>Unique ID: ' . $participant['unique_id'] . '</li>
            </ul>
            <p>Please present this ticket during check-in at the event.</p>
            <p>Best regards,</p>
            <p>Teens Pray!</p>';

        // Set the email content
        $mailer->Body = $ticketContent;

        // Send the email
        $mailer->send();

        // Return true if the email was sent successfully
        return true;
    } catch (Exception $e) {
        // Return false if there was an error sending the email
        return false;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phone_number'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];

    // Generate a unique ID
    $uniqueID = generateUniqueID();

    // Store participant data in the database (MySQL)
    $servername = 'localhost';
    $username = 'your-username';
    $password = 'your-password';
    $database = 'your-database';

    try {
        // Create a new PDO instance
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO participants (first_name, last_name, email, phone_number, age, gender, unique_id)
                                VALUES (:first_name, :last_name, :email, :phone_number, :age, :gender, :unique_id)");

        // Bind the parameters
        $stmt->bindParam(':first_name', $firstName);
        $stmt->bindParam(':last_name', $lastName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone_number', $phoneNumber);
        $stmt->bindParam(':age', $age);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':unique_id', $uniqueID);

        // Execute the statement
        $stmt->execute();

        // Prepare the participant data for the email
        $participant = [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'phone_number' => $phoneNumber,
            'age' => $age,
            'gender' => $gender,
            'unique_id' => $uniqueID
        ];

        // Send the ticket email
        $emailSent = sendTicketEmail($participant);

        // Check if the email was sent successfully
        if ($emailSent) {
            // Display a success message
            echo 'Registration successful. Please check your email for the ticket.';
        } else {
            // Display an error message
            echo 'Registration successful, but there was an error sending the ticket email.';
        }
    } catch (PDOException $e) {
        // Display an error message if there was a database connection issue
        echo 'Registration failed. Please try again later.';
    }
}
?>
