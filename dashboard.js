function addListeners(){
    const propertyContainers = document.getElementsByClassName("property-container");
    for(let i = 0; i <propertyContainers.length; i++){
        propertyContainers[i].addEventListener('click', onPropertyClick);
    }
}

function addDeleteListener(){
    document.getElementById("delete-button").addEventListener('click', submitDeletion);
}

function onAddPropertyClick(){
    window.location.href = "add_property.php";
}

function onPropertyClick(event){
    const propertyContainer = event.currentTarget;
    document.cookie = "property_id=" + propertyContainer.id;
    window.location.href = "view_property.php";
}

function onLogoutClick(event){
    const logoutButton = document.getElementById("logout");
    logoutButton.click();
}

function editProperty(){
    window.location.href = "edit_property.php";
}

function deleteProperty(){
    if(confirm("Are you sure you want to delete this property? This action is permanent.")) {
        document.cookie = "delete_property_id=" + document.getElementById("delete-button").className.trim();
        return true;
    } else {
        return false;
    }
}

function submitDeletion(event){
    if(event.target.id == "delete-submit") return;
    const submitButton = document.getElementById("delete-submit");
    submitButton.click();
}

function toDashboard(){
    window.location.href = "dashboard.php";
}