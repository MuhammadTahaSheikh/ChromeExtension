// Listen for changes to LocalStorage
window.addEventListener('storage', function(event) {
    if (event.key === 'myKey') {
      // Get updated value
      const newValue = event.newValue;
      // Update LocalStorage in all tabs
      chrome.tabs.query({}, function(tabs) {
        tabs.forEach(function(tab) {
          chrome.tabs.sendMessage(tab.id, { message: 'updateLocalStorage', data: newValue });
        });
      });
    }
  });
  
  // Send LocalStorage value to popup
  chrome.runtime.onMessage.addListener(function(request, sender, sendResponse) {
    if (request.message === 'getLocalStorage') {
      const value = localStorage.getItem('myKey');
      sendResponse({ data: value });
    }
  });
  
  // Listen for changes to LocalStorage
window.addEventListener('storage', function(event) {
    if (event.key === 'myKey') {
      // Get updated value
      const newValue = event.newValue;
      // Update LocalStorage in all tabs
      chrome.tabs.query({}, function(tabs) {
        tabs.forEach(function(tab) {
          chrome.tabs.sendMessage(tab.id, { message: 'updateLocalStorage', data: newValue });
        });
      });
    }
  });
  
  // Send LocalStorage value to popup
  chrome.runtime.onMessage.addListener(function(request, sender, sendResponse) {
    if (request.message === 'getLocalStorage') {
      const value = localStorage.getItem('myKey');
      sendResponse({ data: value });
    }
  });
  