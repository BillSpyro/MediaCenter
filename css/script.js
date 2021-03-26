const commentShowEle = document.getElementsByClassName("show-comments");
console.log(commentShowEle);

const commentDiv = document.getElementsByClassName("comments");
console.log(commentDiv);

for (let i = 0; i < commentShowEle.length; i++) {
    commentShowEle[i].addEventListener('click', function() {
        commentShowEle[i].style.color = 'red';
        for(let j = 0; j < commentDiv.length; j++) {
            commentDiv[j].style.display = 'block';
        }
    });
  }
