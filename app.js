const form = document.getElementById('emailForm');

const success = document.createElement('div');
success.setAttribute("id", "success");
success.style.cssText = "opacity: 0;transition: opacity .3s ease;position: absolute;top: 20%;left: 50%;transform: translateX(-50%);background-color: lightgreen;border: solid 1px darkgreen;color: darkgreen;font-weight: bold;";

const error = document.createElement('div');
error.setAttribute("id", "error");
error.style.cssText = "opacity: 0;transition: opacity .3s ease;position: absolute;top: 20%;left: 50%;transform: translateX(-50%);background-color: yellow;border: solid 1px red;color: red;font-weight: bold;";

function postData(formattedFormData) {
    fetch("./process.php",
        {
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            method: 'POST',

            body: JSON.stringify(formattedFormData)
        }).then(function (res) {
        if (res.ok) {
            return res.json();
        } else {
            console.error(res);
        }
    })
        .then(function (value) {
            console.log(value);
            console.log(value['code'] + " " + value['status']);

            if (value['code'] === "200") {
                resetForm(form);
                success.textContent = "Message bien envoyé";
                show(success)
                setTimeout(() => {
                    hide(success);
                }, 3000);
            } else {
                document.body.prepend(error);
                error.textContent = value['status'];
                show(error)
                setTimeout(() => {
                    hide(error);
                }, 3000);
            }
        });
}

function hide(elt) {
    elt.style.opacity = "0";
    setTimeout(() => {
        elt.remove();
    }, 500);
}

function show(elt) {
    document.body.prepend(elt);
    setTimeout(() => {
        elt.style.opacity = "1";
    }, 300);
}

function resetForm(form) {
    for (let i = 0; i<form.length; i++) {
        form[i].value = "";
    }
}

form.addEventListener('submit', function(event){
    event.preventDefault();
    const formattedFormData = {
        name: this.name.value,
        firstName: this.firstName.value,
        mail: this.mail.value,
        society: this.society.value,
        message: this.message.value
    };
    console.log(formattedFormData);
    postData(formattedFormData);
});

