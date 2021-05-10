let carArr = [];
let memArr = [];
let tabInfo = [];

// checkMediaQuery = () => {
//     try {
//         // If the inner width of the window is greater then 768px
//         if (window.innerWidth < 768) {
//             // Then log this message to the console
//             document.getElementById("asideTablet").style.display = "none";
//             document.getElementById("asideDis").style.display = "none";
//             document.getElementById("Lital").style.backgroundColor = "";

//         }
//         else {
//             if (location.pathname == "/parkingPage.html")
//                 location.href = "index.html";
//             document.getElementById("asideTablet").style.display = "flex";
//         }
//     }
//     catch (err) { }
// }
checkMediaQuery = () => {
    try {
        // If the inner width of the window is greater then 768px
        if (window.innerWidth < 768 && location.pathname == "/students/2020-2021/web1/dev_206/index.html") {
            // Then log this message to the console
            document.getElementById("asideTablet").style.display = "none";
            document.getElementById("asideDis").style.display = "none";
            document.getElementById("Lital").style.backgroundColor = "";
        }
        else {
            if (window.innerWidth > 768 && location.pathname == "/students/2020-2021/web1/dev_206/parkingPage.html")
                location.href = "/students/2020-2021/web1/dev_206/index.html";
            else
                document.getElementById("asideTablet").style.display = "flex";
        }
    }
    catch (err) { }
}

// Add a listener for when the window resizes
window.addEventListener('resize', checkMediaQuery);

fetch("./json/carInfo.json").then(info => {
    return info.json();
}).then(carInfo => {
    try {
        tabInfo = carInfo;
        document.getElementById('contentOne').innerHTML =
            `<div class="close-btn" onclick="togglePopup()">&times;</div>
            <h1>Car info</h1>
            <br>
            <ul id="carInfoPopUp">
                <li>Car owner: ${carInfo.unknownCar[0].carOwner}</li>
                <li>Car model: ${carInfo.unknownCar[0].carModel}</li>
                <li>Color: ${carInfo.unknownCar[0].color}</li>
                <li>Plate No: ${carInfo.unknownCar[0].plate}</li>
            </ul>`;
    }
    catch (err) { }
});

list = () => fetch("./json/users.json").then(res => {
    return res.json();
}).then(arr => {
    try {
        for (i in arr) {
            for (j of arr[i]) {
                if (j.name) {
                    document.getElementById(i).innerHTML +=
                        `<li class="rectangle" name="myParkingLots[]" id="${j.name}">
                            <button class="parkingList" onclick="${i == 'my' ? 'my' : j.name}Parking()">
                            <article>
                                <img class="user" src="${j.img}">
                            </article>
                            <h2>${i == 'my' ? 'My' : j.name + '\'s'} Parking</h2>
                            <section class="statusBox">
                                <article class="trafficLight" id="${j.status}"></article>
                                <span>${j.status == 'Attention' ? j.status + '!' : j.status}</span>
                            </section>
                            </button>
                            <section class="bottomOptionTablet">
                                <section><img src="./images/Local_Fire_Department_Icon_3.png">Actions</section>
                                <section><img src="./images/Insert_Chart_Outlined_Icon_3.png">Analysis</section>
                                <section><img src="./images/Group_18.png">Analysis</section>
                                <section><img src="./images/Directions_Car_Icon_3.png">Cars</section>
                                <section><img src="./images/Event_Available_Icon_3.png">Events</section>
                            </section>
                            </button>
                        </li><br>`;
                }
                else
                    document.getElementById(i).innerHTML += `<li id="none">NONE</li>`;
            }
            if (i != "friends")
                document.getElementById(i).innerHTML += `<hr class="line">`;
        }
        document.getElementById('asideTablet').innerHTML += `
            <section id="asideDis">
            <h1>My Parking</h1>
            <img id="parkingImg" src="./images/parking.png"><article>
                ${tabInfo.unknownCar[0].carOwner}
                <br>
                ${tabInfo.unknownCar[0].carModel}
                <br>
                ${tabInfo.unknownCar[0].color}
                <br>
                ${tabInfo.unknownCar[0].plate}
                </article>
            </section>`;
    }
    catch (err) { }
});

myParking = () => {
    if (window.getComputedStyle(wrapper, null).getPropertyValue("display") == "block")
        location.href = "parkingPage.html";
    else {
        document.getElementById("asideDis").style.display = "flex";
        document.getElementById("Lital").style.backgroundColor = "#222222";
    }
}

TomParking = () => {
    location.href = "#";
}

YoniParking = () => {
    location.href = "#";
}

openForm = () => {
    document.getElementById("formOverlay").style.display = "block";
}

closeForm = () => {
    document.getElementById("formOverlay").style.display = "none";
    carArr = [];
    memArr = [];
    document.getElementById('addedCars').innerHTML = "";
    document.getElementById('addedMem').innerHTML = "";
    document.getElementById("myForm").reset();
}

addElement = (arr) => {
    if (document.getElementById(arr).value) {
        if (arr == "car") {
            if (document.getElementById(arr).checkValidity()) {
                carArr[carArr.length] = document.getElementById(arr).value;
                document.getElementById('carError').innerHTML = "";
                viewElements("Cars");
            }
            else
                document.getElementById('carError').innerHTML = `Must be valid plate (7-8 numbers)`;
        }
        else {
            if (document.getElementById('memb').checkValidity()) {
                memArr[memArr.length] = [document.getElementById(arr).value, document.getElementById("op").value];
                document.getElementById('membError').innerHTML = "";
                viewElements("Mem");
            }
            else
                document.getElementById('membError').innerHTML = "Only letters (3-6 characters)";
        }
        document.getElementById(arr).value = "";
    }
}

viewElements = (data) => {
    if (data == "Cars") {
        document.getElementById("addedCars").innerHTML = "";
        for (i in carArr)
            document.getElementById("addedCars").innerHTML += `<article class="cube">${carArr[i]}<img class="clickAble" id="car${i}" src="images/trash.svg" onclick="removeElement(this.id)"></article>`;
    }
    else {
        document.getElementById("addedMem").innerHTML = "";
        for (i in memArr)
            document.getElementById("addedMem").innerHTML += `<article class="cube">${memArr[i]}<img  class="clickAble" id="memb${i}" src="images/trash.svg" onclick="removeElement(this.id)"></article>`;
    }
}

removeElement = (index) => {
    if (!index.split('car')[0]) {
        carArr.splice(index.split('car')[1], 1);
        index = "Cars";
    }
    else
        memArr.splice(index.split('memb')[1], 1);
    viewElements(index);
}

togglePopup = () => {
    document.getElementById("popup-1").classList.toggle("active");
}

collapse = () => {
    document.getElementsByClassName("collapsible")[0].classList.toggle("active");
    if (document.getElementsByClassName("collapsible")[0].nextElementSibling.style.display === "block") {
        document.getElementsByClassName("collapsible")[0].nextElementSibling.style.display = "none";
        document.getElementsByClassName("arrow")[0].style.transform = "rotate(270deg)";
    }

    else {
        document.getElementsByClassName("collapsible")[0].nextElementSibling.style.display = "block";
        document.getElementsByClassName("arrow")[0].style.transform = "rotate(90deg)";
    }
}
