const buttonIndex=document.querySelectorAll(".buttonIndex");

buttonIndex.forEach(oneButtonIndex => 
    oneButtonIndex.addEventListener("mouseenter",()=>{
        const parent=oneButtonIndex.closest(".imgButtonIndex");
        const imgIndex=parent.querySelector(".imgIndex");
        if(imgIndex){
            imgIndex.classList.remove("imgIndexBrightness");
            imgIndex.classList.add("imgIndexScale");
        }
    }));

    buttonIndex.forEach(oneButtonIndex => 
        oneButtonIndex.addEventListener("mouseleave",()=>{
            const parent=oneButtonIndex.closest(".imgButtonIndex");
            const imgIndex=parent.querySelector(".imgIndex");
            if(imgIndex){
                imgIndex.classList.add("imgIndexBrightness");
                imgIndex.classList.remove("imgIndexScale");
            }
        }));

console.log(buttonIndex);
