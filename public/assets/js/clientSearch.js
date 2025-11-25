document.getElementById("clientSearch").addEventListener("input", function () {
    let term = this.value;

    if (term.length < 2) return;

    fetch(`/api/clients/search?term=` + term)
        .then(res => res.json())
        .then(data => {
            let box = document.getElementById("resultsBox");
            box.innerHTML = "";

            data.forEach(client => {
                let item = document.createElement("div");
                item.classList.add("result-item");
                item.innerHTML = `
                    <strong>${client.nombres} ${client.apellidos}</strong>
                    <br>DNI: ${client.dni}
                `;
                item.addEventListener("click", () => selectClient(client));
                box.appendChild(item);
            });
        });
});

function selectClient(client) {
    document.getElementById("client_id").value = client.id;
    document.getElementById("clientSearch").value = client.nombres + " " + client.apellidos;
    document.getElementById("resultsBox").innerHTML = "";
}
