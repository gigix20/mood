<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet" />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Moodify - LogIn & SignUp</title>
    <link rel="icon" type="image/jpg" href="MoodifyClearLogo.png" />
    <link href="Login.css" rel="stylesheet" />
    <script type="text/javascript" src="darkmode.js" defer> </script>
</head>
<body>
    <div class="wrapper">
        <!--Login Form-->
        <div class="form-box login">
        <button id="theme-switch">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="M480-120q-150 0-255-105T120-480q0-150 105-255t255-105q14 0 27.5 1t26.5 3q-41 29-65.5 75.5T444-660q0 90 63 153t153 63q55 0 101-24.5t75-65.5q2 13 3 26.5t1 27.5q0 150-105 255T480-120Z"/></svg> <br>
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="M480-280q-83 0-141.5-58.5T280-480q0-83 58.5-141.5T480-680q83 0 141.5 58.5T680-480q0 83-58.5 141.5T480-280ZM200-440H40v-80h160v80Zm720 0H760v-80h160v80ZM440-760v-160h80v160h-80Zm0 720v-160h80v160h-80ZM256-650l-101-97 57-59 96 100-52 56Zm492 496-97-101 53-55 101 97-57 59Zm-98-550 97-101 59 57-100 96-56-52ZM154-212l101-97 55 53-97 101-59-57Z"/></svg>
            </button>
            <h2>Login</h2>
            <form method="post" action="register.php">
                <div class="input-box">
                    <span class="icon"><ion-icon name="mail-outline"></ion-icon></span>
                    <input type="email" name="email" id="email" required />
                    <label>Email</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed-outline"></ion-icon></span>
                    <input type="password" name="password" id="password" required />
                    <label>Password</label>
                </div>
                <div class="remember-forgot">
                    <label><input type="checkbox" />Remember me </label>
                    <a href="#">Forgot Password?</a>
                </div>
                <button type="submit" class="btn" value="Login" name="login">
                    Login
                </button>
                <div class="login-register">
                    <p>
                        Don't Have Account?<a href="#" class="Register Link">Sign Up</a>
                    </p>
                </div>
            </form>
        </div>
        
        <!--Register Form-->
        <div class="form-box signup" style="display: none">
            <h2>Sign Up</h2>
            <form method="post" action="register.php">
                <div class="input-box">
                    <span class="icon"><ion-icon name="person-outline"></ion-icon></span>
                    <input type="text" name="fname" id="fname" required />
                    <label for="fname">First Name</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="person-outline"></ion-icon></span>
                    <input type="text" name="lname" id="lname" required />
                    <label for="lname">Last Name</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="mail-outline"></ion-icon></span>
                    <input type="email" name="email" id="email" required />
                    <label for="email">Email</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed-outline"></ion-icon></span>
                    <input type="password" name="password" id="password" required />
                    <label for="password">Password</label>
                </div>
                <div class="remember-forgot">
                    <label><input type="checkbox" />Agree to Terms and Conditions</label>
                </div>
                <button type="submit" class="btn" value="SignUp" name="signUp">
                    Sign Up
                </button>
                <div class="login-register">
                    <p>
                        Already have an Account?<a href="#" class="Register Link">Login</a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="Login.js"></script>
</body>
</html>
