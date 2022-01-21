const form = document.querySelector("form");
const emailInput = form.querySelector('input[name="email"]');
const confirmedPasswordInput = form.querySelector('input[name="passwordConfirm"]');
const passwordInput = form.querySelector('input[name="password"]');

function isEmail(email)
{
    return /\S+@\S+.\S+/.test(email);
}

function arePasswordsSame(password,ConfirmationPassword)
{
    return password === ConfirmationPassword;
}

function markValidation(element, condition)
{
    !condition ? element.classList.add('not-valid') : element.classList.remove('not-valid');
}



function validateEmail()
{
    setTimeout(function ()
        {
            markValidation(emailInput,isEmail(emailInput.value));
        },
        700);
}

emailInput.addEventListener('keyup',validateEmail);



function validatePassword()
{
    setTimeout(function ()
        {
            const condition = arePasswordsSame(
                passwordInput.value,
                confirmedPasswordInput.value
            )

            markValidation(confirmedPasswordInput,condition);
        },
        700);
}

confirmedPasswordInput.addEventListener('keyup',validatePassword);