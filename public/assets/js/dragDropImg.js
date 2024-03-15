const dropzoneBox = document.getElementsByClassName("dropzone-box")[0];

const inputFiles = document.querySelectorAll(".dropzone-area [type='file']");

const inputElement = inputFiles[0];

const dropZoneElement = inputElement.closest(".dropzone-area");

inputElement.addEventListener("change", (e)=>{
    if(inputElement.files.length){
        updateDropZoneFileList(
            dropZoneElement,
            inputElement.files[0]
        );
    }
});

const updateDropZoneFileList = (dropZoneElement, file) => {
    let dropzoneFileMensage = dropZoneElement.querySelector(".file-info");
    console.log(dropzoneFileMensage);
    dropzoneFileMensage.innerHTML = `
        ${file.name}, ${file.size}
        bytes
    `;
};