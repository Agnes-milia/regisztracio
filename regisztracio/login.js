function submitlogin() {
                    var form = document.login;
                    if(form.emailVagyNev.value == ""){
                        alert( "Üres név vagy email cím." );
                        return false;
                    }
                    else if(form.jelszo.value == ""){
                        alert( "Üres jelszó." );
                        return false;
                    }
}