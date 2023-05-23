"use strict";

async function generateImages() {
    let imageId
    let imagePath

    imageId = await getImageId()
    imagePath = await getImagePath(imageId)

    if (imagePath === null) {
        document.getElementById('banner').src = '/src/empty.jpg'
        return
    }

    document.getElementById('banner').src = imagePath
}

async function getImageId()
{
    const response = await fetch('/main.php?method=imageId')
    if (response.status !== 200) {
        throw new Error('Unsuccessful getting of image id')
    }
    return await response.text()
}

async function getImagePath(imageId)
{
    let imageUrl = '/src/' + imageId + '.jpg'
    const response = await fetch(imageUrl)
    if (response.status !== 200) {
        return null
    }
    return imageUrl
}

document.addEventListener("DOMContentLoaded", (event) => {
    generateImages()
});

