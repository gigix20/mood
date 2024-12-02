<?php
include '../LoginAndReg/connect.php';
session_start();

// Get the logged-in user's ID
$email = $_SESSION['email'];
$userResult = $conn->query("SELECT id FROM users WHERE email = '$email'");
$userData = $userResult->fetch_assoc();
$user_id = $userData['id'];

// Get posts made by the user
$postQuery = $conn->prepare("SELECT emoji, content, created_at FROM posts WHERE user_id = ? ORDER BY created_at DESC");
$postQuery->bind_param("i", $user_id);
$postQuery->execute();
$postResult = $postQuery->get_result();

// Store post data (emojis, content, and dates) in an associative array
$posts = [];
while ($post = $postResult->fetch_assoc()) {
    $postDate = date("Y-m-d", strtotime($post['created_at'])); // Only date, no time
    $posts[$postDate][] = [
        'emoji' => $post['emoji'],
        'content' => $post['content']
    ]; // Store emojis and content for the date
}

// Pass posts data to the frontend as a JSON object
$postsJson = json_encode($posts);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moodify - Calendar</title>
    <link rel="stylesheet" href="Calendar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="icon" type="image/jpg" href="MoodifyClearLogo.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet"
    />
</head>
<body>
    <div class="container">
        <button class="home-button">
            <a href="../HomePage/HomePage.php"><i class="fa-solid fa-left-long"></i></a>
        </button>

        <div id="controls">
            <button onclick="changeMonth(-1)">Previous</button>
            <span id="monthYear"></span>
            <button onclick="changeMonth(1)">Next</button>
        </div>

        <div id="calendar"></div>
    </div>

    <script>
        let currentDate = new Date();
        const posts = <?= $postsJson; ?>;

        const calendar = document.getElementById("calendar");
        const monthYear = document.getElementById("monthYear");

        function displayCalendar() {
            calendar.innerHTML = "";
            const currentMonth = currentDate.getMonth();
            const currentYear = currentDate.getFullYear();

            const firstDayOfMonth = new Date(currentYear, currentMonth, 1).getDay();
            const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

            monthYear.textContent = `${currentDate.toLocaleString("default", {
                month: "long",
            })} ${currentYear}`;

            // Add empty cells for days before the first day of the month
            for (let i = 0; i < firstDayOfMonth; i++) {
                let emptyCell = document.createElement("div");
                emptyCell.classList.add("day", "empty");
                calendar.appendChild(emptyCell);
            }

            // Add cells for each day of the month
            for (let day = 1; day <= daysInMonth; day++) {
                let dayCell = document.createElement("div");
                dayCell.classList.add("day");
                dayCell.innerHTML = `<span class="day-number">${day}</span>`;

                let formattedDate = `${currentYear}-${(currentMonth + 1)
                    .toString()
                    .padStart(2, "0")}-${day.toString().padStart(2, "0")}`;

                // Check if there are posts for this date
                if (posts[formattedDate]) {
                    posts[formattedDate].forEach((post) => {
                        let moodEmoji = document.createElement("div");
                        moodEmoji.classList.add("emoji-large");
                        moodEmoji.textContent = post.emoji;

                        let tooltip = document.createElement("div");
                        tooltip.classList.add("tooltip");
                        tooltip.textContent = post.content;

                        let emojiWrapper = document.createElement("div");
                        emojiWrapper.classList.add("emoji-wrapper");
                        emojiWrapper.appendChild(moodEmoji);
                        emojiWrapper.appendChild(tooltip);

                        dayCell.appendChild(emojiWrapper);
                    });
                }

                calendar.appendChild(dayCell);
            }
        }

        function changeMonth(direction) {
            currentDate.setMonth(currentDate.getMonth() + direction);
            displayCalendar();
        }

        displayCalendar();
    </script>
    <script src="./starter.js"></script>
</body>
</html>
