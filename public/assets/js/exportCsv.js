const exportButton = document.querySelector(".export-btn");

// export HTML to CSV
const exportarHtmlParaCSV = (selector) => {
    // transformar tabela -> dados
    const table = document.querySelector(selector);
    const rows = Array.from(table.rows);

    const contatos = rows.map((row) =>
        Array.from(row.cells).map(
            // se tiver valores multiplos utilizar o simbolo de barra
            (cell) => cell.innerText.replace(/\n/g, "|")
        )
    );

    // Construir o arquivo CSV
    const conteudoCSV = 
    "data:text/csv;charset=utf-8," + 
    contatos
        .map((contato) => Object.values(contato).join(","))
        .join("\n");

    // Nome do arquivo e download
    const enCodeUri = encodeURI(conteudoCSV);
    const link = document.createElement("a");
    link.setAttribute("href", enCodeUri);
    link.setAttribute("download", "contatos.csv");
    link.setAttribute("class", "erro-msg");
    document.body.appendChild(link);
    link.click();
};

exportButton.addEventListener("click", ()=>{
    exportarHtmlParaCSV(".table-widget > table");
});