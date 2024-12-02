<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Drawing Canvas</title>
    <link rel="stylesheet" href="Sketch.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet"
    />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />
    <style>
      * {
          box-sizing: border-box;
          margin: 0;
          padding: 0;
          font-family: "Josefin Sans", sans-serif;
          font-optical-sizing: auto;
          font-weight: bold;
      }

      body {
          display: flex;
          justify-content: center;
          align-items: center;
          height: 100vh;
          background-image: url(Griders.png);
      }

      .container {
          position: relative;
          width: 100%;
          max-width: 800px;
          height: 80vh;
          background-color: white;
          border: 2.5px solid black;
          border-radius: 10px;
      }

      .return-button {
    position: absolute;
    top: 10px;
    left: 10px;
    bottom: 10px;
    z-index: 2; /* Ensure the button is above the canvas */
    width: 30px; /* Width for the circular shape */
    height: 30px; /* Height for the circular shape */
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 50%; /* Makes the button circular */
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Optional: Adds a shadow for better visibility */
    padding: 10px;
}

.return-button:hover {
    background-color: black;
}

      .controls {
          display: flex;
          justify-content: center; 
          gap: 10px;
          padding: 10px;
          background-color: rgba(255, 255, 255, 0.8); 
          border-bottom: 1px solid #ccc; 

      }
      canvas {
          width: 100%;
          height: calc(100% - 50px); /* Adjust height to account for controls */
          border: 1px solid #000; /* Border on all sides of the canvas */
          border-radius: 10px;
          padding: 10px;
      }
    </style>
</head>
<body>
    <div class="container">
      <a href="../HomePage/HomePage.php">
        <button id="returnButton" class="return-button">
            <i class="fa-solid fa-left-long"></i>
        </button>
      </a>
        <div class="controls">
            <input type="color" id="colorPicker" value="#000000" />
            <input type="range" id="brushSize" min="1" max="100" value="5" />
            <button id="eraser">Eraser</button>
            <button id="clear">Clear Canvas</button>
        </div>
        <canvas id="drawingCanvas"></canvas>
    </div>
    <script>
      const canvas = document.getElementById("drawingCanvas");
      const ctx = canvas.getContext("2d");
      const colorPicker = document.getElementById("colorPicker");
      const brushSize = document.getElementById("brushSize");
      const eraser = document.getElementById("eraser");
      const clearButton = document.getElementById("clear");
      const returnButton = document.getElementById("returnButton");

      let painting = false;
      let currentColor = colorPicker.value;
      let currentBrushSize = brushSize.value;
      let isErasing = false;

      // Set canvas size
      function resizeCanvas() {
          canvas.width = canvas.clientWidth;
          canvas.height = canvas.clientHeight;
      }

      // Get mouse position relative to the canvas ```javascript
      function getMousePos(canvas, evt) {
          const rect = canvas.getBoundingClientRect();
          return {
              x: evt.clientX - rect.left,
              y: evt.clientY - rect.top,
          };
      }

      window.addEventListener("resize", resizeCanvas);
      resizeCanvas();

      // Start painting
      canvas.addEventListener("mousedown", (e) => {
          painting = true;
          ctx.beginPath();
          const pos = getMousePos(canvas, e);
          ctx.moveTo(pos.x, pos.y);
      });

      // Draw on canvas
      canvas.addEventListener("mousemove", (e) => {
          if (painting) {
              ctx.lineCap = "round"; // Set line cap to round
              ctx.lineWidth = isErasing ? 20 : currentBrushSize;
              ctx.strokeStyle = isErasing ? "#ffffff" : currentColor;
              const pos = getMousePos(canvas, e);
              ctx.lineTo(pos.x, pos.y);
              ctx.stroke();
              ctx.beginPath();
              ctx.moveTo(pos.x, pos.y);
          }
      });

      // Stop painting
      canvas.addEventListener("mouseup", () => {
          painting = false;
          ctx.beginPath();
      });

      // Color picker change
      colorPicker.addEventListener("input", (e) => {
          currentColor = e.target.value;
          isErasing = false;
      });

      // Brush size change
      brushSize.addEventListener("input", (e) => {
          currentBrushSize = e.target.value;
      });

      // Eraser button
      eraser.addEventListener("click", () => {
          isErasing = !isErasing;
      });

      // Clear canvas button
      clearButton.addEventListener("click", () => {
          ctx.clearRect(0, 0, canvas.width, canvas.height);
      });

      // Return button functionality
      returnButton.addEventListener("click", () => {
          console.log("Return button clicked");
          // Add your return functionality here
      });
    </script>
</body>
</html>