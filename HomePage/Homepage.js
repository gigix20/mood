let btn = document.querySelector("#btn");
let sidebar = document.querySelector(".sidebar");
let logoutLink = document.querySelector("#logout");

btn.onclick = function () {
  sidebar.classList.toggle("active");
};

logoutLink.onclick = function (event) {
  if (!confirm("Are you sure you want to log out?")) {
    event.preventDefault();
  } else {
    // Clear any session or local storage data
    localStorage.removeItem("posts"); // Clear posts if necessary
    localStorage.removeItem("isLoggedIn"); // Clear login state
    // Redirect to login page
    window.location.href = "login.html"; // Change to your login page URL
  }
};

let postButton = document.getElementById("post-btn");
let postInput = document.getElementById("post-input");
let postsContainer = document.getElementById("posts-container");
let wordCount = document.getElementById("word-count");

let posts = JSON.parse(localStorage.getItem("posts")) || {};

function createPost(formattedDate, postData) {
  let postDiv = document.createElement("div");
  postDiv.className = "feed";
  postDiv.innerHTML = `
    <div class="head">
      <div class="user">
        <div class="profile-photo">
          <img src="profile.jpg" />
        </div>
        <div class="ingo">
          <h3>Username</h3>
          <small>${formattedDate}</small>
        </div>
      </div>
      <span class="edit">
        <i class="fa-solid fa-ellipsis"></i>
      </span>
    </div>
    <div class="caption">
      <div class="emoji-large">${postData.emoji}</div>
      <p><b>${postData.text}</b></p>
      <span class="harsh-tag">#I-moodify!</span>
    </div>
    <div class="interaction">
      <span class="interaction-button"><i class="fa-solid fa-heart"></i>Heart</span>
      <span class="interaction-button"><i class="fa-solid fa-comment"></i>Comment</span>
    </div>
  `;

  let deleteButton = document.createElement("div");
  deleteButton.innerHTML = `
    <div class="delete-menu" style="display: none;">
      <button class="delete-post">Delete Post</button>
    </div>
  `;

  postDiv.querySelector(".edit").appendChild(deleteButton);

  postDiv.querySelector(".edit").onclick = function () {
    let menu = deleteButton.querySelector(".delete-menu");
    menu.style.display = menu.style.display === "none" ? "block" : "none";
  };

  deleteButton.querySelector(".delete-post").onclick = function () {
    postsContainer.removeChild(postDiv);
    delete posts[formattedDate];
    localStorage.setItem("posts", JSON.stringify(posts));
    displayCalendar();
  };

  postsContainer.prepend(postDiv);
}

postButton.onclick = function () {
  let postText = postInput.innerText.trim();
  let selectedEmoji =
    document.querySelector('input[name="emoticon-option"]:checked')
      ?.nextElementSibling?.textContent || "";
  let currentDateTime = new Date();
  let formattedDate = currentDateTime.toISOString().split("T")[0];
  let formattedTime = currentDateTime.toLocaleTimeString([], {
    hour: "2-digit",
    minute: "2-digit",
  });

  if (postText) {
    if (!posts[formattedDate]) {
      posts[formattedDate] = [];
    }

    posts[formattedDate].push({
      emoji: selectedEmoji,
      text: postText,
      time: formattedTime,
    });

    localStorage.setItem("posts", JSON.stringify(posts));
    createPost(formattedDate, { emoji: selectedEmoji, text: postText });
    postInput.innerText = "";
    wordCount.textContent = `0/50 characters`;
    displayCalendar();
  }
};

// Update character count and restrict input to 50 characters
postInput.addEventListener("input", function () {
  let text = postInput.innerText.trim();

  if (text.length > 50) {
    postInput.innerText = text.substring(0, 50); // Limit input to 50 characters
    placeCaretAtEnd(postInput); // Place cursor at the end after truncation
  }

  wordCount.textContent = `${postInput.innerText.length}/50 characters`;
});

// Function to place cursor at the end of the contenteditable element
function placeCaretAtEnd(el) {
  el.focus();
  const range = document.createRange();
  range.selectNodeContents(el);
  range.collapse(false);
  const sel = window.getSelection();
  sel.removeAllRanges();
  sel.addRange(range);
}

loadPosts();
displayCalendar();
