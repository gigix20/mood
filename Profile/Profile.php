<?php
include '../LoginAndReg/connect.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../LoginAndReg/Login.php");
    exit;
}

// Get the logged-in user's data
$email = $_SESSION['email'];
$userResult = $conn->query("SELECT id, firstName, bio FROM users WHERE email = '$email'");
$userData = $userResult->fetch_assoc();
$user_id = $userData['id'];
$firstName = $userData['firstName'];
$bio = $userData['bio'];

// For Bio Update 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newBio = $conn->real_escape_string($_POST['bio']);
    $conn->query("UPDATE users SET bio = '$newBio' WHERE id = $user_id");
    $bio = $newBio;
}

//Clickable Links
function makeLinksClickable($text) {
    $text = htmlspecialchars($text);
    return preg_replace(
        '/(https?:\/\/[^\s]+)/',
        '<a href="$1" target="_blank" rel="noopener noreferrer">$1</a>',
        $text
    );
}

// Format bio for display
$formattedBio = makeLinksClickable($bio);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="Profile.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet"/>
    <title>Mooodify - Profile</title>
    <link rel="icon" type="image/jpg" href="MoodifyClearLogo.png"/>
</head>
<style>
    .user-bio {
        margin-top: 20px;
        text-align: center;
    }

    .user-bio h3 {
        font-size: 1.5em;
        margin-bottom: 10px;
        color: #333;
    }

    .user-bio textarea {
        width: 80%;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ccc;
        background-color: rgba(255, 255, 255, 0.6);
        font-size: 1em;
        color: #333;
        resize: none;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }

    .user-bio button {
        margin-top: 10px;
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        background-color: #4CAF50;
        color: #fff;
        font-size: 1em;
        cursor: pointer;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        transition: background-color 0.3s ease;
    }

    .user-bio button:hover {
        background-color: #45a049;
    }
</style>
<body>

<div class="container">
    <div class="profile">
        <div class="homebtn">
            <a href="../HomePage/HomePage.php" class="homeicon">
            <i class="fa-solid fa-left-long"></i>
            </a>
        </div>

        <div class="user-name">
            <center><h3>My Name is</h3></center>
            <p><h1><?= htmlspecialchars($firstName) ?></h1></p>
        </div>

        <div class="user-bio">
            <h3>Bio</h3>
            <p id="bio-display"><?= $formattedBio ?: 'No bio added yet.' ?></p>
            <form id="bio-form" method="POST" action="" style="display: none;">
                <textarea name="bio" rows="4" cols="50"><?= htmlspecialchars($bio) ?></textarea><br>
                <button type="submit" onclick="toggleBioEdit(true)">Save Bio</button>
            </form>
            <button id="edit-bio-button" onclick="toggleBioEdit(false)">Update Bio</button>
        </div>
    </div>
</div>

<script>
    function toggleBioEdit(submitting = false) {
        const bioDisplay = document.getElementById('bio-display');
        const bioForm = document.getElementById('bio-form');
        const editButton = document.getElementById('edit-bio-button');

        if (submitting) {
            bioForm.style.display = 'none';
            bioDisplay.style.display = 'block';
            editButton.style.display = 'block';
        } else {
            bioForm.style.display = 'block';
            bioDisplay.style.display = 'none';
            editButton.style.display = 'none';
        }
    }
</script>

</body>
</html>
