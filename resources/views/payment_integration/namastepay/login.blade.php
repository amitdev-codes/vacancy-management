<!-- jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<style>
    /* Importing fonts from Google */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

    /* Reseting */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {
        background: #ecf0f3;
    }

    .wrapper {
        max-width: 350px;
        min-height: 400px;
        margin: 80px auto;
        padding: 40px 30px 30px 30px;
        background-color: #ecf0f3;
        border-radius: 15px;
        box-shadow: 13px 13px 20px #cbced1, -13px -13px 20px #fff;
    }

    .logo {
        width: 80px;
        margin: auto;
    }

    .logo img {
        width: 100%;
        height: 80px;
        object-fit: cover;
        border-radius: 10%;
        box-shadow: 0px 0px 3px #5f5f5f,
        0px 0px 0px 5px #ecf0f3,
        8px 8px 15px #a7aaa7,
        -8px -8px 15px #fff;
    }

    .wrapper .name {
        font-weight: 600;
        font-size: 1.4rem;
        letter-spacing: 1.3px;
        padding-left: 0px;
        color: #555;
    }

    .wrapper .form-field input {
        width: 100%;
        display: block;
        border: none;
        outline: none;
        background: none;
        font-size: 1.2rem;
        color: #666;
        padding: 10px 15px 10px 10px;
        /* border: 1px solid red; */
    }

    .wrapper .form-field {
        padding-left: 10px;
        margin-bottom: 20px;
        border-radius: 20px;
        box-shadow: inset 8px 8px 8px #cbced1, inset -8px -8px 8px #fff;
    }

    .wrapper .form-field .fas {
        color: #555;
    }

    .wrapper .btn {
        box-shadow: none;
        width: 100%;
        height: 40px;
        background-color: #03A9F4;
        color: #fff;
        border-radius: 25px;
        box-shadow: 3px 3px 3px #b1b1b1,
        -3px -3px 3px #fff;
        letter-spacing: 1.3px;
    }

    .wrapper .btn:hover {
        background-color: #039BE5;
    }

    .wrapper a {
        text-decoration: none;
        font-size: 0.8rem;
        color: #03A9F4;
    }

    .wrapper a:hover {
        color: #039BE5;
    }

    @media (max-width: 380px) {
        .wrapper {
            margin: 30px 20px;
            padding: 40px 15px 15px 15px;
        }
    }
</style>
<!-- Custom CSS -->
<div class="wrapper">
    <div class="logo">
        <img src="{{ asset('images/namastepay.png') }}" style="width:100px">
    </div>
    <form class="p-5 mt-5" method="post" action="{{route('namastePayLogin')}}" id="namastePayForm">
        @csrf
        <div class="form-field  d-flex align-items-center" style="margin-top: 15%;">
            <input type="text" name="name" id="name" placeholder="Enter Mobile Number">
            <span id="nameError" class="error"></span>
        </div>
        <button class="btn mt-3">Proceed</button>
        <a href="{{route('AdminVacancyApplyControllerGetIndex')}}"  class="btn mt-3" style="font-size: medium;color: white;margin-top: 17px;">Cancel</a>
    </form>
</div>
<script>
    const nameField = document.getElementById('name');
    const pinField = document.getElementById('pin');
    const nameError = document.getElementById('nameError');
    const pinError = document.getElementById('pinError');

    function validateForm() {
        let valid = true;
        const phoneNumberPattern = /^\d{10}$/;
        if (!phoneNumberPattern.test(nameField.value)) {
            nameError.innerText = 'Please enter a valid phone number.';
            valid = false;
        } else {
            nameError.innerText = '';
        }
        return valid;
    }

    const form = document.getElementById('namastePayForm');
    form.addEventListener('submit', (event) => {
        if (!validateForm()) {
            event.preventDefault();
        }
    });
</script>
