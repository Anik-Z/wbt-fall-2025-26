<!DOCTYPE HTML>
<html>
<head>
    <style>
        .error { color: red; }
        fieldset {
            width: 350px;
            padding: 10px;
            margin-bottom: 20px;
        }
        .box-title {
            font-weight: bold;
        }
    </style>
</head>
<body>

<?php
$nameErr = $emailErr = $dobErr = $genderErr = $degreeErr =$bloodErr= "";
$name = $email = "";
$dd = $mm = $yyyy = "";
$gender = "";
$degree = [];

function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}


if (isset($_POST["submit_name"])) {
    $name = test_input($_POST["name"]);

    if (empty($name)) {
        $nameErr = "Name is required";
    } elseif (!preg_match("/^[a-zA-Z][a-zA-Z .-]*$/", $name)) {
        $nameErr = "Only letters, period & dash allowed and must start with a letter";
    } elseif (str_word_count($name) < 2) {
        $nameErr = "Must contain at least two words";
    }
}


if (isset($_POST["submit_email"])) {
    $email = test_input($_POST["email"]);

    if (empty($email)) {
        $emailErr = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    }
}

if (isset($_POST["submit_dob"])) {
    $dd = $_POST["dd"];
    $mm = $_POST["mm"];
    $yyyy = $_POST["yyyy"];

    if (empty($dd) || empty($mm) || empty($yyyy)) {
        $dobErr = "Date of birth is required";
    } elseif ($dd < 1 || $dd > 31) {
        $dobErr = "Day must be 1–31";
    } elseif ($mm < 1 || $mm > 12) {
        $dobErr = "Month must be 1–12";
    } elseif ($yyyy < 1953 || $yyyy > 1998) {
        $dobErr = "Year must be 1953–1998";
    }
}


if (isset($_POST["submit_gender"])) {
    if (empty($_POST["gender"])) {
        $genderErr = "Gender is required";
    } else {
        $gender = $_POST["gender"];
    }
}


if (isset($_POST["submit_degree"])) {
    if (!isset($_POST["degree"])) {
        $degreeErr = "Select at least two";
    } else {
        $degree = $_POST["degree"];
        if (count($degree) < 2) {
            $degreeErr = "Select at least two";
        }
    }
}
if (isset($_POST['submit_blood'])) {
    if (empty($_POST['blood'])) {
        $bloodErr = "Please select a blood group.";
    }
}
?>


<h2> Form Validation Assignment</h2>

<form method="post">
<fieldset>
    <div class="box-title">NAME</div><br>

    <input type="text" name="name" value="<?= $name ?>"><br>
    <div class="error"><?= $nameErr ?></div><br>

    <input type="submit" name="submit_name" value="Submit">
</fieldset>
</form>

<form method="post">
<fieldset>
    <div class="box-title">EMAIL</div><br>

    <input type="text" name="email" value="<?= $email ?>"><br>
    <div class="error"><?= $emailErr ?></div><br>

    <input type="submit" name="submit_email" value="Submit">
</fieldset>
</form>

<form method="post">
<fieldset>
    <div class="box-title">DATE OF BIRTH</div><br>

    <input type="text" name="dd" size="3" placeholder="dd" value="<?= $dd ?>">
    <input type="text" name="mm" size="3" placeholder="mm" value="<?= $mm ?>">
    <input type="text" name="yyyy" size="5" placeholder="yyyy" value="<?= $yyyy ?>"><br>

    <div class="error"><?= $dobErr ?></div><br>

    <input type="submit" name="submit_dob" value="Submit">
</fieldset>
</form>
<form method="post">
<fieldset>
    <div class="box-title">GENDER</div><br>

    <input type="radio" name="gender" value="Male" <?= ($gender=="Male")?"checked":"" ?>> Male
    <input type="radio" name="gender" value="Female" <?= ($gender=="Female")?"checked":"" ?>> Female
    <input type="radio" name="gender" value="Other" <?= ($gender=="Other")?"checked":"" ?>> Other

    <br><div class="error"><?= $genderErr ?></div><br>

    <input type="submit" name="submit_gender" value="Submit">
</fieldset>
</form>
<form method="post">
<fieldset>
    <div class="box-title">DEGREE</div><br>

    <input type="checkbox" name="degree[]" value="SSC" <?= in_array("SSC", $degree)?"checked":"" ?>> SSC
    <input type="checkbox" name="degree[]" value="HSC" <?= in_array("HSC", $degree)?"checked":"" ?>> HSC
    <input type="checkbox" name="degree[]" value="BSc" <?= in_array("BSc", $degree)?"checked":"" ?>> BSc
    <br><div class="error"><?= $degreeErr ?></div><br>

    <input type="submit" name="submit_degree" value="Submit">

</fieldset>
</form>

<form method = "post">
    <fieldset>
<div class="box">
    <label>BLOOD GROUP</label><br>
    <form method="post">
        <select name="blood">
            <option value="">Select</option>
            <?php
            $groups = ["A+", "A-", "B+", "B-", "O+", "O-", "AB+", "AB-"];
            foreach ($groups as $g) {
                echo "<option value='$g' ";
                if (isset($_POST['blood']) && $_POST['blood'] == $g) echo "selected";
                echo ">$g</option>";
            }
            ?>
        </select>
        <br><br>
        <input type="submit" name="submit_blood" value="Submit">
        <div class="error"><?php echo $bloodErr; ?></div>
        </fieldset>
</div>
</form>

</body>
</html>
