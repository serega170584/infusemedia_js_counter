"use strict";

async function generateImages() {
    let imageId
    let imagePath
    let isGetImagePathError = false

    try {
        imageId = await getImageId()
    } catch (error) {
        return
    }

    try {
        imagePath = await getImagePath(imageId)
    } catch (error) {
        isGetImagePathError = true
    }

    try {
        await fillEmpty(isGetImagePathError)
    } catch (error) {
        return
    }

    if (isGetImagePathError) {
        return
    }

    document.getElementById('banner').src = imagePath

    try {
        await increaseCount(imageId)
    } catch (error) {
    }

    // await getNumberUpdate(imagePath)
}

async function getNumberUpdate(imagePath)
{
    setTimeout(await getNumber, 5000, imagePath)
}

async function getNumber(imagePath)
{
    let number
    const response = await fetch(String.format(`/main.php?method=number&imagePath=${imagePath}`, 'number', imagePath))
    if (response.status !== 200) {
        throw new Error('Unsuccessful getting of number')
    }
    number = await response.text()
    document.getElementById('value').innerText = number

    setTimeout(await getNumber, 5000, imagePath)
}

async function increaseCount(imageId)
{
    let count
    const response = await fetch(`/main.php`, {
        method: 'POST',
        headers: {
            "Content-Type": "application/x-www-form-urlencoded; charset=utf-8",
        },
        body: `method=increase&imageId=${imageId}`
    })
    if (response.status !== 200) {
        throw new Error('Unsuccessful getting of increased count')
    }
    count = await response.text()
    document.getElementById('value').innerText = count
}

async function fillEmpty(isGetImagePathError)
{
    let imagePath
    if (isGetImagePathError) {
        imagePath = await getImagePath('empty')
        document.getElementById('banner').src = imagePath
    }
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
        throw new Error('Unsuccessful getting of image path')
    }
    return imageUrl
}

document.addEventListener("DOMContentLoaded", (event) => {
    generateImages()
});

