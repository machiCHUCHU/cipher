
<!DOCTYPE html>
<html lang="en">
  <!--helllo mundo-->
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tatay Cipher</title>
    <link rel="stylesheet" href="bootstrap.min.css" />
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
      
        <div class="col-sm-12 text-center" style="display: flex; flex-direction: column">
        <div class="h1 text-primary m-5" style="font-size: 50px">
            Attendance Student's Week
          </div>
        <form method="POST">
            <input type="text" name="stud_id" id="studentId" placeholder="Student-ID" />
            <button type="button" id="timeInBtn" class="btn btn-success" style="width: 100%">Time-IN</button>
            <button type="button" id="timeOutBtn" class="btn btn-danger" style="width: 100%">Time-OUT</button>
            <div class="cont d-flex justify-content-center align-items-center">
              <h4 class="result" id="display"></h4>
            </div>
          </form>
          </div>
      </div>
    </div>
  </body>
</html>

<script>
 document.getElementById('timeInBtn').addEventListener('click', function() {
        var studentId = document.getElementById('studentId').value;
        
        // AJAX request to fetch student info
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var studentInfo = xhr.responseText;
                    document.getElementById('display').innerText =  studentInfo;
                } else {
                    console.error('Error fetching student info');
                }
            }
        };
        xhr.open('GET', 'get.php?stud_id=' + studentId);
        xhr.send();
    });

    document.getElementById('timeOutBtn').addEventListener('click', function() {
    var studentId = document.getElementById('studentId').value;

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
 
</script>
<style>
  html,
  body {
    height: 100%;
  }
  .container-fluid {
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
