<?php
include "config.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Assistant' rel='stylesheet'>
    <script src="js/script.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <title>Oops!e</title>
</head>

<body id="listPage" onload="list()">
    <header>
        <img id="ham" src="./images/list.svg" alt="ham" title="ham">
        <a href="./homePage.php"></a>
        <section class="lastItem">
            <img class="utilities" src="./images/bell.svg" alt="notification" title="notification">
            <img class="utilities" src="./images/search.svg" alt="search" title="search">
        </section>
    </header>
    <div id="wrapper">
        <main>
            <section id="h1Section">
                <article id="My"></article>
                <h1>Parking Lots</h1>
            </section>
            <section id="list">
                <!--Section of all the lists-->
                <section id="myParkingList">
                    <section>
                        <h2> My Parking Lots </h2>
                        <article id="addParking" onclick="openForm()"></article>
                        <img class="utilities" src="./images/pencil.svg" alt="edit" title="edit">
                    </section>
                    <ul id="my"></ul>
                </section>

                <section id="familyParkingList">
                    <h2>
                        Family Parking Lots
                    </h2>
                    <ul id="family"></ul>
                </section>
                <section id="friendsParkingList">
                    <h2>
                        Friends Parking Lots
                    </h2>
                    <ul id="friends"></ul>
                </section>
            </section>


            <div id="formOverlay">
                <section id="frontOverlay">
                    <article>New Parking</article>

                    <form id="myForm">
                        <label for="parkingId">Parking ID:<input type="text" id="parkingId" name="parkingId" pattern="[0-9]{6}" required></label>
                        <label for="pName">Parking Name:<input type="text" id="pName" name="name" pattern="[A-Za-z]{3,6}" required></label>
                        <article>Add Cars</article>
                        <section id="carSection">
                            <label for="car">Car plate number:
                                <input type="text" id="car" name="cars[]" pattern="[0-9]{7,8}">
                            </label>
                            <input class="add" type="button" onclick="addElement('car')" value="Add">
                            <section id="addedCars">
                            </section>
                        </section>
                        <aside id="carError"></aside>
                        <article>Add Members</article>
                        <section id="membersForm">
                            <label for="memb">User Name:<input type="text" id="memb" name="members" pattern="[A-Za-z]{3,6}"></label>
                            <label for="op">Permmision type:
                                <select id="op" name="op">
                                    <option value="Main user"> Main user </option>
                                    <option value="Secondary user"> Secondary user </option>
                                </select>
                            </label>
                            <input class="add" type="button" onclick="addElement('memb')" value="Add">
                            <section id="addedMem">
                            </section>
                        </section>
                        <aside id="membError"></aside>
                        <label>Set this Parking as default?<input type="checkbox" id="default" name="default"></label>
                        <section class="saveOrCancel">
                            <input class="formButton" type="submit" value="Save">
                            <input class="formButton" type="button" onclick="closeForm()" value="Cancel">
                        </section>
                    </form>
                </section>
            </div>
        </main>
        <aside id="asideTablet">
            <section id="asideDis">
                <h1>My Parking</h1>
                <img id="parkingImg" src="./images/parking.png">
                <nav class="tab">
                    <button onclick="contentSwitch(1)">Car Info</button>
                    <button onclick="contentSwitch(2)">My Cars</button>
                    <button onclick="contentSwitch(3)">Add</button>
                </nav>
                <article id="unknown">
                    <br>
                    <h1>Car info</h1>
                    <br>
                    <?php
                    $query = "SELECT * FROM `tbl_228_cars` WHERE known=0";
                    $result = mysqli_query($connection, $query);
                    if (!$result)
                        die("unknown");
                    ?>
                    <ul id='carInfoPopUp'>
                        <?php
                        if ($row = mysqli_fetch_assoc($result)) {
                            echo "<li>Car owner: " . $row["carOwner"] . "</li>";
                            echo "<li>Car model: " . $row["carModel"] . "</li>";
                            echo "<li>Color: " . $row["color"] . "</li>";
                            echo "<li>Plate No: " . $row["plate"] . "</li>";
                            echo "</ul><br>
                                <label>Do you recognize this vehicle?</label>
                                <form method=POST>
                                    <input name='parkingId' value=1 hidden>
                                    <label for='owner'>Car owner: <input type='text' id='owner' name='owner' pattern='[A-Za-z]{3,15}'></label>
                                    <section class='saveOrCancel'>
                                        <input type='submit' value='Save'>
                                        <input type='button' id='close' onclick='togglePopup()' value='Close'>
                                    </section>
                                </form>";
                        } else {
                            echo "There is no car parking";
                        }
                        $owner = $_POST['owner'] ?? null;
                        if ($owner)
                            mysqli_query($connection, "UPDATE tbl_228_cars SET carOwner='$owner', known='1' WHERE id=$row[id]");
                        mysqli_free_result($result);
                        ?>
                </article>

                <article id="viewAll">
                    <br>
                    <h1>Registered cars</h1>
                    <section>
                        <?php
                        $query = "SELECT * FROM tbl_228_cars WHERE known=1";
                        $result = mysqli_query($connection, $query);
                        if (!$result)
                            die("all cars");
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<aside><ul><li>Car Owner: " . $row["carOwner"] . "</li>";
                            echo "<li>Car Model: " . $row["carModel"] . "</li>";
                            echo "<li>Color: " . $row["color"] . "</li>";
                            echo "<li>Plate: " . $row["plate"] . "</li></ul>";
                            echo '<a href="homePage.php?del=' . $row["id"] . '"><img src="./images/trash.svg" alt="delete" title="delete"></a></aside>';
                        }
                        $id = $_GET['del'] ?? null;
                        if ($id)
                            mysqli_query($connection, "DELETE FROM tbl_228_cars WHERE id='$id'");
                        ?>
                    </section>
                </article>
                <article id="addCar">
                    <br>
                    <h1>Add a new car</h1>
                    <?php
                    echo "<form method=POST>
                            <label>Car Owner:<input name='caro' type='text' pattern='[A-Za-z]{3,15}'></label>
                            <label>Car Model:<input name='carm' type='text' pattern='[A-Za-z]{3,30}'></label>
                            <label>Color:<input name='color' type='text' pattern='[A-Za-z]{3,15}'></label>
                            <label>Plate:<input name='plate' type='text'></label>
                            <input type='submit' value='Add'>
                            </form>";

                    $caro = $_POST['caro'] ?? null;
                    $carm = $_POST['carm'] ?? null;
                    $color = $_POST['color'] ?? null;
                    $plate = $_POST['plate'] ?? null;

                    if ($caro && $caro && $color && $plate)
                        mysqli_query($connection, "INSERT INTO tbl_228_cars (parkingId, known, carOwner, carModel, color, plate) VALUES ('1', '1', '$caro', '$carm', '$color','$plate')");
                    mysqli_close($connection);
                    ?>
                </article>
            </section>
        </aside>
    </div>
</body>

</html>