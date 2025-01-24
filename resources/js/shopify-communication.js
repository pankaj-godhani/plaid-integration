/* 
  You can use this object in the child tab like this:
  const childTab = new ChildTab("http://example.com");
  childTab.return_data({ object: "data..."});
*/
export class ChildTab {
  constructor(expectedOrigin) {
    this.expectedOrigin = expectedOrigin

    // Listen for messages from the parent tab
    window.addEventListener('message', this.receiveMessage.bind(this), false)
  }

  return_data(data) {
    // Convert the data to a JSON string
    const jsonData = JSON.stringify(data)
    // Send the data to the parent tab
    window.opener.postMessage(jsonData, '*')
  }

  receiveMessage(event) {
    // Check that the message is from the expected origin
    if (event.origin !== this.expectedOrigin) {
      return
    }
    // Parse data if it is possible, in case of error it will return the raw data.
    try {
      const data = JSON.parse(event.data)
      return data
    } catch (error) {
      return event.data
    }
  }
}

/* 
  You can use this object in the parent tab like this:
  const parentTab = new ParentTab();
  parentTab.setChildWindow(childWindow); || parentTab.setChildWindow(window.open("http://example.com"...));
  parentTab.send_data({ message: "Hello from the parent tab!" });
*/
export class ParentTab {
  constructor() {
    this.childWindow = null
    this.childParams = `scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no`
    // Listen for messages from the child tab
    window.addEventListener('message', this.receiveMessage.bind(this), false)
  }

  openChild(url) {
    this.childWindow = window.open(url, 'checkout', this.childParams)
  }

  send_data(data) {
    // Convert the data to a JSON string
    const jsonData = JSON.stringify(data)

    // Send the data to the child tab
    this.childWindow.postMessage(jsonData, this.childOrigin)
  }

  receiveMessage(event) {
    // Parse data if it is possible, in case of error it will return the raw data.
    try {
      const data = JSON.parse(event.data)
      console.log(data)
      return data
    } catch (error) {
      console.log(event.data)
      return event.data
    }
  }
}


