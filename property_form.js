const errorStyle = "border: 1px solid red; ";

function validateForm(){
    var isValid = true;
    const inputs = document.getElementsByTagName("input");
    const textAreas = document.getElementsByTagName("textarea");
    const submitValue = document.getElementById("submit").value;
    for(const input of inputs) {
        if(submitValue == "Update Property" && input.id == "floor-plan") continue;
        if(!isFilled(input)) isValid = false;
        if(input.type == "number"){
            if(!hasOnlyDigits(input.value)) {
                console.log(input.id + " is not only digits");
                input.style  = errorStyle;
                isValid = false
            }
        }
    }
    for(const textArea of textAreas) {
        if(!isFilled(textArea)) isValid = false;
    }
    return isValid;
}

function isFilled(input){
    if(input.value == null){
        console.log(input.id + " is null");
        input.style = errorStyle;
        return false;
    }
    input.value = input.value.trim();
    if(input.value.length == 0){
        console.log(input.id + " is empty");
        input.style = errorStyle;
        return false;
    }
    return true;
}

function hasOnlyDigits(value) {
    return /^-?\d+$/.test(value);
}

function onCancelClick(){
    window.location.href = 'dashboard.php';
}