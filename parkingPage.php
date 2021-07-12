<?php
include "config.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Assistant' rel='stylesheet'>
    <script src="js/script.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <script>
        $(function() {
            $("#accordion").accordion({
                active: false,
                collapsible: true
            });
        });
    </script>
    <title>Oops!e</title>
</head>

<body id="mainObjectLayout" onload="checkMediaQuery(),whichParking()">
    <header>
        <img id="ham" src="./images/list.svg" alt="ham" title="ham">
        <a href="./homePage.html"></a>
        <section class="lastItem">
            <img class="utilities" src="./images/bell.svg" alt="notification" title="notification">
            <img class="utilities" src="./images/search.svg" alt="search" title="search">
        </section>
    </header>
    <div id="wrapper">
        <main>
            <section id="h1Section">
                <article></article>
                <h1>My Parking</h1>
            </section>
            <section id="carAndVid">
                <button onclick="togglePopup()">
                    <span id="carInfo"></span>
                </button>
                <img class="utilities" src="./images/camera-video.svg" alt="video" title="video">
            </section>
            <ul id="parkingRec">
                <li>
                    <div id="accordion">
                        <button class="parkingButton" onclick="collapse()">
                            <span id="action"></span>
                            <span>Action</span>
                            <img class="arrow" src="./images/arrow.svg" title="arrow" alt="arrow">
                        </button>
                        <div class="content">
                            <button><img id="tow" src="./images/tow.png" alt="tow" title="tow">
                                Tow it
                            </button>
                            <hr>
                            <button><img id="objects" src="./images/objects.png" alt="objects" title="objects">
                                Objects
                            </button>
                            <hr>
                            <button><img id="identify" src="./images/person.png" alt="person" title="person">
                                Identify
                            </button>
                            <hr>
                            <button><img id="puncture" src="./images/spike.png" alt="spike" title="spike">
                                Puncture
                            </button>
                        </div>
                    </div>
                </li>
                <li>
                    <button class="parkingButton">
                        <span id="analysis"></span>
                        <span>Analysis</span>
                        <img class="arrow" src="./images/arrow.svg" title="arrow" alt="arrow">
                    </button>
                </li>
                <li>
                    <button class="parkingButton">
                        <span id="members"></span>
                        <span>Events</span>
                    </button>
                </li>
                <li>
                    <button class="parkingButton">
                        <span id="cars"></span>
                        <span>Cars</span>
                    </button>
                </li>
                <li>
                    <button class="parkingButton">
                        <span id="events"></span>
                        <span>Events</span>
                    </button>
                </li>
            </ul>

            <div class="popup" id="popup-1">
                <div class="overlay"></div>
                <section id="contentOne">
                    <div class="close-btn" onclick="togglePopup()">&times;</div>
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
                                <form action='parkingPage.php?parkingId=1' method=POST>
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
                                echo '<a href="parkingPage.php?parkingId=1&del=' . $row["id"] . '"><img src="./images/trash.svg" alt="delete" title="delete"></a></aside>';
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
                        echo "<form action='parkingPage.php?parkingId=1&ins=true' method=POST>
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
            </div>
        </main>
    </div>

</body>

</html>