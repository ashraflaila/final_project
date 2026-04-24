function store(url, data) {
    axios.post(url, data)
        .then(function (response) {
            showMessage(response.data);
            clearForm();
            clearAndHideErrors();

        })
        .catch(function (error) {
            console.log('AJAX store error:', error.response ? error.response.data : error);

            if (error.response && error.response.data && error.response.data.errors !== undefined) {
                showErrorMessages(error.response.data.errors);
            } else if (error.response && error.response.data) {
                showMessage(error.response.data);
            } else {
                showMessage({ icon: 'error', title: 'حدث خطأ أثناء حفظ البيانات.' });
            }
        });

}

function storepart(url, data) {

    axios.post(url, data)

        .then(function (response) {
            showMessage(response.data);
            clearForm();
            clearAndHideErrors();

        })

        .catch(function (error) {

            if (error.response.data.errors !== undefined) {
                showErrorMessages(error.response.data.errors);
            } else {

                showMessage(error.response.data);
            }
        });

}
function storeRoute(url, data) {
    axios.post(url, data)
        .then(function (response) {
            window.location = response.data.redirect;
        })
        .catch(function (error) {
            if (error.response && error.response.data && error.response.data.errors !== undefined) {
                showErrorMessages(error.response.data.errors);
            } else if (error.response && error.response.data) {
                showMessage(error.response.data);
            } else {
                showMessage({ icon: 'error', title: 'حدث خطأ أثناء حفظ البيانات.' });
            }
        });
}
function storeRedirect(url, data, redirectUrl) {
    axios.post(url, data)
        .then(function (response) {
            console.log(response);
            if (redirectUrl != null)
                window.location.href = redirectUrl;
        })
        .catch(function (error) {
            console.log(error.response);
        });
}

function update(url, data, redirectUrl) {
    axios.put(url, data)

        .then(function (response) {
            console.log(response);

            if (redirectUrl != null)
                window.location.href = redirectUrl;
        })
        .catch(function (error) {
            console.log(error.response);
        });
}
function updateRoute(url, data) {
    axios.put(url, data)
        .then(function (response) {
            console.log(response);
            window.location = response.data.redirect;
        })
        .catch(function (error) {
            console.log(error.response);
            if (error.response && error.response.data) {
                if (error.response.data.errors) {
                    showErrorMessages(error.response.data.errors);
                } else {
                    alert('خطأ: ' + (error.response.data.title || error.response.data.message || 'حدث خطأ'));
                }
            }
        });
}
function updateReload(url, data, redirectUrl) {
    axios.put(url, data)
        .then(function (response) {
            console.log(response);
            location.reload()
        })
        .catch(function (error) {
            console.log(error.response);
        });
}
function updatePage(url, data) {
    axios.post(url, data)
        .then(function (response) {
            console.log(response);
            location.reload()
            // showMessage(response.data);
        })
        .catch(function (error) {
            console.log(error.response);
        });
}

function confirmDestroy(url, td) {
    Swal.fire({
        title: 'هل أنت متأكد من عملية الحذف ؟',
        text: "لا يمكن التراجع عن عملية الحذف",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'نعم',
        cancelButtonText: 'لا',
    }).then((result) => {
        if (result.isConfirmed) {
            destroy(url, td);
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'تمت عملية الحذف بنجاح',
                showConfirmButton: false,
                timer: 1500
            })

        } else {

            Swal.fire({
                icon: 'error',
                title: 'فشلت عملية الحذف .',
                showConfirmButton: false,
                timer: 1500

            })
        }
    });
}


function destroy(url, td) {
    axios.delete(url, {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(function (response) {
            // handle success
            console.log(response.data);
            if (td) {
                td.closest('tr').remove();
            }
            // showToaster(response.data.message, true);
        })
        .catch(function (error) {
            // handle error
            console.log(error.response);
            // showToaster(error.response.data.message, false);
        })
        .then(function () {
            // always executed
        });
}




function showErrorMessages(errors) {
    var errorAlert = document.getElementById('error_alert');
    var errorMessagesUl = document.getElementById('error_messages_ul');

    if (!errorAlert || !errorMessagesUl) {
        console.error('Missing error display elements');
        return;
    }

    errorAlert.hidden = false;
    errorAlert.classList.remove('d-none');
    errorMessagesUl.innerHTML = '';

    if (Array.isArray(errors)) {
        errors.forEach(function(message) {
            var newLI = document.createElement('li');
            newLI.textContent = message;
            errorMessagesUl.appendChild(newLI);
        });
        return;
    }

    Object.keys(errors).forEach(function(key) {
        var value = errors[key];
        if (Array.isArray(value)) {
            value.forEach(function(message) {
                var newLI = document.createElement('li');
                newLI.textContent = message;
                errorMessagesUl.appendChild(newLI);
            });
        } else {
            var newLI = document.createElement('li');
            newLI.textContent = value;
            errorMessagesUl.appendChild(newLI);
        }
    });
}

function clearAndHideErrors() {
    document.getElementById('error_alert').hidden = true
    var errorMessagesUl = document.getElementById("error_messages_ul");
    errorMessagesUl.innerHTML = '';
}

function clearForm() {
    document.getElementById("create_form").reset();
}

function showMessage(data) {
    console.log(data);
    Swal.fire({
        position: 'center',
        icon: data.icon,
        title: data.title,
        showConfirmButton: false,
        timer: 1500
    })
}

// Override deletion helpers with a consistent AJAX flow.
function confirmDestroy(url, td) {
    Swal.fire({
        title: 'هل أنت متأكد من عملية الحذف؟',
        text: 'لا يمكن التراجع عن عملية الحذف بعد التنفيذ.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'نعم',
        cancelButtonText: 'لا',
    }).then((result) => {
        if (result.isConfirmed) {
            destroy(url, td)
                .then(function (data) {
                    showMessage(data);
                })
                .catch(function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'فشلت عملية الحذف.',
                        showConfirmButton: false,
                        timer: 1500
                    });
                });
        }
    });
}

function destroy(url, td) {
    return axios.delete(url, {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(function (response) {
            console.log(response.data);
            if (td) {
                td.closest('tr').remove();
            }
            return response.data;
        })
        .catch(function (error) {
            console.log(error.response);
            throw error;
        });
}
