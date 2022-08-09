<?php
if (!empty($_POST) && !empty($_REQUEST['save'])) {
    // Adding Records
    $name  = $_POST['name'];
    $class = $_POST['class'];
    $marks = $_POST['marks'];

    $file = file_get_contents('student_data.json');
    $data = json_decode($file, true);
    $data["records"] = array_values($data["records"]);
    array_push($data["records"], $_POST);
    file_put_contents("student_data.json", json_encode($data));
    header("Location:jsonCRUD.php");
}
if (isset($_REQUEST["eid"])) {
    //Showing record in Feilds
    $id = $_REQUEST["eid"];
    $getfile = file_get_contents('student_data.json');
    $all = json_decode($getfile, true);
    $jsonfile = $all["records"];
    $jsonfileall = $jsonfile[$id];
    $jsonfile = $jsonfile[$id];
}
if (isset($_REQUEST["name"]) && !empty($_REQUEST['update'])) {
    //Editing and Updation existing records
    $id = $_REQUEST["eid"];
    $getfile = file_get_contents('student_data.json');
    $all = json_decode($getfile, true);
    $jsonfile = $all["records"];
    $jsonfileall = $jsonfile[$id];
    $jsonfile = $jsonfile[$id];
    $post["name"] = isset($_POST["name"]) ? $_POST["name"] : "";
    $post["class"] = isset($_POST["class"]) ? $_POST["class"] : "";
    $post["marks"] = isset($_POST["marks"]) ? $_POST["marks"] : "";

    if ($jsonfile) {
        unset($all["records"][$id]);
        $all["records"][$id] = $post;
        $all["records"] = array_values($all["records"]);
        file_put_contents("student_data.json", json_encode($all));
    }
    header("Location:jsonCRUD.php");
}
if (isset($_GET["did"])) {
    //Deleting Records
    $id = (int) $_GET["did"];
    $all = file_get_contents('student_data.json');
    $all = json_decode($all, true);
    $jsonfile = $all["records"];
    $jsonfile = $jsonfile[$id];

    if ($jsonfile) {
        unset($all["records"][$id]);
        $all["records"] = array_values($all["records"]);
        file_put_contents("student_data.json", json_encode($all));
    }
    header("Location:jsonCRUD.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="jsonCRUDstyle.css">
    <title>JSON CRUD</title>
</head>

<body>
    <?php
    $getfile = file_get_contents('student_data.json');
    $jsonfile = json_decode($getfile);
    ?>
    <div class="dataContainer">
        <h1 class="heading">JSON CRUD OPERATIONS</h1>
        <form method="POST">
            <table width="400px" class="felidTable">
                <tr>
                    <td>
                        <p class="nameFeild">Name :</p>
                        <input type="text" name="name" value="<?php if (!empty($jsonfileall['name'])) print_r($jsonfileall["name"])  ?>" required placeholder="Enter Name Here">
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="classFeild">Class :</p>
                        <input type="text" name="class" value="<?php if (!empty($jsonfileall['class'])) print_r($jsonfileall["class"]) ?>" required placeholder="Enter Class Here">
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="marksFeild">Total Marks :</p>
                        <input type="text" name="marks" value="<?php if (!empty($jsonfileall['marks'])) print_r($jsonfileall["marks"]) ?>" required placeholder="Enter Marks Here">
                    </td>
                </tr>
                <tr>
                    <td class="buttons">
                        <input type="submit" value="Save" name="save">
                        <input class="update" type="submit" value="Update" name="update">
                        <button class="reset"><a href="./jsonCRUD.php" style="text-decoration: none; color:black;">Reset</a></button>
                    </td>
                </tr>
            </table>
        </form>
        <hr>
        <h1>DATA ENTRIES</h1>
        <table border="1" width="1000px" class="displayData">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Class</th>
                <th>Marks</th>
                <th>Delete</th>
                <th>Edit</th>
            </tr><?php $no = 0;
                    foreach ($jsonfile->records as $index => $obj) : $no++;  ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $obj->name; ?></td>
                    <td><?php echo $obj->class; ?></td>
                    <td><?php echo $obj->marks; ?></td>
                    <td><button class="delete"><a href="./jsonCRUD.php?did=<?php echo $index; ?>"><i class="fa-regular fa-circle-xmark"></i>Delete</a></button></td>
                    <td><button class="edit"><a href="./jsonCRUD.php?eid=<?php echo $index; ?>"><i class="fa-regular fa-pen-to-square"></i>Edit</a></button> </td>
                </tr>
            <?php endforeach; ?>

        </table>
        <div class="dataContainer">
            <p>This is in a emergency branch</p>
            <img src="./1854889.jpg">
</body>

</html>