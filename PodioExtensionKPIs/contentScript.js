const init = function () {
  const mainElement = document.querySelector("#wrapper");
  const mainElement_input = document.querySelector(".right");

  const injectElement = document.createElement("div");
  injectElement.className = "360Synergy";
  const storedValue = localStorage.getItem("client_id");

  const inputDiv = document.createElement("div");
  inputDiv.className = "input-wrapper";
 
  const inputField = document.createElement("input");
  inputField.type = "text";
  inputField.placeholder = "Enter a Client-ID:";
  inputField.required = true;
  const submitButton = document.createElement("button");
  submitButton.textContent = "Submit";

  const image = document.createElement("img");
  image.src = "https://reistats.stopshoprei.com/images/Logo-1.png"; // Replace with the actual path to your image
  image.className = "input-image"; // Add a class for the image
  
  const validateInput = function () {
    if (inputField.value.trim() === "") {
      inputField.setCustomValidity("Please enter a Client-ID.");
    } else {
      inputField.setCustomValidity("");
    }
  };
  inputField.addEventListener("click", function () {
    inputField.classList.remove("blur"); // Remove 'blur' class from input field
    submitButton.classList.remove("blur"); // Remove 'blur' class from submit button
  });
  submitButton.addEventListener("click", function (event) {
    validateInput(); 
    const enteredValue = inputField.value;
    localStorage.setItem("client_id", enteredValue);
    window.location.reload(); // Reload the page
  });

  const inputContainer = document.createElement("div");
  inputContainer.className = "input-container";
  inputContainer.appendChild(inputField);
  inputContainer.appendChild(image); // Add the image to the inputContainer

  inputDiv.appendChild(inputContainer);
  inputDiv.appendChild(submitButton);
  injectElement.appendChild(inputDiv);


  
  mainElement.prepend(injectElement);
  mainElement_input.prepend(inputDiv);
  
  const validateClientReq = new XMLHttpRequest();
  const current_URL = window.location.href;

  validateClientReq.open(
    "POST",
    "https://reistats.stopshoprei.com/validate_clientid.php"
  );
  validateClientReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  const post_Data = "client_id=" + storedValue + "&page_url=" + current_URL;
  validateClientReq.send(post_Data);

  validateClientReq.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
      const fetch_client_id = parseInt(this.responseText);
      console.log(this.responseText);
      if (fetch_client_id === 1) {
        const iframe = document.createElement("iframe");
        iframe.className = "responsive-iframe";
        iframe.scrolling = "no";
        iframe.frameBorder = "0";
        iframe.style.width = "100%";
        iframe.style.height = "1800px";
        iframe.src = `https://reistats.stopshoprei.com/podio_ext.php?client_id=${storedValue}&&page_url=${current_URL}`;
        iframe.onload = function () {
          handleIframeLoad();
        };

        const responsiveDiv = document.createElement("div");
        responsiveDiv.className = "responsive";
        responsiveDiv.appendChild(iframe);

        injectElement.innerHTML = "";
        injectElement.appendChild(responsiveDiv);
        mainElement.prepend(injectElement);
      }
    }
  };

  const handleIframeLoad = function () {
    inputField.classList.add("blur"); // Add 'blur' class to input field
    submitButton.classList.add("blur"); // Add 'blur' class to submit button
  
    const editButton = document.createElement("");
    editButton.textContent = "Edit";
    editButton.className = "edit-button";
    editButton.addEventListener("click", function () {
      inputField.classList.remove("blur"); // Remove 'blur' class from input field
      submitButton.classList.remove("blur"); // Remove 'blur' class from submit button
    });
    inputContainer.appendChild(editButton); // Append the edit button to the input container
  };
  
  
};

const styleElement = document.createElement("style");
styleElement.textContent = `
 .input-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 172px;
    left: 799px;
    top: 83px;
    background: #FFFFFF;
    box-shadow: 0px 6px 5px rgba(0, 0, 0, 0.15);
    margin-bottom: 2%;
}
  /* Media query for screens smaller than  */
  @media screen and (min-width:1300px) and (max-width: 1400px) {
    .input-wrapper {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      width: 650px;
      height: 172px;
      left: 799px;
      top: 83px;
      background: #FFFFFF;
      box-shadow: 0px 6px 5px rgba(0, 0, 0, 0.15);
      margin-bottom: 2%;
      /* Add more styles as needed */
    }
  }
  .input-container {
    display: flex;
    align-items: center;
  }

  .input-wrapper input,
  .input-wrapper button {
    margin-bottom: 10px;
  }
  
  /* Additional styles for the image */
  .input-wrapper img.input-image {
    width: 298px;
    margin-right: 10px;
  }
  .input-wrapper button {
    margin-right: 31%;
    margin-top: -3%;
    background-color:#05758A;
    color:#FFFFFF;
  }
  
  .blur {
    filter: blur(3px);
  }
   @media screen and (min-width:950px) and (max-width: 1050px) {
    .input-wrapper {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      width: 100%;
      height: 172px;
      left: 799px;
      top: 83px;
      background: #FFFFFF;
      box-shadow: 0px 6px 5px rgba(0, 0, 0, 0.15);
      margin-bottom: 2%;
      /* Add more styles as needed */
    }
    .input-wrapper img.input-image {
    width: 298px;
    margin-right: -30px;
}
  }
   @media screen and (min-width:1051px) and (max-width: 1250px) {
    .input-wrapper {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      width: 100%;
      height: 172px;
      left: 799px;
      top: 83px;
      background: #FFFFFF;
      box-shadow: 0px 6px 5px rgba(0, 0, 0, 0.15);
      margin-bottom: 2%;
      /* Add more styles as needed */
    }
    .input-wrapper img.input-image {
    width: 298px;
    margin-right: -30px;
}
  }
`;
document.head.appendChild(styleElement);

const iframeSrc = window.location.href;
console.log(iframeSrc);
init();
