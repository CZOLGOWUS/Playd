const appendSubmit = (root) => {
    const submitButton = document.createElement("button");
    submitButton.setAttribute("type", "submit");
    submitButton.textContent = "submit changes";

    root.appendChild(submitButton);
}

const addFormRow = (root, index) => {
    const row = document.createElement("div");
    row.classList.add('game-attribute');

    const leftInput = document.createElement("input");
    leftInput.setAttribute("name", `attributeName_${index}`);

    const rightInput = document.createElement("input");
    rightInput.setAttribute("name", `attributeScore_${index}`);

    row.appendChild(leftInput);
    row.appendChild(rightInput);

    root.appendChild(row)
}


const addAttrButtonHandler = (root) => {
    const submitButtonContainer = root.querySelector(".submit-changes-button");
    const rowsContainer = root.querySelector(".attributes-container");

    let clickingForTheFirstTime = true;
    let nextRowIndex = 0;

    return (event) => {
        if (clickingForTheFirstTime) {
            appendSubmit(submitButtonContainer)
            clickingForTheFirstTime = false;
        }

        addFormRow(rowsContainer, nextRowIndex);
        nextRowIndex = nextRowIndex + 1;
    }
}

const initAttributeAdder = () => {
    const root = document.querySelector(".attributes-form-wrapper form")
    const addAttrButton = root.querySelector(".add-attribute-button");

    if (!root || !addAttrButton) return;

    addAttrButton.addEventListener("click", addAttrButtonHandler(root))
}


window.addEventListener('DOMContentLoaded', initAttributeAdder);