<?php
include '../root/functions.php';
session_start();
checkUserSessionIsActive();
guard();


if (!isset($_GET['code']) || !isset($_GET['student_id'])) {
    header("Location: register.php");
    exit();
}

$subjectCode = $_GET['code'];
$studentID = $_GET['student_id'];


$studentIndex = getSelectedStudentIndex($studentID);
if ($studentIndex === null) {
    header("Location: register.php");
    exit();
}

$studentData = $_SESSION['student_data'][$studentIndex];


if (!in_array($subjectCode, $studentData['attached_subjects'])) {
    header("Location: attach-subject.php?id=" . $studentID);
    exit();
}


if (isset($_POST['confirmDetach'])) {
    
    $studentData['attached_subjects'] = array_filter($studentData['attached_subjects'], function ($code) use ($subjectCode) {
        return $code !== $subjectCode;
    });

    
    $studentData['attached_subjects'] = array_values($studentData['attached_subjects']);
    $_SESSION['student_data'][$studentIndex] = $studentData;

    header("Location: attach-subject.php?id=" . $studentID);
    exit();
}


$subjectData = array_filter($_SESSION['subject_data'], function ($s) use ($subjectCode) {
    return $s['subject_code'] === $subjectCode;
});
$subjectData = reset($subjectData);
?>

<?php
$pageTitle = "Detach Subject";
include('../root/header.php');
?>

<div class="container my-5">
    <h2>Detach Subject</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../root/dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="register.php">Register Student</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detach Subject</li>
        </ol>
    </nav>

    <div class="card p-3 mb-4">
        <p>Are you sure you want to detach the following subject from <?= htmlspecialchars($studentData['first_name'] . ' ' . $studentData['last_name']) ?>?</p>
        
        
        <ul>
            <li><strong>Student ID:</strong> <?= htmlspecialchars($studentID) ?></li>
            <li><strong>First Name:</strong> <?= htmlspecialchars($studentData['first_name']) ?></li>
            <li><strong>Last Name:</strong> <?= htmlspecialchars($studentData['last_name']) ?></li>
            <li><strong>Subject Code:</strong> <?= htmlspecialchars($subjectData['subject_code']) ?></li>
            <li><strong>Subject Name:</strong> <?= htmlspecialchars($subjectData['subject_name']) ?></li>
        </ul>

       
       

        <form method="POST">
            <button type="submit" name="confirmDetach" class="btn btn-danger">Detach Subject</button>
            <a href="attach-subject.php?id=<?= htmlspecialchars($studentID) ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?php include('../root/footer.php'); ?>
