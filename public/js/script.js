function togg(id){
    let form = document.getElementById(id);
  if(getComputedStyle(form).display != "none"){
    form.style.display = "none";
  } else {
    form.style.display = "block";
  }
};

function addInput(submitButton, textArea){
  let submit = document.getElementById(submitButton);
  var content = document.getElementById(textArea).value;
  
  if(content == ""){
    submit.style.display = "none";
  } else {
    submit.style.display = "block";
  }
}