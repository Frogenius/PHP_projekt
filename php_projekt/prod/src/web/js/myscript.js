$(document).ready(function () { 
    $(".muvediv").draggable({ cursor: "move" });
});

function nav() {   
    $("div#nav ul li").mouseover(function () {
        $(this).find("ul:first").show();
    });
    $("div#nav ul li").mouseleave(function () {
        $("div#nav ul li ul").hide();
    });
    $("div#nav ul li ul").mouseleave(function () {
        $("div#nav ul li ul").hide(); ;
    });
};

$(document).ready(function () {
    nav();
});
function onloadname(){
	document.getElementById("auphoto").value = localStorage.getItem("myname77");
	document.getElementById("hiname").textContent = localStorage.getItem("myname77");
}
function onliname(){
	
	document.getElementById("hiname").textContent = localStorage.getItem("myname77");
}
function snameinp(sname, sid) {
	 
    localStorage.setItem("myname77", sname)
	localStorage.setItem("mysid", sid)
    document.getElementById("hiname").textContent = localStorage.getItem("myname77") + ", Drzeń dobry! ";
    //localStorage.clear();
   
}
function nameinp(form) {
    localStorage.setItem("myname77", form.youname.value)
    document.getElementById("hiname").textContent = localStorage.getItem("myname77") + ", Drzeń dobry! ";    
    alert("loc:" + localStorage.getItem("myname77"));
}
function onloadform() {
    document.getElementById("hiname").textContent = localStorage.getItem("myname77") + ", Drzeń dobry!  ";
}

function sendletter(form) {
    letters(form);
    form.submit();
}
function letters() {
    document.getElementById("train").style.left = '450px';
}
function messsen() {
    
}
function fieldAnketa(id, value) {
    
    sessionStorage.setItem(id, value);
    

}
function onloadAnketa() {


    document.getElementById('youname').value = sessionStorage.getItem('youname');
    document.getElementById('email').value = sessionStorage.getItem('email');
    document.getElementById('tel').value = sessionStorage.getItem('tel');
    document.getElementById('holiday').value = sessionStorage.getItem('holiday');
    
}

