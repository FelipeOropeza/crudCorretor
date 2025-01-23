document
  .getElementById("cadastroForm")
  .addEventListener("submit", function (event) {
    event.preventDefault();
    let valid = true;

    document.getElementById("cpfError").textContent = "";
    document.getElementById("creciError").textContent = "";
    document.getElementById("nomeError").textContent = "";

    const cpfInput = document.getElementById("cpf");
    const cpf = cpfInput.value.replace(/\D/g, "");
    if (cpf.length !== 11) {
      document.getElementById("cpfError").textContent =
        "O CPF deve conter exatamente 11 números.";
      valid = false;
    } else {
      cpfInput.value = cpf;
    }

    const creciInput = document.getElementById("creci");
    let creci = creciInput.value.trim().toUpperCase();

    creci = creci.replace(/[^A-Za-z0-9]/g, "");

    if (creci.length < 2) {
      document.getElementById("creciError").textContent =
        "O Creci deve ter pelo menos 2 caracteres.";
      valid = false;
    } else {
      creciInput.value = creci;
    }

    const nomeInput = document.getElementById("nome");
    const nome = nomeInput.value.trim();
    if (nome.length < 2) {
      document.getElementById("nomeError").textContent =
        "O nome deve ter pelo menos 2 caracteres.";
      valid = false;
    }

    if (valid) {
      this.submit();

      document.getElementById("cpf").value = "";
      document.getElementById("creci").value = "";
      document.getElementById("nome").value = "";
    }
  });

document.getElementById("cpf").addEventListener("input", function () {
  let value = this.value.replace(/\D/g, "");
  if (value.length > 11) value = value.slice(0, 11);
  this.value = value
    .replace(/(\d{3})(\d)/, "$1.$2")
    .replace(/(\d{3})(\d)/, "$1.$2")
    .replace(/(\d{3})(\d{1,2})$/, "$1-$2");
});

document.getElementById("creci").addEventListener("input", function () {
  let value = this.value.replace(/\W/g, "").toUpperCase();
  if (value.length > 10) value = value.slice(0, 10);
  this.value = value.replace(/(\d{1,5})([A-Za-z]?)/, "$1-$2");
});

function hideFlashMessage() {
  setTimeout(function () {
    const flashMessageSucesso = document.querySelector(".alert.alert-success");
    const flashMessageError = document.querySelector(".alert.alert-danger");

    if (flashMessageSucesso) {
      flashMessageSucesso.style.display = "none";
    }

    if (flashMessageError) {
      flashMessageError.style.display = "none";
    }
  }, 2000);
}

window.addEventListener("load", function () {
  hideFlashMessage();
});
