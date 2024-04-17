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
        <div class="col-sm-6 text-center m-auto">
          <div class="h1 text-primary" style="font-size: 50px">
            Attendance Students Week
          </div>
        </div>
        <div
          class="col-sm-6 text-center"
          style="display: flex; flex-direction: column"
        >
          <input type="text" id="plain" placeholder="Student-ID" />
          <button id="lock" class="btn btn-primary">Time-IN</button>
          <div class="cont d-flex justify-content-center align-items-center">
            <h4 class="result" id="display">Student's Info</h4>
          </div>
          <button id="clear" class="btn btn-dark mt-2">Confirm</button>
        </div>
      </div>
    </div>
  </body>
</html>

<script>
  let encryption = document.getElementById("lock"); //button for encryption
  let decryption = document.getElementById("unlock"); //button for decryption
  let clear = document.getElementById("clear");

  //function for button encryption to proceed with the encrypting process
  clear.onclick = () => {
    document.getElementById("plain").value = "";
    document.getElementById("key").value = "";
    document.getElementById("display").textContent = "Result";
  };
  encryption.onclick = () => {
    let plaintext = document.getElementById("plain").value;
    let keyword = document.getElementById("key").value;
    let ciphertext = vigenereEncrypt(plaintext, keyword);

    if (plaintext == "" || keyword == "") {
      alert("Please add value!");
    } else {
      document.getElementById("display").innerHTML = ciphertext;
    }
  };

  function vigenereEncrypt(plaintext, keyword) {
    const alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    let input = plaintext.toUpperCase();
    let key = keyword.toUpperCase();

    let result = "";
    let keyIndex = 0;

    for (let i = 0; i < input.length; i++) {
      let char = input[i];
      if (alphabet.includes(char)) {
        let charIndex = alphabet.indexOf(char);
        let keyCharIndex = alphabet.indexOf(key[keyIndex % key.length]);
        let encryptedCharIndex = (charIndex + keyCharIndex) % alphabet.length;

        result += alphabet[encryptedCharIndex];
        keyIndex++;
      } else {
        result += char;
      }
    }

    return result;
  }

  //function for button decryption to proceed with the decryption process
  decryption.onclick = () => {
    let plaintext = document.getElementById("plain").value;
    let keyword = document.getElementById("key").value;
    let ciphertext = vigenereEncrypt(plaintext, keyword);
    let decryptedPlainText = vigenereDecrypt(ciphertext, keyword);
    console.log(ciphertext);
    document.getElementById("display").innerHTML = decryptedPlainText;
  };

  //decryption method
  function vigenereDecrypt(ciphertext, keyword) {
    const alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    var input = ciphertext.toUpperCase();
    var key = keyword.toUpperCase();

    let result = "";
    let keyIndex = 0;

    for (let i = 0; i < input.length; i++) {
      const char = input[i];
      if (alphabet.includes(char)) {
        const charIndex = alphabet.indexOf(char);
        const keyCharIndex = alphabet.indexOf(key[keyIndex % key.length]);
        const decryptedCharIndex =
          (charIndex - keyCharIndex + alphabet.length) % alphabet.length;

        result += alphabet[decryptedCharIndex];
        keyIndex++;
      } else {
        result += char;
      }
    }

    return result;
  }
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