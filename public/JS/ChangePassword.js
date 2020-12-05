let App = {

    DivForm : document.querySelector(".ChangePassword_Form"),
    ChangePass_Link : document.querySelector(".ChangePassword_Link"),
    "init": function ()
    {
        App.ChangePass_Link.addEventListener('click', function()
        {
            App.DivForm.style.display = 'block';


        });

    }
}

App.init();

