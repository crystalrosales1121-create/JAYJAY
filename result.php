
<?php
session_start();

if (!isset($_SESSION['questions'], $_SESSION['score'])) {
    header("Location: index1.php");
    exit();
}

$score = $_SESSION['score'];
$total = count($_SESSION['questions']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quiz Result</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>

<div class="container">

    <h1>QUIZ COMPLETED!</h1>

    <h2>Your Final Score</h2>

    <h1><?php echo $score; ?> / <?php echo $total; ?></h1>

    <p>
        <?php
        if ($score >= ($total / 2)) {
            echo "Congratulations! Great job!";
        } else {
            echo "Keep practicing! You can do better!";
        }
        ?>
    </p>

    <a href="index1.php">
        <button>PLAY AGAIN</button>
    </a>

</div>

</body>
</html>

<?php
session_destroy();
?>
