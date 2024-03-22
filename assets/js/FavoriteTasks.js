addEventListener("DOMContentLoaded", () => {
  const createButton = (label, format) => {
    const button = document.createElement("button");
    button.classList.add("dt-button", "buttons-html5");
    button.innerHTML = label;
    button.name = "format";
    button.value = format;
    button.formMethod = "GET";
    button.formAction = "/data_export/timesheets/all";

    return button;
  };

  const buttons = [
    createButton(
      leantime.i18n.__("favorite_tasks.favorite") ?? "Favorite",
      "csv",
    ),
  ];

  console.log('test');

  // We want to add our buttons inside .dt-buttons inside #tableButtons, but that element may not exist yet.
  const wrapper = document.querySelector("html");

  /*
  const addButtons = (container) => {

      // Buttons are prepended to the container, so we process them in reverse order.
      for (const button of buttons.reverse()) {
        // Add a little spacing.
        container.prepend(document.createTextNode(" "));
        container.prepend(button);
      }
       */
    const target = '#yourToDoContainer .sortableTicketList';
    const container = document.querySelector("html");
    console.log('asdasd', container);
      // We don't yat have the target element, so we wait for it.
      const observer = new MutationObserver((mutationList, observer) => {
        for (const mutation of mutationList) {
          if (mutation.type === "childList") {
            console.log("A child node has been added or removed.");
            console.log(mutation.addedNodes);
          } else if (mutation.type === "attributes") {
            console.log(`The ${mutation.attributeName} attribute was modified.`);
          }
        }
        /*
        for (const mutation of mutationList) {
          console.log(mutation.addedNodes[0]);
          if (
            "childList" === mutation.type &&
            mutation.addedNodes.length > 0 &&
            mutation.addedNodes[0].matches(target)
          ) {
            console.log('123321');
            addButtons(mutation.addedNodes[0]);
            observer.disconnect();
          }
        }

         */
      });
      console.log('observer', observer);
      observer.observe(container, { childList: true });
});