  <!DOCTYPE html>
  <html lang="en">
    <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>Tatay Cipher</title>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
      
    </head>
    <body>
      <nav class="navbar navbar-light bg-dark">
        <span class="navbar-brand h1 text-light">Attendance</span>
      </nav>

      <div class="container-fluid" style="height:100vh;">
        <div class="row">
          <div class="col-sm-12 text-center" style="display: flex; flex-direction: column; align-items: center;">
            <form method="POST" id="attendanceForm">
              <input type="text" name="stud_id" id="studentId" placeholder="Student-ID" />
              <input type="hidden" name="activity_id" id="activityId" value="" />
              <div>
                <h4 id="activityName" class="text-center mt-3"></h4>
              </div>
              <button type="button" id="timeInBtn" class="btn btn-success" style="width: 100%">Time-IN</button>
              <div class="cont d-flex justify-content-center align-items-center">
                <h4 class="result" id="display"></h4>
              </div>
            </form>
            <form method="POST" action="/ccsict-attendance/cipher/cellseminar.php">
              <button type="submit" class="btn btn-dark mt-5" name="submit">
            </form>
            Export Excel
            </button>
          </div>
        </div>
      </div>

      <script>
        window.onload = function() {
          var url = window.location.href;
          var activityId = url.split('/').pop();  
          document.getElementById('activityId').value = activityId;

          // Display corresponding activity name
          var activityNames = {
            "1": "Campus Talk & Software Engineering",
            "2": "The Sexiest Job of 21st Century - Data Science and Analytics",
            "3": "AWS/Campus Talk",
            "4": "Artificial Intelligence",
            "5": "Cloud-Based Application",
            "6": "Cyber Security 2",
            "7": "Web 3 and Blockchain"
          };

          document.getElementById('activityName').innerText = activityNames[activityId] || "Unknown Activity";
        };

        document.getElementById('timeInBtn').addEventListener('click', function() {
          var studentId = document.getElementById('studentId').value;
          var activityId = document.getElementById('activityId').value;

          if (!studentId) {
            document.getElementById('display').innerText = "Please enter a Student ID.";
            return;
          }

          var xhr = new XMLHttpRequest();
          xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
              console.log(xhr.responseText);
              if (xhr.status === 200) {
                var studentInfo = xhr.responseText;
                document.getElementById('display').innerText = studentInfo;
              } else {
                console.error('Error fetching student info');
              }
            }
          };
          xhr.open('GET', '/ccsict-attendance/cipher/post.php?stud_id=' + studentId + '&activity_id=' + activityId);

          xhr.send();
        });
      </script>

      <style>
        html,
        body {
          height: 100%;
          overflow: hidden;
        }
        .navbar {
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
    </body>
  </html>
