const init = function () {
  const var1 = document.querySelector("#wrapper");
  const injectElement = document.createElement("div");
  injectElement.className = "360Synergy";
  // html =document.getElementsByTagName('body')[0].outerHTML;
  injectElement.innerHTML = `
       <div class="responsive">

       <iframe  class="responsive-iframe" frameborder="0" style="width: 100%;  
       height: 1800px; 
   }"
       src="http://localhost/360db/gettingCleintId/Entension/podio_ext.php" ></iframe> </div>`;

  var1.prepend(injectElement);
  // inject a script into the page
  // chrome.tabs.executeScript({
  //   code: 'alert("Hello, world!");',
  // });
};
init();

// const init = function(){
//   const var1=document.querySelector("#wrapper");
//     const injectElement = document.createElement('div');
//     injectElement.className = '360Synergy';
//     // html =document.getElementsByTagName('body')[0].outerHTML;
//     // injectElement.innerHTML = "";
//    fetch('http://localhost/360db/podio_ext.php').then(function (response) {
// // console.log(response);
// return response.text();
// // console.log(response.text)
// }).then(function (response) {
// injectElement.innerHTML = response
// //    console.log(typeof (data));
// var1.prepend(injectElement);
// // console.log(html);
// }).catch(function (err) {
//     console.warn('Something went wrong.', err);
// });
// }
// init();
