
member = (x) => {
    if (x === 'memberContainer') {
        document.getElementById(x).style.display = 'block';
        document.getElementById('staffContainer').style.display = 'none';
        document.getElementById('newMemberContainer').style.display = 'none';
        document.getElementById('loginTypeContainer').style.display = 'none'; 
        document.getElementById('loginTitle').style.display = 'none';
    } else if (x === 'staffContainer'){
        document.getElementById(x).style.display = 'block';
        document.getElementById('memberContainer').style.display = 'none'; 
        document.getElementById('newMemberContainer').style.display = 'none';
        document.getElementById('loginTypeContainer').style.display = 'none';
        document.getElementById('loginTitle').style.display = 'none';
    } else if (x === 'newMemberContainer') {
        document.getElementById(x).style.display = 'block';
        document.getElementById('memberContainer').style.display = 'none'; 
        document.getElementById('staffContainer').style.display = 'none';
        document.getElementById('loginTypeContainer').style.display = 'none';
        document.getElementById('loginTitle').style.display = 'none';
    } else if (x === 'cancelMember'){
        document.getElementById('memberContainer').style.display = 'none'; 
        document.getElementById('loginTypeContainer').style.display = 'block';
        document.getElementById('loginTitle').style.display = 'block';
    } else if (x === 'cancelStaff'){
        document.getElementById('staffContainer').style.display = 'none';
        document.getElementById('loginTypeContainer').style.display = 'block';
        document.getElementById('loginTitle').style.display = 'block';
    } else if (x === 'cancelNewMember'){
        document.getElementById('newMemberContainer').style.display = 'none';
        document.getElementById('loginTypeContainer').style.display = 'block';
        document.getElementById('loginTitle').style.display = 'block';
    }
}
showBox = (x) => {
    document.getElementById(x).style.display = 'block';
}
hideBox = (x) => {
    document.getElementById(x).style.display = 'none';
}
showPicBox = () => {
    document.getElementById('editUserimage').style.display = 'block';
}
hidePicBox = () => {
    document.getElementById('editUserimage').style.display = 'none';
}
addToCart = () => {
    console.log("x");
}

