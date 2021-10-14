const filesToFileList = (files) => {
    let b = new ClipboardEvent("").clipboardData || new DataTransfer()
    for (let i = 0, len = files.length; i<len; i++) b.items.add(files[i])
    return b.files
}

const fromDataURLtoFile = (data,name) => {
    return fromBlobToFile(fromDataURLtBlob(data),name);
}

const fromBlobToFile = (blob,name) => {
    blob.lastModifiedDate = new Date();
    blob.name = name;
    return new File([blob], name, {
        type: blob.type,
    });
}

const fromDataURLtBlob = (data) => {
    let byteString = atob(data.split(',')[1]);
    let mimeString = data.split(',')[0].split(':')[1].split(';')[0];
    let buffer = new ArrayBuffer(byteString.length);
    let ibuffer = new Uint8Array(buffer);
    for (let i = 0; i < byteString.length; i++) {
        ibuffer[i] = byteString.charCodeAt(i);
    }
    return new Blob([ibuffer], {type: mimeString});
}

const useFiles = {
    filesToFileList,
    fromDataURLtoFile,
    fromBlobToFile,
    fromDataURLtBlob
}

export default useFiles;
