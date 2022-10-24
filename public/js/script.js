function togg(id){
    let form = document.getElementById(id);
  if(getComputedStyle(form).display != "none"){
    form.style.display = "none";
  } else {
    form.style.display = "block";
  }
};