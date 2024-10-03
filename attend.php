
<!DOCTYPE html>
<html lang="en">
  <!--helllo mundo-->
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tatay Cipher</title>
    <link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.min.css" />
    <script src="bootstrap.min.js"></script>
  </head>
  <body>
  <nav class="navbar navbar-light bg-dark">
        <span class="navbar-brand h1 text-light">Attendance</span>
      </nav>
    <div class="container-fluid" style="height:100vh;">

      <div class="row">
        <div class="col-sm-12 text-center" style="display: flex; flex-direction: column; align-items: center;">
        <form method="POST">
            <input type="text" name="stud_id" id="studentId" placeholder="Student-ID" />
            <button type="button" id="timeInBtn" class="btn btn-success" style="width: 100%">Time-IN</button>
            <button type="button" id="timeOutBtn" class="btn btn-danger" style="width: 100%">Time-OUT</button>
            <div class="cont d-flex justify-content-center align-items-center">
              <h4 class="result" id="display"></h4>
            </div>
          </form>
          <button type="button" class="btn btn-dark mt-5" name="submit" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            Export Excel
            </button>
        <form method="POST" action="reset.php" id="exportForm">
          <button type="submit" name="submit" class="btn btn-dark" style="width: 100%">Reset Records</button>
        </form>




<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Select Year & Section</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form method="POST" action="eggcell.php" id="exportForm">
      <button type="submit" name="section" value="BSIT 1-2" class="btn btn-dark" style="width: 45%">BSIT 1-2</button>
      <button type="submit" name="section" value="BSIT 1-1" class="btn btn-dark" style="width: 45%">BSIT 1-1</button>
      <button type="submit" name="section" value="BSIT 2-1" class="btn btn-dark" style="width: 45%">BSIT 2-1</button>
      <button type="submit" name="section" value="BSIT 2-1" class="btn btn-dark" style="width: 45%">BSIT 2-2S</button>
      <button type="submit" name="section" value="BSIT 2-1" class="btn btn-dark" style="width: 45%">BSIT 3-1</button>
      <button type="submit" name="section" value="BSIT 2-1" class="btn btn-dark" style="width: 45%">BSIT 3-2</button>
      <button type="submit" name="section" value="BSIT 2-1" class="btn btn-dark" style="width: 45%">BSIT 4-1</button>
      <button type="submit" name="section" value="BSIT 2-1" class="btn btn-dark" style="width: 45%">BSIT 4-2</button>

      <button type="submit" name="section" value="all" class="btn btn-dark" style="width: 45%">All section</button>

        </form>
      </div>

    </div>
  </div>
</div>




          </div>
      </div>
    </div>
  </body>
</html>

<script>
 document.getElementById('timeInBtn').addEventListener('click', function() {
    var studentId = document.getElementById('studentId').value;

    if (!studentId) {
      document.getElementById('display').innerText = "Please enter a Student ID.";
      return;
    }

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          var studentInfo = xhr.responseText;
          document.getElementById('display').innerText = studentInfo;
        } else {
          document.getElementById('display').innerText = 'Error fetching student info';
        }
      }
    };
    xhr.open('GET', 'get.php?stud_id=' + studentId);
    xhr.send();
});


    document.getElementById('timeOutBtn').addEventListener('click', function() {
    var studentId = document.getElementById('studentId').value;

    if (!studentId) {
      document.getElementById('display').innerText = "Please enter a Student ID.";
      return;
    }
    // AJAX request to record time-out
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var response = xhr.responseText;
                document.getElementById('display').innerText = response;
            } else {
                console.error('Error recording time-out');
            }
        }
    };
    xhr.open('GET', 'get-out.php?stud_id=' + studentId);
    xhr.send();
});

var myModal = document.getElementById('myModal')
var myInput = document.getElementById('myInput')

myModal.addEventListener('shown.bs.modal', function () {
  myInput.focus()
})


</script>
<style>
  html,
  body {
    height: 100%;
    overflow: hidden;
  }
  .navbar{
    justify-content: center;
  }
  .row {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
  }
  input {
    margin-bottom: 15px;
    width: 100%;
    height: 60px;
    padding: 5px;
    box-sizing: border-box;
    text-align: center;
    outline: none;
    border-top: none;
    border-left: none;
    border-right: none;
    font-size: large;
  }
  button {
    margin-bottom: 10px;
    height: 60px;
    padding: 5px;
    box-sizing: border-box;
    border-radius: 15px;
    text-align: center;
  }
  .cont {
    height: 180px;
    width: 100%;
    border-radius: 15px;
    box-sizing: border-box;

    background-color: rgb(230, 228, 228);
  }
</style>
