const modal = document.getElementById("authModal");
const modalTitle = document.getElementById("modalTitle");
const formTypeInput = document.getElementById("formType");
const submitBtn = document.getElementById("submitBtn");
const toggleForm = document.getElementById("toggleForm");

function openModal(type) {
    modal.style.display = "flex";
    if (type === "signup") {
        modalTitle.innerText = "Signup";
        submitBtn.innerText = "Signup";
        formTypeInput.value = "signup";
        toggleForm.innerText = "Already have an account? Login";
    } else {
        modalTitle.innerText = "Login";
        submitBtn.innerText = "Login";
        formTypeInput.value = "login";
        toggleForm.innerText = "Don't have an account? Signup";
    }
}
function closeModal() { modal.style.display = "none"; }
toggleForm.addEventListener("click", () => {
    if (modalTitle.innerText === "Login") { openModal("signup"); }
    else { openModal("login"); }
});
window.onclick = function(event) { if (event.target == modal) modal.style.display = "none"; };
