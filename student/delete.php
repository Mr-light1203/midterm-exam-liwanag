<?php 
    include '../root/functions.php'; 
    session_start();
    checkUserSessionIsActive(); 
    guard(); 

    
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        header('Location: ../root/dashboard.php'); 
        exit();
    }

    
    $studentID = $_GET['id'];

    
    $studentIndex = getSelectedStudentIndex($studentID);

    if ($studentIndex === null) {
        
        header('Location: ../root/dashboard.php');
        exit();
    }

    
    $student = getSelectedStudentData($studentIndex);

    
    if (isset($_POST['deleteStudent'])) {
        
        unset($_SESSION['student_data'][$studentIndex]);

       
        $_SESSION['student_data'] = array_values($_SESSION['student_data']);
        
        
        header('Location: register.php');
        exit();
    }

    $pageTitle = "Delete Student";
    include('../root/header.php');
?>

<div class="container my-5">
    <h2>Delete a Student</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../root/dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="register.php">Register Student</a></li>
            <li class="breadcrumb-item active" aria-current="page">Delete Student</li>
        </ol>
    </nav>

   
    <div class="card p-3 mb-4">
        <p>Are you sure you want to delete the following student record?</p>
        <ul>
            <li><strong>Student ID:</strong> <?= htmlspecialchars($student['ID']) ?></li>
            <li><strong>First Name:</strong> <?= htmlspecialchars($student['first_name']) ?></li>
            <li><strong>Last Name:</strong> <?= htmlspecialchars($student['last_name']) ?></li>
        </ul>

        
        <form method="POST">
            <button type="submit" name="deleteStudent" class="btn btn-danger">Delete Student Record</button>
            <a href="register.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?php include('../root/footer.php'); ?>
