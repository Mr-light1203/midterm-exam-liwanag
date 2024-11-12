<?php
include '../root/functions.php';
session_start(); 
checkUserSessionIsActive();
guard();


if (!isset($_GET['code'])) {
    header("Location: add.php");
    exit();
}

$subjectCode = $_GET['code'];
$index = getSelectedSubjectIndex($subjectCode);

if ($index === null) {
    header("Location: add.php");
    exit();
}


$subjectData = $_SESSION['subject_data'][$index];


if (isset($_POST['confirmDelete'])) {
    unset($_SESSION['subject_data'][$index]);
    $_SESSION['subject_data'] = array_values($_SESSION['subject_data']); 
    header("Location: add.php");
    exit();
}
?>

<?php
$pageTitle = "Delete Subject";
include('../root/header.php');
?>

<div class="container my-5">
    <h2>Delete Subject</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../root/dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="add.php">Add Subject</a></li>
            <li class="breadcrumb-item active" aria-current="page">Delete Subject</li>
        </ol>
    </nav>

    <div class="card p-3 mb-4">
        <p>Are you sure you want to delete the following subject record?</p>
        <ul>
            <li><strong>Subject Code:</strong> <?= htmlspecialchars($subjectData['subject_code']) ?></li>
            <li><strong>Subject Name:</strong> <?= htmlspecialchars($subjectData['subject_name']) ?></li>
        </ul>

        <form method="POST">
            <button type="submit" name="confirmDelete" class="btn btn-danger">Delete Subject Record</button>
            <a href="add.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?php include('../root/footer.php'); ?>
