let carArr = [];
let memArr = [];

checkMediaQuery = () => {
    try {
        if (window.innerWidth < 768 && location.pathname == "homePage.php") {
            document.getElementById("asideTablet").style.display = "none";
            document.getElementById("asideDis").style.display = "none";
        }
        if (window.innerWidth > 768 && location.pathname != "homePage.php")
            location.href = "homePage.php";
        else
            document.getElementById("asideTablet").style.display = "flex";
    }
    catch (err) { }
}

// Add a listener for when the window resizes
window.addEventListener('resize', checkMediaQuery);

list = () => fetch("./json/users.json").then(res => {
    return res.json();
}).then(arr => {
    try {
        for (i in arr) {
            for (j of arr[i]) {
                if (j.name) {
                    document.getElementById(i).innerHTML +=
                        `<li class="rectangle" name="myParkingLots[]" id="${j.name}">
                            <button class="parkingList" onclick=goParking('${j.name}')>
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
                        </li>`;
                }
                else
                    document.getElementById(i).innerHTML += `<li id="none">NONE</li>`;
            }
            if (i != "friends")
                document.getElementById(i).innerHTML += `<hr class="line">`;
        }
    }
    catch (err) { }
});

goParking = (name) => {
    let id = 1;
    if (name == "Tom")
        id = 2;
    else if (name == "Yoni")
        id = 3;
    if (window.getComputedStyle(wrapper, null).getPropertyValue("display") == "block")
        location.href = "parkingPage.php?parkingId=" + id;
    else {
        if (name == "Lital")
            document.getElementById("asideDis").style.display = "flex";
        else
            document.getElementById("asideDis").style.display = "none";
    }
}

whichParking = () => {
    let names = ["My", "Tom", "Yoni"]
    const id = new URLSearchParams(window.location.search).get('parkingId')
    document.getElementById('h1Section').innerHTML = `
        <article id="${names[id - 1] == "My" ? "My" : names[id - 1] + "s"}"></article>
        <h1>${names[id - 1] == "My" ? "My" : names[id - 1] + "'s"} Parking</h1>`;
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
    try {
        document.getElementById('owner').value = "";
    } catch (err) { };
    document.getElementById("popup-1").classList.toggle("active");
}

collapse = () => {
    if (document.getElementsByClassName("arrow")[0].style.transform == "rotate(90deg)")
        document.getElementsByClassName("arrow")[0].style.transform = "rotate(270deg)";
    else
        document.getElementsByClassName("arrow")[0].style.transform = "rotate(90deg)";
}

contentSwitch = (i) => {
    if (i == 1) {
        document.getElementById("unknown").style.display = "block";
        document.getElementById("viewAll").style.display = "none";
        document.getElementById("addCar").style.display = "none";
    }
    else if (i == 2) {
        document.getElementById("unknown").style.display = "none";
        document.getElementById("viewAll").style.display = "block";
        document.getElementById("addCar").style.display = "none";
    }
    else {
        document.getElementById("unknown").style.display = "none";
        document.getElementById("viewAll").style.display = "none";
        document.getElementById("addCar").style.display = "block";
    }
}
