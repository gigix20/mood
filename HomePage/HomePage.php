<?php
include '../LoginAndReg/connect.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../LoginAndReg/Login.php");
    exit;
}

// Get the logged-in user's ID and first name
$email = $_SESSION['email'];
$userResult = $conn->query("SELECT id, firstName FROM users WHERE email = '$email'");
$userData = $userResult->fetch_assoc();
$user_id = $userData['id'];
$firstName = $userData['firstName'];

// Handle Post Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = $_POST['content'] ?? '';
    $emoji = $_POST['emoji'] ?? '';

    // Insert the post into the database
    if (!empty($content) && !empty($emoji)) {
        $stmt = $conn->prepare("INSERT INTO posts (user_id, content, emoji) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $content, $emoji);
        $stmt->execute();
        $stmt->close();
    }
}

// Handle Post Deletion
if (isset($_GET['delete_post_id'])) {
    $post_id = $_GET['delete_post_id'];
    $deleteStmt = $conn->prepare("DELETE FROM posts WHERE id = ? AND user_id = ?");
    $deleteStmt->bind_param("ii", $post_id, $user_id);
    $deleteStmt->execute();
    $deleteStmt->close();
    header("Location: homepage.php"); // Redirect after deletion to prevent resubmission
    exit;
}

// Retrieve and display the user's posts
$postQuery = $conn->prepare("SELECT id, content, emoji, created_at FROM posts WHERE user_id = ? ORDER BY created_at DESC");
$postQuery->bind_param("i", $user_id);
$postQuery->execute();
$posts = $postQuery->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Moodify - Home</title>
    <link rel="stylesheet" href="Homepage.css" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet"
    />
    <link rel="icon" type="image/jpg" href="MoodifyClearLogo.png" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.6/css/line.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <script type="text/javascript" src="darkmode.js" defer></script>
    <style>
        /* Additional styles for the delete button */
        .post-container {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 10px;
            background-color: transparent;
            width: 25em;
            box-shadow:var(--base-variant); ;
        }

        .post {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .delete-btn {
            background-color: red;
            color: white;
            font-size: 16px;
            cursor: pointer;
            padding: 10px;
            border-radius: 10px;
            text-decoration: none;
        }

        .delete-btn:hover {
            background-color: darkred;
        }

        #post-input {
            background-color: transparent;
            border: none; 
            outline: none; 
            color:var(--text-color); 
            font-size: 20px; 
            resize: none; 
            width: 500px;
            height: 100px;
        }

        #post-input::placeholder {
            color: gray;
        }

        .post p {
            font-size: 1em;
            display: flex;
            align-items: center;
        }

        .post p .emoji {
            font-size: 3em;
            margin-right: 10px;
        }
        textarea{
            overflow: hidden;
        }
    </style>
</head>
<body>
    <div class="containerbox">
        <div class="sidebar">
            <div class="top">
                <div class="logo">
                    <i class="fa-solid fa-face-laugh-squint"></i>
                    <span>MOODIFY</span>
                </div>
                <i class="fa-solid fa-bars" id="btn"></i>
            </div>
            <ul>
                <li>
                    <a href="../Profile/Profile.php">
                        <i class="fa-solid fa-user"></i>
                        <span class="navitem">Profile</span>
                    </a>
                    <span class="tooltip">Profile</span>
                </li>
                <li>
                    <a href="../Sketch/Sketch.php">
                        <i class="fa-solid fa-pencil"></i>
                        <span class="navitem">Canvas</span>
                    </a>
                    <span class="tooltip">Canvas</span>
                </li>
                <li>
                    <a href="../Calendar/Calendar.php">
                        <i class="fa-regular fa-calendar"></i>
                        <span class="navitem">Calendar</span>
                    </a>
                    <span class="tooltip">Calendar</span>
                </li>
                <li>
                    <a href="../AboutUs/AboutUs.php">
                        <i class="fa-solid fa-question"></i>
                        <span class="navitem">AboutUs</span>
                    </a>
                    <span class="tooltip">AboutUs</span>
                </li>
                <li>
                    <a href="../LoginAndReg/Login.php" id="logout">
                        <i class="fa-solid fa-power-off"></i>
                        <span class="navitem">LogOut</span>
                    </a>
                    <span class="tooltip">LogOut</span>
    </li>
            </ul>
            <ul>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <li>
                    <button id="theme-switch">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="M480-120q-150 0-255-105T120-480q0-150 105-255t255-105q14 0 27.5 1t26.5 3q-41 29-65.5 75.5T444-660q0 90 63 153t153 63q55 0 101-24.5t75-65.5q2 13 3 26.5t1 27.5q0 150-105 255T480-120Z"/></svg> <br>
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="M480-280q-83 0-141.5-58.5T280-480q0-83 58.5-141.5T480-680q83 0 141.5 58.5T680-480q0 83-58.5 141.5T480-280ZM200-440H40v-80h160v80Zm720 0H760v-80h160v80ZM440-760v-160h80v160h-80Zm0 720v-160h80v160h-80ZM256-650l-101-97 57-59 96 100-52 56Zm492 496-97-101 53-55 101 97-57 59Zm-98-550 97-101 59 57-100 96-56-52ZM154-212l101-97 55 53-97 101-59-57Z"/></svg>
                    </button>
                </li>
            </ul>
        </div>
        <div class="maincontent">
            <div class="header">
                <h1 id="Welcome">Welcome, <?= htmlspecialchars($firstName) ?>!</h1>
            </div>

            <div class="create-post-dialog">
                <form method="POST" action="homepage.php">
                    <div class="wrapper">
                        <div class="input-box">
                            <div class="tweet-area">
                                <textarea name="content" id="post-input" maxlength="50" placeholder="What Happened?"></textarea>
                            </div>
                            <button type="submit" id="post-btn">Emote</button>
                            <span id="word-count">0/50 characters</span>
                        </div>
                        <br>
                        <div class="bottom">
                            <label for="emoji">Choose Emoji:</label>
                            <select name="emoji" id="emoji" required>
                                <option value="😄">Happy</option>
                                <option value="😇">Blessed</option>
                                <option value="😍">Inlove</option>
                                <option value="😎">Cool</option>
                                <option value="😢">Sad</option>
                                <option value="❤️">Love</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            
            <br>
            <br>
            <br>
<center><h1>Your Emotions: </h1></center>

            <div class="scrollable-content">
                <div id="posts-container">
                    <?php while ($post = $posts->fetch_assoc()): ?>
                        <div class="post-container">
                            <div class="post">
                                <div>
                                    <h3><?= htmlspecialchars($firstName) ?>, emoted...</h3>
                                    <p><span class="emoji"><?= htmlspecialchars($post['emoji']) ?></span> <?= htmlspecialchars($post['content']) ?></p>
                                    <small><?= htmlspecialchars($post['created_at']) ?></small>
                                </div>
                                <div>
                                    <!-- Delete button linked to post ID -->
                                    <a href="?delete_post_id=<?= $post['id'] ?>" class="delete-btn">Delete</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
    <script src="Homepage.js"></script>
    <script src="extension.js"></script>
    <script src="emote.js"></script>
    <script src="feed.js"></script>
    <script>
        // Word count feature
        document.getElementById('post-input').addEventListener('input', function() {
            const wordCount = this.value.length;
            document.getElementById('word-count').textContent = `${wordCount}/50 characters`;
        });
    </script>
</body>
</html>
