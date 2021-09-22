
member = (x) => {
        document.getElementById('staffContainer').style.display = 'none';
        document.getElementById('newMemberContainer').style.display = 'none';
        document.getElementById('loginTypeContainer').style.display = 'none'; 
        document.getElementById('loginTitle').style.display = 'none';
        document.getElementById('memberContainer').style.display = 'none';      

    if (x === 'memberContainer') {
        document.getElementById(x).style.display = 'block';       
    } else if (x === 'staffContainer'){
        document.getElementById(x).style.display = 'block';
    } else if (x === 'newMemberContainer') {
        document.getElementById(x).style.display = 'block';
    } else if (x === 'cancelMember'){       
        document.getElementById('loginTypeContainer').style.display = 'block';
        document.getElementById('loginTitle').style.display = 'block';
    } else if (x === 'cancelStaff'){       
        document.getElementById('loginTypeContainer').style.display = 'block';
        document.getElementById('loginTitle').style.display = 'block';
    } else if (x === 'cancelNewMember'){
        document.getElementById('loginTypeContainer').style.display = 'block';
        document.getElementById('loginTitle').style.display = 'block';
    }
}
showBox = (x) => {
    document.getElementById('editFirstName').style.display = 'none';
    document.getElementById('editSurname').style.display = 'none';
    document.getElementById('editUsername').style.display = 'none';
    document.getElementById('editEmail').style.display = 'none';
    document.getElementById('editPassword').style.display = 'none';
    document.getElementById('editUserImage').style.display = 'none';

    if (x === 'editFirstName'){
        document.getElementById(x).style.display = 'block';
    } else if (x === 'editSurname') {
        document.getElementById(x).style.display = 'block';
    } else if (x === 'editUsername') {
        document.getElementById(x).style.display = 'block';
    } else if (x === 'editEmail') {
        document.getElementById(x).style.display = 'block';
    } else if (x === 'editPassword') {
        document.getElementById(x).style.display = 'block';
    } else if (x === 'editUserImage') {
        document.getElementById(x).style.display = 'block';
    }   
}
hideBox = (x) => {
    document.getElementById(x).style.display = 'none';
}

mainPage = () => {
    window.location = 'mainPage.php'
}
cart= () => {
    window.location = 'cart.php'
}
display = () => {
    document.getElementById('viewCartContainer').style.display = 'none';
}


// This function hides the relevant page divs when a book is searched

showHideSearch = () => {
    let doesExist = document.getElementsByClassName('show')[0];
    let hideThis = document.getElementsByClassName('hide')[0];
    if (doesExist) {
        hideThis.style.display = 'none';
    } 
}


// This function shows more information about the author
hideSeeMore = () => {
    let bio = document.getElementsByClassName('authorBio');
    for (x = 0; x < bio.length; x ++) {
        let height = document.getElementsByClassName('authorBio')[x].offsetHeight;
        console.log(height);
        if (height < 180) {
            bio[x].nextElementSibling.style.display = 'none';
        }

        //[0]
    }
    console.log(bio); 
   
}

seeMore = (x) => {
    let seeMoreBio = x.parentNode;
    seeMoreBio.classList.toggle("expanded");
    const expanded = seeMoreBio.classList.contains("expanded");

    if (expanded) {
        x.innerHTML = "View Less";
    } else {
        x.innerHTML = "View More";
    } 
}; 