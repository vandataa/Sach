const name = document.querySelector("#name");
const email = document.querySelector("#email");
const address = document.querySelector("#address");
const phone = document.querySelector("#phone");
const submit = document.getElementById("oke");
const cancel = document.getElementById("cancel");
const btn = document.getElementById("edit");

const password = document.querySelector("#password");
const newpass = document.querySelector("#newpass");
const confirmpass = document.querySelector("#confirmpass");
const submitpass = document.getElementById("okepass");
const cancelpass = document.getElementById("cancelpass");
const btnpass = document.getElementById("editpass");

if (btn) {
    btn.addEventListener("click", function () {
        submit.classList.toggle("d-none");
        cancel.classList.toggle("d-none");
        btn.classList.toggle("d-none");
        name.disabled = !name.disabled;
        email.disabled = !email.disabled;
        address.disabled = !address.disabled;
        phone.disabled = !phone.disabled;
    });
}
if (cancel) {
    cancel.addEventListener("click", function () {
        submit.classList.toggle("d-none");
        cancel.classList.toggle("d-none");
        btn.classList.toggle("d-none");
        name.disabled = !name.disabled;
        email.disabled = !email.disabled;
        address.disabled = !address.disabled;
        phone.disabled = !phone.disabled;
    });
}
if (btnpass) {
    btnpass.addEventListener("click", function () {
        submitpass.classList.toggle("d-none");
        cancelpass.classList.toggle("d-none");
        btnpass.classList.toggle("d-none");
        password.disabled = !password.disabled;
        newpass.disabled = !newpass.disabled;
        confirmpass.disabled = !confirmpass.disabled;
    });
}
if (cancelpass) {
    cancelpass.addEventListener("click", function () {
        submitpass.classList.toggle("d-none");
        cancelpass.classList.toggle("d-none");
        btnpass.classList.toggle("d-none");
        password.disabled = !password.disabled;
        newpass.disabled = !newpass.disabled;
        confirmpass.disabled = !confirmpass.disabled;
    });
}
