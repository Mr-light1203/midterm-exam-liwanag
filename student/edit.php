<?php
include '../root/functions.php';
checkUserSessionIsActive();


if (!isset($_GET['id'])) {
    header("Location: register.php");
    exit();
}

$studentID = $_GET['id'];
$studentData = null;


foreach ($_SESSION['student_data'] as $key => $student) {
    if ($student['ID'] === $studentID) {
        $studentData = $student;
        $studentIndex = $key; 
        break;
    }
}


if (!$studentData) {
    header("Location: register.php");
    exit();
}

$errorArray = [];


if (isset($_POST['updateStudent'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];

    
    $errorArray = validateStudentData([
        'ID' => $studentID,  
        'first_name' => $firstName,
        'last_name' => $lastName,
    ]);

    if (empty($errorArray)) {
        
        $_SESSION['student_data'][$studentIndex]['first_name'] = $firstName;
        $_SESSION['student_data'][$studentIndex]['last_name'] = $lastName;

        
        header("Location: register.php");
        exit();
    }
}
?>

<?php
$pageTitle = "Edit Student";
include('../root/header.php');
?>

<div class="container my-5">
    <?php
        
        if (!empty($errorArray)) {
            echo displayErrors($errorArray);
        }
    ?>
    <h2>Edit Student Details</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../root/dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="register.php">Register Student</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Student</li>
        </ol>
    </nav>

    <div class="card p-3 mb-4">
        <form method="post">
            <div class="mb-3">
                <label for="studentID" class="form-label">Student ID</label>
                <input type="text" class="form-control" id="studentID" value="<?= htmlspecialchars($studentData['ID']) ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="firstName" class="form-label">First Name</label>
                <input type="text" name="firstName" class="form-control" id="firstName" value="<?= htmlspecialchars($studentData['first_name']) ?>">
            </div>
            <div class="mb-3">
                <label for="lastName" class="form-label">Last Name</label>
                <input type="text" name="lastName" class="form-control" id="lastName" value="<?= htmlspecialchars($studentData['last_name']) ?>">
            </div>
            <button type="submit" class="btn btn-primary" name="updateStudent">Update Student</button>
        </form>
    </div>
</div>

<?php include('../root/footer.php'); ?>
