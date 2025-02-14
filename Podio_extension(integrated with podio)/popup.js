const init = function () {
  const mainElement = document.querySelector("#wrapper");
  

  const injectElement = document.createElement("div");
  injectElement.className = "360Synergy";
  const storedValue = localStorage.getItem("client_id");

  const inputDiv = document.createElement("div");
  inputDiv.className = "input-wrapper";
 
  


  
  mainElement.prepend(injectElement);
  mainElement_input.prepend(inputDiv);
  
  const validateClientReq = new XMLHttpRequest();
  const current_URL = window.location.href;

 

 
      
        const iframe = document.createElement("iframe");
        iframe.className = "responsive-iframe";
     
        iframe.style.width = "100%";
        iframe.style.height = "1800px";
        iframe.src = `http://localhost/Podio_extension(integrated_with_podio)/KPI_Analytics.php`;
        iframe.onload = function () {
          handleIframeLoad();
        

        const responsiveDiv = document.createElement("div");
        responsiveDiv.className = "responsive";
        responsiveDiv.appendChild(iframe);

        injectElement.innerHTML = "";
        injectElement.appendChild(responsiveDiv);
        mainElement.prepend(injectElement);
      }
    }
  

 


document.head.appendChild(styleElement);

const iframeSrc = window.location.href;
console.log(iframeSrc);
init();
