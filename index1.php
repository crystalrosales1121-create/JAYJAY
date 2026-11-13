
<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>JAYJAY Quiz Game</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>

<div class="container">
    <h1>WELCOME TO JAYJAY QUIZ GAME!</h1>
    <p>Test your knowledge and enjoy answering questions.</p>

    <form action="quiz.php" method="POST">
        <button type="submit" name="start">START QUIZ</button>
    </form>
</div>

</body>
</html>
