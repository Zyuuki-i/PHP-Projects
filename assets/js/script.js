document.addEventListener("DOMContentLoaded", function () {
    const alertBox = document.querySelector(".alert");
    if (alertBox) {
        setTimeout(() => alertBox.style.display = "none", 3000);
    }
});
function changeImage(element) {
        document.getElementById("anhChinh").src = element.src;
        document.querySelectorAll(".thumb-img").forEach(el => el.classList.remove("active"));
        element.classList.add("active");
    }

document.addEventListener("DOMContentLoaded", function () {
    const btnGiam = document.querySelector(".btn-giam");
    const btnTang = document.querySelector(".btn-tang");
    const inputSL = document.querySelector(".soluong");
    const hiddenInputs = document.querySelectorAll(".sl-hidden"); 

    function updateQuantity(val) {
        inputSL.value = val;
        hiddenInputs.forEach(input => input.value = val);
    }

    if(btnTang && btnGiam && inputSL) {
        btnGiam.addEventListener("click", () => {
            let val = parseInt(inputSL.value) || 1;
            if (val > 1) updateQuantity(val - 1);
        });

        btnTang.addEventListener("click", () => {
            let val = parseInt(inputSL.value) || 1;
            updateQuantity(val + 1);
        });

        inputSL.addEventListener("change", () => {
            let val = parseInt(inputSL.value) || 1;
            if (val < 1) val = 1;
            updateQuantity(val);
        });
    }
    const inputs = document.querySelectorAll(".input-soluong");
    inputs.forEach(input => {
        input.addEventListener("change", function() {
            let val = parseInt(this.value);
            if (isNaN(val) || val < 1) {
                this.value = 1;
            }
        });
    });
});