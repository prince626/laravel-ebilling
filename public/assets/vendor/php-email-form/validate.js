/**
* PHP Email Form Validation - v3.6
* URL: https://bootstrapmade.com/php-email-form/
* Author: BootstrapMade.com
*/
(function () {
  "use strict";

  let forms = document.querySelectorAll('.php-email-form');

  forms.forEach(function (e) {
    e.addEventListener('submit', function (event) {
      event.preventDefault();

      let thisForm = this;

      let action = thisForm.getAttribute('action');
      let recaptcha = thisForm.getAttribute('data-recaptcha-site-key');


      thisForm.querySelector('.loading').classList.add('d-block');
      // thisForm.querySelector('.error-message').classList.remove('d-block');
      thisForm.querySelector('.sent-message').classList.remove('d-block');

      let formData = new FormData(thisForm);

      if (recaptcha) {
        if (typeof grecaptcha !== "undefined") {
          grecaptcha.ready(function () {
            try {
              grecaptcha.execute(recaptcha, { action: 'php_email_form_submit' })
                .then(token => {
                  formData.set('recaptcha-response', token);
                  php_email_form_submit(thisForm, action, formData);
                })
            } catch (error) {
              displayError(thisForm, error);
            }
          });
        } else {
          displayError(thisForm, 'The reCaptcha javascript API url is not loaded!')
        }
      } else {
        php_email_form_submit(thisForm, action, formData);
      }
    });
  });

  function php_email_form_submit(thisForm, action, formData) {
    fetch(action, {
      method: 'POST',
      body: formData,
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
      .then(response => {

        if (response.ok) {
          return response.json();
        } else {
          throw new Error(`${response.status} ${response.statusText} ${response.url}`);
        }
      })
      .then(data => {
        thisForm.querySelector('.loading').classList.remove('d-block');
        let dynamicMessageContainer = thisForm.querySelector('.dynamic-message');
        if (data.success) {
          dynamicMessageContainer.textContent = data.status;
          // dynamicMessageContainer.value = data.status;
          console.log('status', data.status);
          thisForm.querySelector('.sent-message').classList.add('d-block');

          if (data.status == 'subscription_Completed' || data.status == 'subscription_updated_successfully' || data.status == 'subscription_Activated') {
            window.location.href = 'http://localhost:8000/api/user/subscription';
          } else if (data.status == 'send_message_successfully') {
            console.log('http://localhost:8000/api/user/get_tickets')
            window.location.href = 'http://localhost:8000/api/user/get_tickets';
          } else {
            thisForm.reset();
            location.reload();
            // window.location.href = 'http://localhost:8000/api/user/get_tickets'; 
          }
        } else {
          throw new Error(data ?  data.data : 'Form submission failed and no error message returned from: ' + action);
        }
      })
      .catch((error) => {
        displayError(thisForm, error);
        setTimeout(function () {
          thisForm.querySelector('.error-message').innerHTML = null;
          thisForm.querySelector('.error-message').classList.remove('d-block');
        }, 3000);
      });
  }

  function displayError(thisForm, error) {
    thisForm.querySelector('.loading').classList.remove('d-block');
    thisForm.querySelector('.error-message').innerHTML = error;
    thisForm.querySelector('.error-message').classList.add('d-block');

  }

})();

document.addEventListener("DOMContentLoaded", function () {
  var activateButtons = document.querySelectorAll('.activateAction');
  activateButtons.forEach(function (button) {
    button.addEventListener('click', function (event) {
      event.preventDefault(); // Prevent the default behavior of the link

      fetch(this.href)
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            window.location.reload();
          } else {
            // Handle non-successful response
            showSnackbar(data.status, data.data);
          }
        })
        .catch(error => {
          showSnackbar('Fetch Error: ', error.message);
          console.log(error.message)
        });
    });
  });

  function showSnackbar(status, data) {
    var snackBar = document.getElementById("snackbar");
    snackBar.className = "show-bar";
    snackBar.textContent = status + data;
    setTimeout(function () {
      snackBar.className = snackBar.className.replace("show-bar", "");
    }, 5000);
  }
});