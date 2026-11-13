
<?php
session_start();
include "database.php";

// START QUIZ
if (isset($_POST['start'])) {

    unset($_SESSION['questions']);
    unset($_SESSION['current']);
    unset($_SESSION['score']);
    unset($_SESSION['feedback']);

    $sql = "SELECT * FROM quiz_game ORDER BY question_id ASC";
    $result = $conn->query($sql);

    if (!$result) {
        die("Database Error: " . $conn->error);
    }

    if ($result->num_rows == 0) {
        die("No questions found!");
    }

    $_SESSION['questions'] = $result->fetch_all(MYSQLI_ASSOC);
    $_SESSION['current'] = 0;
    $_SESSION['score'] = 0;
}

// CHECK QUIZ
if (!isset($_SESSION['questions'])) {
    header("Location: index1.php");
    exit();
}

// PROCESS ANSWER
if (isset($_POST['answer'])) {

    $index = $_SESSION['current'];
    $q = $_SESSION['questions'][$index];

    $selected = $_POST['answer'];
    $correct = $q['correct_answer'];

    if ($selected == $correct) {

        $_SESSION['score']++;

        $_SESSION['feedback'] = [
            'status' => 'correct',
            'message' => 'Correct! Great job!',
            'answer' => $correct
        ];

    } else {

        $_SESSION['feedback'] = [
            'status' => 'wrong',
            'message' => 'Incorrect! Better luck next time.',
            'answer' => $correct
        ];
    }
}

// SHOW FEEDBACK BEFORE NEXT QUESTION
if (isset($_POST['next'])) {
    unset($_SESSION['feedback']);
    $_SESSION['current']++;
}

// CHECK IF QUIZ IS FINISHED
if ($_SESSION['current'] >= count($_SESSION['questions'])) {
    header("Location: result.php");
    exit();
}

$index = $_SESSION['current'];
$q = $_SESSION['questions'][$index];

// CHOICE TEXT FOR CORRECT ANSWER
$correctLetter = $q['correct_answer'];
$correctText = $q['choice_' . strtolower($correctLetter)];

?>

<!DOCTYPE html>
<html>
<head>
    <title>JAYJAY Quiz Game</title>
    <link rel="stylesheet" href="style2.css">
</head>

<body>

<div class="container">

    <h1>JAYJAY QUIZ GAME</h1>

    <h3>
        Question <?php echo $index + 1; ?>
        of <?php echo count($_SESSION['questions']); ?>
    </h3>

    <h2>
        <?php echo htmlspecialchars($q['questions']); ?>
    </h2>

    <?php if (!isset($_SESSION['feedback'])): ?>

        <form method="POST" action="quiz.php">

            <label>
                <input type="radio" name="answer" value="A" required>
                A. <?php echo htmlspecialchars($q['choice_a']); ?>
            </label>

            <label>
                <input type="radio" name="answer" value="B">
                B. <?php echo htmlspecialchars($q['choice_b']); ?>
            </label>

            <label>
                <input type="radio" name="answer" value="C">
                C. <?php echo htmlspecialchars($q['choice_c']); ?>
            </label>

            <label>
                <input type="radio" name="answer" value="D">
                D. <?php echo htmlspecialchars($q['choice_d']); ?>
            </label>

            <button type="submit">SUBMIT ANSWER</button>

        </form>

    <?php else: ?>

        <?php if ($_SESSION['feedback']['status'] == 'correct'): ?>

            <h2 style="color: green;">
                &#10004; Correct Answer!
            </h2>

        <?php else: ?>

            <h2 style="color: red;">
                &#10008; Incorrect Answer!
            </h2>

        <?php endif; ?>

        <p>
            Correct Answer:
            <strong>
                <?php echo htmlspecialchars($correctLetter); ?>.
                <?php echo htmlspecialchars($correctText); ?>
            </strong>
        </p>

        <p>
            Your Score:
            <?php echo $_SESSION['score']; ?>
        </p>

        <form method="POST" action="quiz.php">
            <button type="submit" name="next">
                NEXT QUESTION
            </button>
        </form>

    <?php endif; ?>

</div>

</body>
</html>
