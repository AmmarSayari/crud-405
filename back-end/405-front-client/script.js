const apiUrl = 'http://localhost/405-crud/back-end/api';
const todoListElem = document.getElementById("todoList");

document.getElementById("add-btn").addEventListener("click", addNewTodo);

document.addEventListener("DOMContentLoaded", fetchAllTodos);

async function fetchAllTodos() {
  try {
    const response = await fetch(apiUrl + "/readAll.php");
    const todos = await response.json();

    if (todos && todos.length > 0) {
      for (let item of todos) {
        addItem(item);
      }
    }
  } catch (error) {
    console.error('Error:', error);
  }
}

async function addNewTodo() {
    let titleInput = document.getElementById("new-item-title");
    let urlInput = document.getElementById("new-item-url");
    let errorMessage = document.getElementById("errorMessage");

    let title = titleInput.value.trim();
    let url = urlInput.value.trim();

    if (title && url) {
        const data = { title, link: url };
        const options = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        };
        await fetch(apiUrl + "/create.php", options);
        location.reload();
    } else {
        errorMessage.textContent = "Please fill in both title and URL.";
    }
}



async function markAsComplete() {
  const id = this.id;
  const data = { id, done: true };

  const options = {
    method: 'PUT',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(data),
  };

  try {
    await fetch(apiUrl + "/update.php", options);
    location.reload();
  } catch (error) {
    console.error('Error:', error);
  }
}

async function deleteTodo() {
  const id = this.id;
  const data = { id };

  const options = {
    method: 'DELETE',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(data),
  };

  try {
    await fetch(apiUrl + "/delete.php", options);
    location.reload();
  } catch (error) {
    console.error('Error:', error);
  }
}

function addItem(item) {
  const liElem = document.createElement("li");
  liElem.appendChild(document.createTextNode(item.title));

  const spanContainerElem = document.createElement("span");
  spanContainerElem.setAttribute("class", "span-btns");

  const spanCompleteElem = document.createElement("span");
  spanCompleteElem.id = item.id;
  spanCompleteElem.title = "completed";
  spanCompleteElem.addEventListener('click', markAsComplete, false);
  spanCompleteElem.appendChild(document.createTextNode("✓"));

  const spanDeleteElem = document.createElement("span");
  spanDeleteElem.id = item.id;
  spanDeleteElem.title = "delete";
  spanDeleteElem.appendChild(document.createTextNode("X"));
  spanDeleteElem.addEventListener('click', deleteTodo, false);

  spanContainerElem.appendChild(spanCompleteElem);
  spanContainerElem.appendChild(spanDeleteElem);

  liElem.appendChild(spanContainerElem);
  todoListElem.appendChild(liElem);
}
