const metadata = JSON.parse(document.getElementById("metadata").text);
document.title = metadata.title || metadata.fileName;

const annotations = JSON.parse(document.getElementById("annotations").text);
const pages = document.querySelectorAll(".page");

const createAnnotation = function (container, data, pageNo) {
  if (data.type !== "Link" && data.type !== "TextLink") {
    return;
  }
  if (!data.action) {
    return;
  }

  const annotation = document.createElement("div");
  annotation.setAttribute("style", "");
  annotation.style.left = data.bounds[0] + "px";
  annotation.style.top = data.bounds[1] + "px";
  annotation.style.width = data.bounds[2] + "px";
  annotation.style.height = data.bounds[3] + "px";
  annotation.dataset.type = data.type;
  if (data.objref) {
    annotation.dataset.objref = data.objref;
  }

  if (data.appearance) {
    annotation.style.backgroundImage = "url('" + data.appearance + "')";
    annotation.style.backgroundSize = "100% 100%";
  }

  if (data.action.type === "URI") {
    const element = document.createElement("a");
    element.href = data.action.uri;
    element.title = data.action.uri;
    element.target = "_blank";
    element.style.position = "absolute";
    element.style.width = "100%";
    element.style.height = "100%";
    annotation.appendChild(element);
  } else {
    annotation.addEventListener("click", () => {
      switch (data.action.type) {
        case "GoTo":
          pages[data.action.page - 1].scrollIntoView();
          break;

        case "Named":
          switch (data.action.name) {
            case "NextPage":
              pages[pageNo - 2].scrollIntoView();
              break;
            case "PrevPage":
              pages[pageNo].scrollIntoView();
              break;
            case "FirstPage":
              pages[0].scrollIntoView();
              break;
            case "LastPage":
              pages[metadata.pagecount - 1].scrollIntoView();
              break;
          }
          break;
      }
    });
  }
  container.append(annotation);
};

annotations.pages.forEach((pageAnnotations) => {
  const pageNo = pageAnnotations.page;
  const annotationsContainer = document.createElement("div");
  annotationsContainer.className = "annotations-container";
  annotationsContainer.style.width = metadata.bounds[pageNo - 1][0];
  annotationsContainer.style.height = metadata.bounds[pageNo - 1][1];
  pageAnnotations.annotations.forEach((annotation) =>
    createAnnotation(annotationsContainer, annotation, pageNo)
  );
  pages[pageNo - 1].appendChild(annotationsContainer);
});
